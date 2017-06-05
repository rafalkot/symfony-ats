<?php

declare(strict_types=1);

namespace Ats\Application\Core\View;

class ViewCollection extends \ArrayIterator
{
    public function models()
    {
        return $this->getArrayCopy();
    }
}
