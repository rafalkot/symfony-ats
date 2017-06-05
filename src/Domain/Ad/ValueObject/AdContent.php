<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\ValueObject;

use Ats\Domain\Ad\Exception\AdContentIsEmptyException;

class AdContent
{
    /**
     * @var string
     */
    private $content;

    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->validate($content);

        $this->content = $content;
    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->content();
    }

    /**
     * @param AdContent $content
     * @return bool
     */
    public function equals(AdContent $content): bool
    {
        return $this->content == $content->content();
    }

    protected function validate($content)
    {
        if (empty($content)) {
            throw new AdContentIsEmptyException();
        }
    }
}