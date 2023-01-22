<?php
declare (strict_types=1);

namespace App\Api\Errors;

use JsonException;

class ApiError
{
    public function __construct(private string $message)
    {
    }

    public function getMessage() : string
    {
        return $this->message;
    }

    public function getError() : array
    {
        return [
            'error' => [
                'message' => $this->getMessage()
            ]
        ];
    }

}