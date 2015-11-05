<?php


namespace Test\Command;


use Aggregate\Account;
use Command\AddMoneyToAccount;

class AddMoneyToAccountTest extends \PHPUnit_Framework_TestCase
{
    public function testCommandHasAccountOnCreate()
    {
        $account = Account::createAccount();
        $moneyAddCommand = new AddMoneyToAccount(1000, $account->getAccountId());

        $this->assertTrue($moneyAddCommand->getAccount() instanceof Account);
    }

    public function testAddMoneyToExistingAccountWithMoneyHasTheEarlierGrantedMoney()
    {
        $account = Account::createAccount();
        $account->addMoneyToAccount(750);

        $moneyAddCommand = new AddMoneyToAccount(1000, $account->getAccountId());

        $balance = $moneyAddCommand->getAccount()->getAccountBalance()->__toString();
        $this->assertEquals(750, $balance);
    }

    public function testAddMoneyCommandActuallyAddsTheAmountThatIsGiven()
    {
        $account = Account::createAccount();
        $moneyAddCommand = new AddMoneyToAccount(1234, $account->getAccountId());

        $this->assertSame(1234, $moneyAddCommand->getAmount());
    }
}
