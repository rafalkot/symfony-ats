<?php

namespace Ats\Application\Ad\Command\Handler;

use Ats\Application\Ad\Command\PostAdCommand;
use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\Repository\AdRepository;
use Ats\Domain\Ad\ValueObject\AdContent;
use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdPublication;
use Ats\Domain\Ad\ValueObject\AdTitle;
use Ats\Domain\Project\Exception\ProjectDoesNotExistException;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectId;

class PostAdCommandHandler
{
    /**
     * @var AdRepository
     */
    protected $ads;

    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * PostAdCommandHandler constructor.
     * @param AdRepository $ads
     * @param ProjectRepository $projects
     */
    public function __construct(AdRepository $ads, ProjectRepository $projects)
    {
        $this->ads = $ads;
        $this->projects = $projects;
    }

    public function handle(PostAdCommand $command)
    {
        $projectId = new ProjectId($command->projectId());
        $project = $this->projects->projectOfId($projectId);

        $this->checkProjectExists($project);

        $ad = new Ad(
            new AdId($command->id()),
            $projectId,
            new AdTitle($command->title()),
            new AdContent($command->content()),
            AdPublication::fromString($command->publicationDate(), $command->expirationDate())
        );

        $this->ads->save($ad);
    }

    protected function checkProjectExists(Project $project = null)
    {
        if (!$project) {
            throw new ProjectDoesNotExistException();
        }
    }
}
