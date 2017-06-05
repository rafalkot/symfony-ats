<?php

namespace Ats\Application\Ad\Command\Handler;

use Ats\Application\Ad\Command\EditAdCommand;
use Ats\Domain\Ad\Exception\AdDoesNotExistException;
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

class EditAdCommandHandler
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
     * EditAdCommandHandler constructor.
     * @param AdRepository $ads
     * @param ProjectRepository $projects
     */
    public function __construct(AdRepository $ads, ProjectRepository $projects)
    {
        $this->ads = $ads;
        $this->projects = $projects;
    }

    public function handle(EditAdCommand $command)
    {
        $ad = $this->ads->adOfId(new AdId($command->id()));

        $this->checkAdExists($ad);

        $project = $this->projects->projectOfId(new ProjectId($command->projectId()));

        $this->checkProjectExists($project);

        $ad->moveToProject(new ProjectId($command->projectId()));
        $ad->changeTitle(new AdTitle($command->title()));
        $ad->changeContent(new AdContent($command->content()));
        $ad->changePublication(AdPublication::fromString($command->publicationDate(), $command->expirationDate()));

        $this->ads->save($ad);
    }

    protected function checkAdExists(Ad $ad = null)
    {
        if (!$ad) {
            throw new AdDoesNotExistException();
        }
    }

    protected function checkProjectExists(Project $project = null)
    {
        if (!$project) {
            throw new ProjectDoesNotExistException();
        }
    }
}