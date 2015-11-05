<?php


namespace Event;


use Buttercup\Protects\DomainEvent;
use Buttercup\Protects\IdentifiesAggregate;

class AccountWasOpened implements DomainEvent
{
    /** @var IdentifiesAggregate */
    private $accountId;

    public function __construct(IdentifiesAggregate $accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * The Aggregate this event belongs to.
     * @return IdentifiesAggregate
     */
    public function getAggregateId()
    {
        return $this->accountId;
    }
}