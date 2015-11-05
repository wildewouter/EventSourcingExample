<?php

namespace CommandHandler;

use Command\CreateAccount;

class CreateAccountHandler
{
    public function handleCommand(CreateAccount $command)
    {
        $command->getAccount();
    }
}