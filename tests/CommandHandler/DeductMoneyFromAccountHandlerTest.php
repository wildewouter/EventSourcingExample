<?php


namespace Test\CommandHandler;

use Aggregate\AccountAggregateRoot;
use Command\AddMoneyToAccount;
use Command\DeductMoneyFromAccount;
use CommandHandler\DeductMoneyFromAccountHandler;
use Mockery as m;
use PHPUnit_Framework_Error;

class DeductMoneyFromAccountHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testCommandIsHandled()
    {
        $exampleAmount = 200;

        /** @var AccountAggregateRoot|m\MockInterface $accountMock */
        $accountMock = m::mock('Aggregate\AccountAggregateRoot');
        $accountMock->shouldReceive('addMoneyToAccount')
            ->once()
            ->with($exampleAmount);

        /** @var DeductMoneyFromAccount|m\MockInterface $commandMock */
        $commandMock = m::mock('Command\DeductMoneyFromAccount');
        $commandMock->shouldReceive('getAccount')
            ->once()
            ->andReturn($accountMock);
        $commandMock->shouldReceive('getAmount')
            ->once()
            ->andReturn($exampleAmount);

        $commandHandler = new DeductMoneyFromAccountHandler();
        $commandHandler->handleCommand($commandMock);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testHandleCommandOnlyAcceptsDeductCommand()
    {
        $command = new AddMoneyToAccount(1000, 234);

        $commandHandler = new DeductMoneyFromAccountHandler();
        $commandHandler->handleCommand($command);
    }
}
