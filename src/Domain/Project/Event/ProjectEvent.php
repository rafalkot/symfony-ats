<?php

declare(strict_types=1);

namespace Ats\Domain\Project\Event;

use Ats\Domain\Common\Event\DomainEvent;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;

abstract class ProjectEvent implements DomainEvent
{
    /**
     * @var ProjectId
     */
    protected $projectId;

    /**
     * @var ProjectName
     */
    protected $projectName;

    /**
     * @var \DateTime
     */
    protected $occurredOn;

    /**
     * @param ProjectId $projectId
     * @param ProjectName $projectName
     */
    public function __construct(ProjectId $projectId, ProjectName $projectName)
    {
        $this->projectId = $projectId;
        $this->projectName = $projectName;
        $this->occurredOn = new \DateTime();
    }

    /**
     * @return ProjectId
     */
    public function projectId(): ProjectId
    {
        return $this->projectId;
    }

    /**
     * @return ProjectName
     */
    public function projectName(): ProjectName
    {
        return $this->projectName;
    }

    /**
     * @return \DateTime
     */
    public function occurredOn(): \DateTime
    {
        return $this->occurredOn;
    }
}
