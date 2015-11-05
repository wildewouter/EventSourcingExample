<?php


namespace Command;


use Aggregate\Account;

interface Command
{
    /**
     * @return Account
     */
    public function getAccount();
}