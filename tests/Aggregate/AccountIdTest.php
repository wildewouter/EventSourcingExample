<?php


namespace Test\Aggregate;


use Aggregate\AccountId;
use Buttercup\Protects\IdentifiesAggregate;

class AccountIdTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructAnAccountIdFromString()
    {
        $expectedStringId = 'SomeExampleString';
        $accountId = AccountId::fromString($expectedStringId);

        $this->assertTrue($accountId instanceof IdentifiesAggregate);
        $this->assertEquals($expectedStringId, $accountId->__toString());
    }

    /**
     * @expectedException \Exception\IncorrectTypeException
     */
    public function testConstructAnAccountIdFromStringWithSomethingOtherThanString()
    {
        AccountId::fromString(array());
    }

    public function testEqualsOtherAggregateIdentifier()
    {
        $sameId = 'same, but different, still same';
        $accountId1 = AccountId::fromString($sameId);
        $accountId2 = AccountId::fromString($sameId);

        $this->assertTrue($accountId1->equals($accountId2));
    }

    public function testNotEqualsOtherAggregateIdentifier()
    {
        $notSameId1 = 'not same, different';
        $notSameId2 = 'same, oh no not same';
        $accountId1 = AccountId::fromString($notSameId1);
        $accountId2 = AccountId::fromString($notSameId2);

        $this->assertFalse($accountId1->equals($accountId2));
    }
}
