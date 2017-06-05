<?php

declare(strict_types=1);

namespace Ats\Domain\Project\Event;

use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;

class ProjectVacanciesChanged extends ProjectEvent
{
    /**
     * @var ProjectVacancies
     */
    protected $projectVacancies;

    /**
     * @param ProjectId $projectId
     * @param ProjectName $projectName
     * @param ProjectVacancies $projectVacancies
     */
    public function __construct(ProjectId $projectId, ProjectName $projectName, ProjectVacancies $projectVacancies)
    {
        parent::__construct($projectId, $projectName);

        $this->projectVacancies = $projectVacancies;
    }

    /**
     * @return ProjectVacancies
     */
    public function projectVacancies(): ProjectVacancies
    {
        return $this->projectVacancies;
    }
}
