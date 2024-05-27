<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\InputStream;

use Best2Go\Best2GoCommission\Transaction\TransactionFactory;
use Best2Go\Best2GoCommission\Transaction\TransactionFactoryInterface;
use RuntimeException;
use Traversable;

class FileInputStream implements InputStreamProvider
{
    private TransactionFactoryInterface $factory;
    private string $file;

    /** @var resource */
    private $stream;
    private bool $isOpen = false;

    public function __construct(string $file = 'php://stdin', TransactionFactoryInterface $factory = null)
    {
        $this->factory = $factory ?? new TransactionFactory();
        $this->file = $file;
    }

    public function getIterator(): Traversable
    {
        while ($this->isInputFileReadable()) {
            $row = fgets($this->getStream());
            if (empty($row)) {
                continue;
            }

            yield $this->factory->create(json_decode($row, true));
        }

        $this->closeInputFileResource();
    }

    protected function getInputFileCsv()
    {
        return fgetcsv($this->getStream());
    }

    protected function isInputFileReadable(): bool
    {
        $resource = $this->getStream();
        if ($this->isOpen) {
            return !feof($resource);
        }

        $read = [$resource];
        $write = [];
        $exception = [];

        $count = stream_select($read, $write, $exception, 0, 0);

        if ($count === false) {
            throw new RuntimeException('get file stream exception');
        }

        return $count === 1;
    }

    /** @return resource */
    protected function getStream()
    {
        if (is_resource($this->stream)) {
            return $this->stream;
        }

        switch ($this->file) {
            case '-':
            case 'php://input':
            case 'php://stdin':
                $this->isOpen = false;
                $this->stream = STDIN;
                break;

            default:
                $this->isOpen = true;
                $this->stream = fopen($this->file, 'r');
                break;
        }

        return $this->stream;
    }

    protected function closeInputFileResource(): void
    {
        if ($this->isOpen) {
            fclose($this->stream);
            $this->isOpen = false;
            $this->stream = null;
        }
    }
}
