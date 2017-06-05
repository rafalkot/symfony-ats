<?php

declare(strict_types=1);

namespace Ats\Application\Core\View;

abstract class AbstractView
{
    public function __construct($data)
    {
        foreach ($data as $key => $val) {
            $this->{$key} = $val;
        }
    }
}