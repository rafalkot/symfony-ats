<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\Model;

use Ats\Domain\Ad\Event\AdContentChanged;
use Ats\Domain\Ad\Event\AdCreated;
use Ats\Domain\Ad\Event\AdMovedToProject;
use Ats\Domain\Ad\Event\AdPublicationChanged;
use Ats\Domain\Ad\Event\AdTitleChanged;
use Ats\Domain\Ad\ValueObject\AdContent;
use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdPublication;
use Ats\Domain\Ad\ValueObject\AdTitle;
use Ats\Domain\Common\Model\AggregateRoot;
use Ats\Domain\Project\ValueObject\ProjectId;

class Ad extends AggregateRoot
{

    /**
     * @var AdId
     */
    protected $id;

    /**
     * @var ProjectId
     */
    protected $projectId;

    /**
     * @var AdTitle
     */
    protected $title;

    /**
     * @var AdContent
     */
    protected $content;

    /**
     * @var AdPublication
     */
    protected $publication;

    /**
     * Ad constructor.
     * @param AdId $id
     * @param ProjectId $projectId
     * @param AdTitle $title
     * @param AdContent $content
     * @param AdPublication $publication
     */
    public function __construct(
        AdId $id,
        ProjectId $projectId,
        AdTitle $title,
        AdContent $content,
        AdPublication $publication
    ) {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->title = $title;
        $this->content = $content;
        $this->publication = $publication;

        $this->publish(new AdCreated($this->id, $this->title));
    }

    /**
     * @return AdId
     */
    public function id(): AdId
    {
        return $this->id;
    }

    /**
     * @return ProjectId
     */
    public function projectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * @return AdTitle
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return AdContent
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @return AdPublication
     */
    public function publication()
    {
        return $this->publication;
    }

    /**
     * @param ProjectId $projectId
     */
    public function moveToProject(ProjectId $projectId)
    {
        if ($this->projectId->equals($projectId)) {
            return;
        }

        $this->projectId = $projectId;

        $this->publish(new AdMovedToProject($this->id, $this->title, $this->projectId));
    }

    /**
     * @param AdTitle $title
     */
    public function changeTitle(AdTitle $title)
    {
        if ($this->title->equals($title)) {
            return;
        }

        $this->title = $title;

        $this->publish(new AdTitleChanged($this->id, $this->title));
    }

    /**
     * @param AdContent $content
     */
    public function changeContent(AdContent $content)
    {
        if ($this->content->equals($content)) {
            return;
        }

        $this->content = $content;

        $this->publish(new AdContentChanged($this->id, $this->title, $this->content));
    }

    /**
     * @param AdPublication $publication
     */
    public function changePublication(AdPublication $publication)
    {
        if ($this->publication->equals($publication)) {
            return;
        }

        $this->publication = $publication;

        $this->publish(new AdPublicationChanged($this->id, $this->title, $this->publication));
    }
}
