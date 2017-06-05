<?php

declare(strict_types=1);

namespace Ats\Domain\Project\Model;

use Ats\Domain\Common\Model\AggregateRoot;
use Ats\Domain\Project\Event\ProjectCreated;
use Ats\Domain\Project\Event\ProjectDurationChanged;
use Ats\Domain\Project\Event\ProjectRenamed;
use Ats\Domain\Project\Event\ProjectVacanciesChanged;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;

/**
 * @package Ats\Domain\Project\Model
 */
class Project extends AggregateRoot
{

    /**
     * @var ProjectId
     */
    protected $id;

    /**
     * @var ProjectName
     */
    protected $name;

    /**
     * @var ProjectDuration
     */
    protected $duration;

    /**
     * @var ProjectVacancies
     */
    protected $vacancies;

    /**
     * Project constructor.
     * @param ProjectId $id
     * @param ProjectName $name
     * @param ProjectDuration $duration
     * @param ProjectVacancies $vacancies
     */
    public function __construct(
        ProjectId $id,
        ProjectName $name,
        ProjectDuration $duration,
        ProjectVacancies $vacancies
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->duration = $duration;
        $this->vacancies = $vacancies;

        $this->record(new ProjectCreated($id, $name));
    }

    /**
     * @return ProjectId
     */
    public function id(): ProjectId
    {
        return $this->id;
    }

    /**
     * @return ProjectName
     */
    public function name(): ProjectName
    {
        return $this->name;
    }

    /**
     * @return ProjectDuration
     */
    public function duration(): ProjectDuration
    {
        return $this->duration;
    }

    /**
     * @return ProjectVacancies
     */
    public function vacancies(): ProjectVacancies
    {
        return $this->vacancies;
    }

    /**
     * @param ProjectName $name
     */
    public function rename(ProjectName $name)
    {
        if ($this->name->equals($name)) {
            return;
        }

        $this->name = $name;

        $this->publish(new ProjectRenamed($this->id, $name));
    }

    /**
     * @param ProjectDuration $duration
     */
    public function changeDuration(ProjectDuration $duration)
    {
        if ($this->duration->equals($duration)) {
            return;
        }

        $this->duration = $duration;

        $this->publish(new ProjectDurationChanged($this->id, $this->name, $duration));
    }

    /**
     * @param ProjectVacancies $vacancies
     */
    public function changeVacancies(ProjectVacancies $vacancies)
    {
        if ($this->vacancies->equals($vacancies)) {
            return;
        }

        $this->vacancies = $vacancies;

        $this->publish(new ProjectVacanciesChanged($this->id, $this->name, $vacancies));
    }
}
