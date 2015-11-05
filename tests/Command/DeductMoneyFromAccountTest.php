<?php


namespace Test\Command;


use Aggregate\Account;
use Command\DeductMoneyFromAccount;

class DeductMoneyFromAccountTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandHasAccountOnCreate()
    {
        $account = Account::createAccount();
        $moneyDeductCommand = new DeductMoneyFromAccount(1000, $account->getAccountId());

        $this->assertTrue($moneyDeductCommand->getAccount() instanceof Account);
    }

    public function testAddMoneyToExistingAccountWithMoneyHasTheEarlierGrantedMoney()
    {
        $account = Account::createAccount();
        $account->DeductMoneyFromAccount(750);

        $moneyDeductCommand = new DeductMoneyFromAccount(1000, $account->getAccountId());

        $balance = $moneyDeductCommand->getAccount()->getAccountBalance()->__toString();
        $this->assertEquals(-750, $balance);
    }

    public function testAddMoneyCommandActuallyAddsTheAmountThatIsGiven()
    {
        $account = Account::createAccount();
        $moneyDeductCommand = new DeductMoneyFromAccount(1234, $account->getAccountId());

        $this->assertSame(1234, $moneyDeductCommand->getAmount());
    }
}
