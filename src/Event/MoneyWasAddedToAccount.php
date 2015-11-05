<?php


namespace Event;

use Buttercup\Protects\IdentifiesAggregate;

final class MoneyWasAddedToAccount extends TransactionEvent
{
    /**
     * Added lines for code coverage report
     *
     * @param IdentifiesAggregate $accountId
     * @param float $amount
     */
    public function __construct(IdentifiesAggregate $accountId, $amount)
    {
        parent::__construct($accountId, $amount);
    }
}