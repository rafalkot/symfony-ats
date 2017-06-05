<?php

namespace Ats\Domain\Project\Event;

use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;

class ProjectDurationChanged extends ProjectEvent
{
    /**
     * @var ProjectDuration
     */
    protected $projectDuration;

    /**
     * @param ProjectId $projectId
     * @param ProjectName $projectName
     * @param ProjectDuration $projectDuration
     */
    public function __construct(ProjectId $projectId, ProjectName $projectName, ProjectDuration $projectDuration)
    {
        parent::__construct($projectId, $projectName);

        $this->projectDuration = $projectDuration;
    }

    /**
     * @return ProjectDuration
     */
    public function projectDuration(): ProjectDuration
    {
        return $this->projectDuration;
    }
}
