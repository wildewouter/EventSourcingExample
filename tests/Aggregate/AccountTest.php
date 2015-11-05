<?php


namespace Test\Aggregate;


use Aggregate\Account;
use Aggregate\AccountBalance;
use Aggregate\AccountId;
use Buttercup\Protects\AggregateHistory;
use Event\AccountWasCreated;
use Event\MoneyWasAddedToAccount;
use Event\MoneyWasDeductedFromAccount;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    public function testAccountShouldHaveAccountIdOnCreate()
    {
        $account = Account::createAccount();

        $this->assertTrue($account->getAccountId() instanceof AccountId);
    }

    public function testAccountShouldHaveAccountBalanceOnCreate()
    {
        $account = Account::createAccount();

        $this->assertTrue($account->getAccountBalance() instanceof AccountBalance);
    }

    public function testAccountShouldHaveCreatedEventUponCreate()
    {
        $account = Account::createAccount();

        $this->checkIfEventIsAvailabe($account, AccountWasCreated::class);
    }

    public function testAccountHasMoneyAddedEventWhenMoneyIsAdded()
    {
        $account = Account::createAccount();

        $account->addMoneyToAccount(1000);

        $this->checkIfEventIsAvailabe($account, MoneyWasAddedToAccount::class);
    }

    public function testAccountHasMoneyDeductedEventWhenMoneyIsDeducted()
    {
        $account = Account::createAccount();

        $account->deductMoneyFromAccount(1000);

        $this->checkIfEventIsAvailabe($account, MoneyWasDeductedFromAccount::class);
    }

    public function testReconstitutedFromHistoryIsOldAccount()
    {
        $accountId = AccountId::fromString('asdf');

        $history = array(
            new AccountWasCreated($accountId),
            new MoneyWasAddedToAccount($accountId, 1000),
            new MoneyWasDeductedFromAccount($accountId, 50)
        );

        $aggregateHistory = new AggregateHistory($accountId, $history);

        $account = Account::reconstituteFrom($aggregateHistory);
        $this->assertTrue($account instanceof Account);
        $this->assertEquals(950, $account->getAccountBalance()->__toString());
    }

    public function testRecordedEventsHaveBeenClearedForAggregateOnClear()
    {
        $account = Account::createAccount();
        $this->playHistoryOnAccount($account);

        $account->clearRecordedEvents();
        $this->assertTrue(empty($account->getRecordedEvents()));
    }

    /**
     * @expectedException \Exception
     * @expectedMessage Handling of event not implemented
     */
    public function testShouldReceiveExceptionWhenUnkownEventIsTriggered()
    {
        $account = Account::createAccount();

        $account->applyUnkownEvent();
    }

    private function playHistoryOnAccount(Account $account)
    {
        $account->addMoneyToAccount(1000);
        $account->deductMoneyFromAccount(750);
        $account->addMoneyToAccount(100);
    }

    /**
     * @param Account $account
     * @param string $eventClassName
     */
    private function checkIfEventIsAvailabe($account, $eventClassName)
    {
        $isEventAvailable = false;

        foreach ($account->getRecordedEvents() as $event) {
            if ($event instanceof $eventClassName) {
                $isEventAvailable = true;
            }
        }

        $this->assertTrue($isEventAvailable);
    }
}
