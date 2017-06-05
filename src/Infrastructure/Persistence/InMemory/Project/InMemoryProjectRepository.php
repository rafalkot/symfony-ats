<?php

namespace Ats\Infrastructure\Persistence\InMemory\Project;

use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectId;

class InMemoryProjectRepository implements ProjectRepository
{
    protected $projects = [];

    /**
     * @param Project $project
     * @return void
     */
    public function save(Project $project)
    {
        $this->projects[$project->id()->getId()] = $project;
    }

    /**
     * @param Project $project
     * @return void
     */
    public function remove(Project $project)
    {
        if (isset($this->projects[$project->id()->getId()])) {
            unset($this->projects[$project->id()->getId()]);
        }
    }

    /**
     * @param ProjectId $projectId
     * @return Project
     */
    public function projectOfId(ProjectId $projectId)
    {
        if (isset($this->projects[$projectId->getId()])) {
            return $this->projects[$projectId->getId()];
        }

        return null;
    }

    /**
     * @return Project[]
     */
    public function all(): array
    {
        return array_values($this->projects);
    }

    /**
     * @return ProjectId
     */
    public function nextIdentity(): ProjectId
    {
        return ProjectId::generate();
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->projects);
    }
}