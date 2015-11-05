<?php

namespace Command;

use Aggregate\Account;

class CreateAccount implements Command
{
    /** @var Account */
    private $account;

    public function __construct()
    {
        $this->account = Account::createAccount();
    }

    public function getAccount()
    {
        return $this->account;
    }
}