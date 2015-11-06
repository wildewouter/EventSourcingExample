<?php


namespace Aggregate;


interface AccountAggregateRoot
{
    /**
     * @param float $amount
     */
    public function addMoneyToAccount($amount);

    /**
     * @param float $amount
     */
    public function deductMoneyFromAccount($amount);

    /**
     * @return AccountAggregateRoot
     */
    public static function createAccount();
}