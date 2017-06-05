<?php

namespace Ats\Domain\Ad\Exception;

class AdPublicationEndDateIsEarlierThanStartDate extends \DomainException
{
    public function __construct()
    {
        parent::__construct('End date is earlier (or same) than start date');
    }
}