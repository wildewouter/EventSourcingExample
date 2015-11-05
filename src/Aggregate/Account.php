<?php

namespace Aggregate;

use Buttercup\Protects\AggregateHistory;
use Buttercup\Protects\DomainEvent;
use Buttercup\Protects\DomainEvents;
use Buttercup\Protects\IdentifiesAggregate;
use Buttercup\Protects\IsEventSourced;
use Buttercup\Protects\RecordsEvents;
use Event\AccountWasCreated;
use Event\MoneyWasAddedToAccount;
use Event\MoneyWasDeductedFromAccount;
use MemoryStorage\MemStorage;
use Ramsey\Uuid\Uuid;

final class Account implements RecordsEvents, IsEventSourced
{
    /** @var IdentifiesAggregate */
    private $accountId;

    /** @var AccountBalance */
    private $accountBalance;

    /** @var DomainEvent[] */
    private $recordedEvents = array();

    private function __construct(IdentifiesAggregate $accountId)
    {
        $this->accountId = $accountId;
        $this->accountBalance = new AccountBalance(0.0);
    }

    /**
     * @return AccountId
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @return AccountBalance
     */
    public function getAccountBalance()
    {
        return $this->accountBalance;
    }

    /**
     * @return Account
     */
    public static function createAccount()
    {
        $accountIdString = AccountId::fromString(Uuid::uuid1()->getHex());

        $account = new Account($accountIdString);
        $account->recordThat(new AccountWasCreated($accountIdString));

        return $account;
    }

    /**
     * @param AggregateHistory $history
     * @return Account
     */
    public static function reconstituteFrom(AggregateHistory $history)
    {
        $accountId = $history->getAggregateId();
        $account = new Account($accountId);

        foreach ($history as $event) {
            $account->apply($event);
        }

        return $account;
    }

    public function addMoneyToAccount($amount)
    {
        $this->recordThat(new MoneyWasAddedToAccount($this->accountId, $amount));
    }

    public function deductMoneyFromAccount($amount)
    {
        $this->recordThat(new MoneyWasDeductedFromAccount($this->accountId, $amount));
    }

    /**
     * Get all the Domain Events that were recorded since the last time it was cleared, or since it was
     * restored from persistence. This does not include events that were recorded prior.
     * @return DomainEvents
     */
    public function getRecordedEvents()
    {
        return $this->recordedEvents;
    }

    /**
     * Clears the record of new Domain Events. This doesn't clear the history of the object.
     * @return void
     */
    public function clearRecordedEvents()
    {
        $this->recordedEvents = array();
    }

    /**
     * @param AccountWasCreated $event
     */
    private function applyAccountWasCreated(AccountWasCreated $event)
    {
        // TODO: Implement this
    }

    /**
     * @param MoneyWasAddedToAccount $event
     */
    private function applyMoneyWasAddedToAccount(MoneyWasAddedToAccount $event)
    {
        $this->accountBalance = $this->accountBalance->add($event->getAmount());
    }

    /**
     * @param MoneyWasDeductedFromAccount $event
     */
    private function applyMoneyWasDeductedFromAccount(MoneyWasDeductedFromAccount $event)
    {
        $this->accountBalance = $this->accountBalance->deduct($event->getAmount());
    }

    private function apply(DomainEvent $event)
    {
        $method = 'apply' . $this->getClassName($event);
        $this->$method($event);
    }

    /**
     * @param DomainEvent $event
     */
    private function recordThat($event)
    {
        $this->recordedEvents[] = $event;
        $this->apply($event);
        $eventsInMem = $this->getEventsFromMemory($event);

        MemStorage::$eventStore
        [$event->getAggregateId()->__toString()]
            = array_merge($eventsInMem, array($event));
    }

    public function __call($name, $arguments)
    {
        throw new \Exception("Handling of event not implemented");
    }

    public function getClassName($obj) {
        $classname = get_class($obj);

        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }

        return $classname;
    }

    /**
     * @param DomainEvent $event
     * @return array
     */
    private function getEventsFromMemory(DomainEvent $event)
    {
        if (! isset(MemStorage::$eventStore[$event->getAggregateId()->__toString()])) {
            return array();
        }

        $eventsInMem = MemStorage::$eventStore[$event->getAggregateId()->__toString()];

        return $eventsInMem;
    }
}