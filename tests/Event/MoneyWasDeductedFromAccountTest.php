<?php


namespace Test\Event;

use Buttercup\Protects\IdentifiesAggregate;
use Mockery as m;
use Event\MoneyWasDeductedFromAccount;
use PHPUnit_Framework_Error;

class MoneyWasDeductedFromAccountTest extends \PHPUnit_Framework_TestCase
{
    const EXAMPLE_AMOUNT = 1000;

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testNewMoneyDeductedEventFailsWhenImproperAccountisGiven()
    {
        new MoneyWasDeductedFromAccount("", 0.4);
    }

    public function testCreateNewEventWithCorrectAccountId()
    {
        /** @var IdentifiesAggregate|m\MockInterface $identifiesAggregateMock */
        $identifiesAggregateMock = m::mock('Buttercup\Protects\IdentifiesAggregate');
        $moneyAddEvent = new MoneyWasDeductedFromAccount($identifiesAggregateMock, self::EXAMPLE_AMOUNT);

        $this->assertEquals($identifiesAggregateMock, $moneyAddEvent->getAggregateId());
        $this->assertEquals(self::EXAMPLE_AMOUNT, $moneyAddEvent->getAmount());
        $this->assertTrue($moneyAddEvent->getDate() instanceof \DateTime);
    }
}