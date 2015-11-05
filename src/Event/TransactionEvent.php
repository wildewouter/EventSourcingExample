<?php


namespace Event;

use Buttercup\Protects\DomainEvent;
use Buttercup\Protects\IdentifiesAggregate;

abstract class TransactionEvent implements DomainEvent
{
    /** @var float */
    private $amount;

    /** @var IdentifiesAggregate */
    private $accountId;

    /** @var \DateTime */
    private $date;

    /**
     * TransactionEvent constructor.
     * @param IdentifiesAggregate $accountId
     * @param float $amount
     */
    public function __construct(IdentifiesAggregate $accountId, $amount)
    {
        $this->accountId = $accountId;
        $this->amount = $amount;
        $this->date = new \DateTime('now');
    }

    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId()
    {
        return $this->accountId;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}