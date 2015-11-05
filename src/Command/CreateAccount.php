<?php

namespace Command;

use Aggregate\Account;

class CreateAccount implements Command
{
    private $account;

    public function getAccount()
    {
        return $this->account;
    }

    public function createAccount()
    {
        $this->account = Account::createAccount();
    }
}