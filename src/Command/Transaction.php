<?php


namespace Command;


use Aggregate\Account;
use Buttercup\Protects\AggregateHistory;
use Buttercup\Protects\IdentifiesAggregate;
use MemoryStorage\MemStorage;

abstract class Transaction implements Command
{
    /** @var float */
    private $amount;

    /**
     * @var Account
     */
    private $account;

    /**
     * Transaction constructor.
     * @param float $amount
     * @param IdentifiesAggregate $accountId
     */
    public function __construct($amount, IdentifiesAggregate $accountId)
    {
        $this->amount = $amount;
        $retrievedEvents = MemStorage::$eventStore[$accountId->__toString()];

        $aggregateId = $accountId;

        $history = new AggregateHistory($aggregateId, $retrievedEvents);

        $this->account = Account::reconstituteFrom($history);
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getAccount()
    {
        return $this->account;
    }
}