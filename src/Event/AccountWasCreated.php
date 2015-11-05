<?php


namespace Event;

use Buttercup\Protects\IdentifiesAggregate;

final class AccountWasCreated extends AccountExistanceEvent
{
    public function __construct(IdentifiesAggregate $accountId)
    {
        parent::__construct($accountId);
    }
}