<?php


namespace Aggregate;

/**
 * Immutable class
 */
class AccountBalance
{
    /** @var float */
    private $balance;

    /**
     * AccountBalance constructor.
     * @param float $balance
     * @throws \Exception
     */
    public function __construct($balance)
    {
        if (! is_float($balance)) {
            throw new \Exception("Balance should be float number");
        }
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