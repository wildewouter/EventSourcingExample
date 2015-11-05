<?php


namespace Command;


use Buttercup\Protects\IdentifiesAggregate;

class AddMoneyToAccount extends Transaction
{
    public function __construct($amount, IdentifiesAggregate $accountId)
    {
        parent::__construct($amount, $accountId);
    }
}