<?php


namespace Test\Aggregate;


use Aggregate\AccountBalance;

class AccountBalanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Balance should be float number
     */
    public function testBalanceShouldReceiveNumber()
    {
        new AccountBalance((int) 19);
    }

    public function testAddAmountToBalanceCreatesNewBalance()
    {
        $balance = new AccountBalance(0.0);
        $newBalance = $balance->add(1000);

        $this->assertNotSame($balance, $newBalance);

        $expectedBalanceOutcome = "1000";
        $this->assertEquals($expectedBalanceOutcome, $newBalance->__toString());
    }

    public function testDeductAmountFromBalanceCreatesNewBalance()
    {
        $balance = new AccountBalance(0.0);
        $newBalance = $balance->deduct(1000);

        $this->assertNotSame($balance, $newBalance);

        $expectedBalanceOutcome = "-1000";
        $this->assertEquals($expectedBalanceOutcome, $newBalance->__toString());
    }

    public function testToStringActuallyReturnsString()
    {
        $balance = new AccountBalance(0.0);
        $this->assertTrue(is_string($balance->__toString()));
    }
}
