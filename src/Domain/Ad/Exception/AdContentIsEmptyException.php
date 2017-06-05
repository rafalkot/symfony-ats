<?php

namespace Ats\Domain\Ad\Exception;

class AdContentIsEmptyException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Ad content is empty');
    }
}