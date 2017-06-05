<?php

declare(strict_types=1);

namespace Ats\Domain\Common\ValueObject;

abstract class Id
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->id;
    }

    /**
     * @param Id $id
     * @return bool
     */
    public function equals(Id $id): bool
    {
        return $this->id == $id->getId();
    }
}