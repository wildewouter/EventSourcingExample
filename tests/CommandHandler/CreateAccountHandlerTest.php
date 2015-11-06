<?php


namespace Test\CommandHandler;


use Command\CreateAccount;
use CommandHandler\CreateAccountHandler;
use Mockery as m;

class CreateAccountHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }

    public function testHandlerHandlesCommand()
    {
        /** @var CreateAccount|m\MockInterface $commandMock */
        $commandMock = m::mock('Command\CreateAccount');
        $commandMock->shouldReceive('createAccount')->once();

        $handler = new CreateAccountHandler();
        $handler->handleCommand($commandMock);
    }
}
