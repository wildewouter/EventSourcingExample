<?php

use Buttercup\Protects\AggregateHistory;
use MemoryStorage\MemStorage;

require_once __DIR__ . '/vendor/autoload.php';

$createCommandHandler = new \CommandHandler\CreateAccountHandler();
$createCommand = new \Command\CreateAccount();
$createCommandHandler->handleCommand($createCommand);

$account = $createCommand->getAccount();
$accountId = $account->getAccountId();

$addMoneyToAccountCommand = new \Command\AddMoneyToAccount(1000, $accountId);
$addMoneyCommandHandler = new \CommandHandler\AddMoneyToAccountHandler();
$addMoneyCommandHandler->handleCommand($addMoneyToAccountCommand);

$addMoneyToAccountCommand2 = new \Command\AddMoneyToAccount(4000, $accountId);
$addMoneyCommandHandler->handleCommand($addMoneyToAccountCommand2);

$aggregateId = $accountId;

$history = new AggregateHistory($aggregateId, MemStorage::$eventStore[$accountId->__toString()]);

$account = \Aggregate\Account::reconstituteFrom($history);

echo $account->getAccountBalance()->__toString();