<?php
declare (strict_types=1);

namespace App\Exception;

use Exception;
use Throwable;

class ClassMethodNotImplementedException extends Exception
{
    public function __construct(string $class, string $method, int $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf(
                'Method %s() not found in class %s. Please implement the required method in order to proceed.',
                $method,
                $class
            ),
            $code,
            $previous
        );
    }
}