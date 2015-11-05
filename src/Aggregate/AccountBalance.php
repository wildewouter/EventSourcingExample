<?php


namespace Aggregate;

/**
 * Immutable class
 */
class AccountBalance
{
    /** @var float */
    private $balance;

    public function __construct($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @param float $amount
     * @return AccountBalance
     */
    public function add($amount)
    {
        return new AccountBalance($this->balance + $amount);
    }

    /**
     * @param float $amount
     * @return AccountBalance
     */
    public function deduct($amount)
    {
        return new AccountBalance($this->balance - $amount);
    }

    public function __toString()
    {
        return (string) $this->balance;
    }
}