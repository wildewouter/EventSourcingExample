<?php


namespace Aggregate;
use Exception\IncorrectTypeException;

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
     * @throws IncorrectTypeException
     */
    public function __construct($balance)
    {
        if (! is_float($balance)) {
            throw new IncorrectTypeException("Balance should be float number");
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