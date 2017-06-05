<?php

namespace Ats\Application\Project\Command\Handler;

use Ats\Application\Project\Command\CreateProjectCommand;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;

class CreateProjectCommandHandler
{
    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * CreateProjectCommandHandler constructor.
     * @param ProjectRepository $projects
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;
    }

    public function handle(CreateProjectCommand $command)
    {
        $startDate = \DateTimeImmutable::createFromFormat('Y-m-d', $command->startDate());
        $endDate = $command->endDate() ? \DateTimeImmutable::createFromFormat('Y-m-d', $command->endDate()) : null;

        $project = new Project(
            new ProjectId($command->id()),
            new ProjectName($command->name()),
            new ProjectDuration($startDate, $endDate),
            new ProjectVacancies($command->vacancies())
        );

        $this->projects->save($project);
    }
}