<?php

declare(strict_types=1);

namespace Best2Go\Best2GoCommission\Transaction;

final class Transaction
{
    private string $bin;
    private string $currency;
    private float $amount;
    private ?string $country;
    private ?float $commission;
    private ?float $fee;
    private ?float $rate;
    private ?string $message;

    public function setBin(string $bin): void
    {
        $this->bin = $bin;
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setCommission(float $commission): void
    {
        $this->commission = $commission;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function hasCommission(): bool
    {
        return isset($this->commission);
    }

    public function setFee(float $fee): void
    {
        $this->fee = $fee;
    }

    public function getFee(): float
    {
        return $this->fee;
    }

    public function hasFee(): bool
    {
        return isset($this->fee);
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function hasRate(): bool
    {
        return isset($this->rate);
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function hasCountry(): bool
    {
        return isset($this->country);
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function hasMessage(): bool
    {
        return isset($this->message);
    }
}
