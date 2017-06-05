<?php

namespace Ats\Domain\Project\Exception;

use Ats\Domain\Common\Exception\EntityDoesNotExistException;

class ProjectDoesNotExistException extends EntityDoesNotExistException
{
    public function __construct()
    {
        parent::__construct('Project does not exist');
    }
}