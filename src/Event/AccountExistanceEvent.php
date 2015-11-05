<?php


namespace Event;


use Buttercup\Protects\DomainEvent;
use Buttercup\Protects\IdentifiesAggregate;

abstract class AccountExistanceEvent implements DomainEvent
{
    /** @var IdentifiesAggregate */
    private $accountId;

    /** @var \DateTime */
    private $date;

    public function __construct(IdentifiesAggregate $accountId)
    {
        $this->accountId = $accountId;
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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}