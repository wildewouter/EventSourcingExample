<?php


namespace Test\CommandHandler;


use Aggregate\AccountAggregateRoot;
use Command\AddMoneyToAccount;
use Command\DeductMoneyFromAccount;
use CommandHandler\AddMoneyToAccountHandler;
use Mockery as m;
use PHPUnit_Framework_Error;

class AddMoneyToAccountHandlerTest extends \PHPUnit_Framework_TestCase
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

        /** @var AddMoneyToAccount|m\MockInterface $commandMock */
        $commandMock = m::mock('Command\AddMoneyToAccount');
        $commandMock->shouldReceive('getAccount')
            ->once()
            ->andReturn($accountMock);
        $commandMock->shouldReceive('getAmount')
            ->once()
            ->andReturn($exampleAmount);

        $commandHandler = new AddMoneyToAccountHandler();
        $commandHandler->handleCommand($commandMock);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testHandleCommandOnlyAcceptsDeductCommand()
    {
        $command = new DeductMoneyFromAccount(1000, 234);

        $commandHandler = new AddMoneyToAccountHandler();
        $commandHandler->handleCommand($command);
    }
}
