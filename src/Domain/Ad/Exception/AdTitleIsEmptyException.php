<?php

namespace Ats\Domain\Ad\Exception;

class AdTitleIsEmptyException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Ad title is empty');
    }
}