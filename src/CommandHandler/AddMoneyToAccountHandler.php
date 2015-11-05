<?php


namespace CommandHandler;


use Command\AddMoneyToAccount;

class AddMoneyToAccountHandler
{
    public function handleCommand(AddMoneyToAccount $command)
    {
        $account = $command->getAccount();
        $account->addMoneyToAccount($command->getAmount());
    }
}