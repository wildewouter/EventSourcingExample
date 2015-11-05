<?php


namespace Test\Command;


use Aggregate\Account;
use Command\CreateAccount;


class CreateAccountTest extends \PHPUnit_Framework_TestCase
{
    public function testIfAccountIsNotCreatedOnInstantiate()
    {
        $createCommand = new CreateAccount();
        $this->assertTrue(is_null($createCommand->getAccount()));
    }

    public function testIfAccountIsCreatedOnCreateAccount()
    {
        $createCommand = new CreateAccount();
        $createCommand->createAccount();
        $account = $createCommand->getAccount();

        $this->assertTrue($account instanceof Account);
    }
}
