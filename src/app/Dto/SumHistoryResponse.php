<?php

namespace App\Dto;

class SumHistoryResponse
{
    private $sum;
    private $reason;
    private $type = 'result';

    public function setSum(float $sum)
    {
        $this->sum = $sum;
    }

    public function setReason(string $reason)
    {
        $this->reason = $reason;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'sum' => $this->sum,
            'reason' => $this->reason
        ];
    }
}
