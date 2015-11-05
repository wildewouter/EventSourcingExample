<?php


namespace CommandHandler;


use Command\Command;

class TransactionHandler
{
    /**
     * @param Command $command
     */
    public function handleCommand($command)
    {
        $command->getAccount();
    }
}