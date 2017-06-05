<?php

namespace Ats\Application\Project\Command\Handler;

use Ats\Application\Project\Command\RemoveProjectCommand;
use Ats\Domain\Project\Exception\ProjectDoesNotExistException;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectId;

class RemoveProjectCommandHandler
{
    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * @param ProjectRepository $projects
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;
    }

    public function handle(RemoveProjectCommand $command)
    {
        $project = $this->projects->projectOfId(new ProjectId($command->id()));

        $this->checkProjectExists($project);

        $this->projects->remove($project);
    }

    protected function checkProjectExists(Project $project = null)
    {
        if (!$project) {
            throw new ProjectDoesNotExistException();
        }
    }
}