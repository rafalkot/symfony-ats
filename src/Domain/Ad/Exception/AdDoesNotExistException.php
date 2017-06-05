<?php

namespace Ats\Domain\Ad\Exception;

use Ats\Domain\Common\Exception\EntityDoesNotExistException;

class AdDoesNotExistException extends EntityDoesNotExistException
{
    public function __construct()
    {
        parent::__construct('Ad does not exist');
    }
}