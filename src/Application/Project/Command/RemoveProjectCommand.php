<?php

namespace Ats\Application\Project\Command;

class RemoveProjectCommand
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }
}
