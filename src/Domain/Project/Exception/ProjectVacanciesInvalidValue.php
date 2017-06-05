<?php

namespace Ats\Domain\Project\Exception;

class ProjectVacanciesInvalidValue extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Project vacancies value is invalid');
    }
}