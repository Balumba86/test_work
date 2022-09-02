<?php

namespace App\Dto;

class BalanceResponse
{
    private $amount;
    private $type = 'success';

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'amount' => $this->amount
        ];
    }
}
