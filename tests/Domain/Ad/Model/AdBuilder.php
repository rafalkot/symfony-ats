<?php

declare(strict_types=1);

namespace Tests\Domain\Ad\Model;

use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\ValueObject\AdContent;
use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdPublication;
use Ats\Domain\Ad\ValueObject\AdTitle;
use Ats\Domain\Project\ValueObject\ProjectId;

class AdBuilder
{
    protected $id;

    protected $projectId;

    protected $title;

    protected $content;

    protected $publication;

    /**
     * AdBuilder constructor.
     */
    protected function __construct()
    {
        $this->id = AdId::generate();
        $this->title = new AdTitle('Ad title');
        $this->content = new AdContent('Ad content');
        $this->publication = AdPublication::fromString(date('Y-m-d'));
    }

    public static function anAd()
    {
        return new self();
    }

    public function withId($id)
    {
        $this->id = ($id instanceof AdId) ? $id : new AdId($id);

        return $this;
    }

    public function withProjectId($id)
    {
        $this->projectId = ($id instanceof ProjectId) ? $id : new ProjectId($id);

        return $this;
    }

    public function withTitle($title)
    {
        $this->title = ($title instanceof AdTitle) ? $title : new AdTitle($title);

        return $this;
    }

    public function withContent($content)
    {
        $this->content = ($content instanceof AdContent) ? $content : new AdContent($content);

        return $this;
    }

    public function withPublication($start, $end = null)
    {
        $this->publication = ($start instanceof AdPublication) ? $start : AdPublication::fromString($start, $end);

        return $this;
    }

    public function build()
    {
        return new Ad($this->id, $this->projectId, $this->title, $this->content, $this->publication);
    }
}