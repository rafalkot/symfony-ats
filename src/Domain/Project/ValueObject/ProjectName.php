<?php

declare(strict_types=1);

namespace Ats\Domain\Project\ValueObject;

use Ats\Domain\Project\Exception\ProjectNameIsEmptyException;

class ProjectName
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->validate($name);

        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name();
    }

    /**
     * @param ProjectName $name
     * @return bool
     */
    public function equals(ProjectName $name): bool
    {
        return $this->name == $name->name();
    }

    protected function validate($name)
    {
        if (empty($name)) {
            throw new ProjectNameIsEmptyException();
        }
    }
}