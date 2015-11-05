<?php


namespace CommandHandler;


use Command\DeductMoneyFromAccount;

class DeductMoneyFromAccountHandler
{
    public function handleCommand(DeductMoneyFromAccount $command)
    {
        $account = $command->getAccount();
        $account->addMoneyToAccount($command->getAmount());
    }
}