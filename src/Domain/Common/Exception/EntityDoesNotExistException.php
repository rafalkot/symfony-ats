<?php

namespace Ats\Domain\Common\Exception;

use Throwable;

class EntityDoesNotExistException extends \Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}