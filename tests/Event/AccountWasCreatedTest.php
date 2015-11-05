<?php


namespace Test\Event;

use Buttercup\Protects\IdentifiesAggregate;
use Mockery as m;
use Event\AccountWasCreated;
use PHPUnit_Framework_Error;

class AccountWasCreatedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testEventFailsWhenImproperAccountisGiven()
    {
        new AccountWasCreated(null);
    }

    public function testAccountWasCreatedEventCorrect()
    {
        /** @var IdentifiesAggregate|m\MockInterface $identifiesAggregateMock */
        $identifiesAggregateMock = m::mock('Buttercup\Protects\IdentifiesAggregate');
        $accountWasCreatedEvent = new AccountWasCreated($identifiesAggregateMock);

        $this->assertTrue($accountWasCreatedEvent->getAggregateId() instanceof IdentifiesAggregate);
        $this->assertTrue($accountWasCreatedEvent->getDate() instanceof \DateTime);
    }
}
