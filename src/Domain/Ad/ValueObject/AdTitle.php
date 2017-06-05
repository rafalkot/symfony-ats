<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\ValueObject;

use Ats\Domain\Ad\Exception\AdTitleIsEmptyException;

class AdTitle
{
    /**
     * @var string
     */
    private $title;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->validate($title);

        $this->title = $title;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title();
    }

    /**
     * @param AdTitle $title
     * @return bool
     */
    public function equals(AdTitle $title): bool
    {
        return $this->title == $title->title();
    }

    protected function validate($title)
    {
        if (empty($title)) {
            throw new AdTitleIsEmptyException();
        }
    }
}