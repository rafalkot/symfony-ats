<?php

namespace Ats\Application\Project\Command\Handler;

use Ats\Application\Project\Command\EditProjectCommand;
use Ats\Domain\Project\Exception\ProjectDoesNotExistException;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;

class EditProjectCommandHandler
{
    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * EditProjectCommandHandler constructor.
     * @param ProjectRepository $projects
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;
    }

    public function handle(EditProjectCommand $command)
    {
        $startDate = \DateTimeImmutable::createFromFormat('Y-m-d', $command->startDate());
        $endDate = $command->endDate() ? \DateTimeImmutable::createFromFormat('Y-m-d', $command->endDate()) : null;

        $project = $this->projects->projectOfId(new ProjectId($command->id()));

        $this->checkProjectExists($project);

        $project->rename(new ProjectName($command->name()));
        $project->changeDuration(new ProjectDuration($startDate, $endDate));
        $project->changeVacancies(new ProjectVacancies($command->vacancies()));

        $this->projects->save($project);
    }

    protected function checkProjectExists(Project $project = null)
    {
        if (!$project) {
            throw new ProjectDoesNotExistException();
        }
    }
}