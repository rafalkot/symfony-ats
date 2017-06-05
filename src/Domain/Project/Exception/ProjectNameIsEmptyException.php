<?php

namespace Ats\Domain\Project\Exception;

class ProjectNameIsEmptyException extends \DomainException
{
    public function __construct()
    {
        parent::__construct('Project name is empty');
    }
}