<?php

namespace App\Dto;

class ErrorResponse
{
    private $message;
    private $type = 'error';

    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    public function toArray()
    {
        return [
            'type' => $this->type,
            'message' => $this->message
        ];
    }
}
