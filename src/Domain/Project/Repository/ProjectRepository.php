<?php

namespace Ats\Domain\Project\Repository;

use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\ValueObject\ProjectId;

interface ProjectRepository
{
    /**
     * @param Project $project
     * @return void
     */
    public function save(Project $project);

    /**
     * @param Project $project
     * @return void
     */
    public function remove(Project $project);

    /**
     * @param ProjectId $projectId
     * @return Project
     */
    public function projectOfId(ProjectId $projectId);

    /**
     * @return Project[]
     */
    public function all(): array;

    /**
     * @return ProjectId
     */
    public function nextIdentity(): ProjectId;

    /**
     * @return int
     */
    public function size(): int;
}
