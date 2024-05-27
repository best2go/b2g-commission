<?php

use Best2Go\Best2GoCommission\InputStream\FileInputStream;
use Best2Go\Best2GoCommission\InputStream\InputStream;
use Best2Go\Best2GoCommission\Transaction\TransactionFactoryInterface;
use Best2Go\Best2GoCommission\Transaction\TransactionProcessorInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Output\ConsoleOutput;

if (!in_array(PHP_SAPI, ['cli', 'phpdbg', 'embed'], true)) {
    echo 'Warning: The console should be invoked via the CLI version of PHP, not the ' . PHP_SAPI . ' SAPI' . PHP_EOL;
}

set_time_limit(0);

require __DIR__ . '/vendor/autoload.php';

$container = require_once __DIR__ . '/bootstrap.php';

$factory = $container[TransactionFactoryInterface::class];
$stream = new InputStream(new FileInputStream($argv[1], $factory));

/*
$stream = new InputStream(new ArrayInputStream([
    $factory->create(['bin' => '45717360', 'amount' => 100.00, 'currency' => 'EUR']),
    $factory->create(['bin' => '516793', 'amount' => 50.00, 'currency' => 'USD']),
    $factory->create(['bin' => '45417360', 'amount' => 10000.00, 'currency' => 'JPY']),
    $factory->create(['bin' => '41417360', 'amount' => 130.00, 'currency' => 'USD']),
    $factory->create(['bin' => '4745030', 'amount' => 2000.00, 'currency' => 'GBP']),
]));
*/

/** @var TransactionProcessorInterface $processor */
$processor = $container[TransactionProcessorInterface::class];
$table = createTable();
foreach ($stream as $transaction) {
    $processor->process($transaction);

    $table->addRow([
        $transaction->getBin(),
        $transaction->hasCountry() ? $transaction->getCountry() : null,
        sprintf('%.2f', $transaction->getAmount()),
        $transaction->getCurrency(),
        $transaction->hasFee() ? sprintf('%.2f', $transaction->getFee()) : null,
        $transaction->getMessage(),
    ]);
}
$table->render();

function createTable(): Table
{
    $output = new ConsoleOutput();
    $table = new Table($output);
    $table->setHeaders(['bin', 'country', 'amount', 'currency', 'fee', 'message']);
    $table->setColumnWidths([6, 2, 12, 3, 6]);

    $alignRight = new TableStyle();
    $alignRight->setPadType(STR_PAD_LEFT);

    $table->setColumnStyle(2, $alignRight);
    $table->setColumnStyle(4, $alignRight);

    return $table;
}