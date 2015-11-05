<?php

namespace Test\Event;

use Buttercup\Protects\IdentifiesAggregate;
use Mockery as m;
use Event\MoneyWasAddedToAccount;
use PHPUnit_Framework_Error;

class MoneyWasAddedToAccountTest extends \PHPUnit_Framework_TestCase
{
    const EXAMPLE_AMOUNT = 1000;

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testNewMoneyAddedEventFailsWhenImproperAccountisGiven()
    {
        new MoneyWasAddedToAccount("", 0.4);
    }

    public function testCreateNewEventWithCorrectAccountId()
    {
        /** @var IdentifiesAggregate|m\MockInterface $identifiesAggregateMock */
        $identifiesAggregateMock = m::mock('Buttercup\Protects\IdentifiesAggregate');
        $moneyAddEvent = new MoneyWasAddedToAccount($identifiesAggregateMock, self::EXAMPLE_AMOUNT);

        $this->assertEquals($identifiesAggregateMock, $moneyAddEvent->getAggregateId());
        $this->assertEquals(self::EXAMPLE_AMOUNT, $moneyAddEvent->getAmount());
        $this->assertTrue($moneyAddEvent->getDate() instanceof \DateTime);
    }
}
