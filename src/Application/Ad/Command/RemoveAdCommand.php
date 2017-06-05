<?php

namespace Ats\Application\Ad\Command;

class RemoveAdCommand
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
