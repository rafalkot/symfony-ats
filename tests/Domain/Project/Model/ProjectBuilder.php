<?php

namespace Tests\Domain\Project\Model;

use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;

class ProjectBuilder
{
    protected $id;

    protected $name;

    protected $duration;

    protected $vacancies;

    /**
     * AdBuilder constructor.
     */
    protected function __construct()
    {
        $this->id = ProjectId::generate();
        $this->name = new ProjectName('Project name');
        $this->duration = ProjectDuration::fromString(date('Y-m-d'), date('Y-m-d', strtotime('+30 days')));
        $this->vacancies = new ProjectVacancies(5);
    }

    public static function aProject()
    {
        return new self();
    }

    public function withId($id)
    {
        $this->id = new ProjectId($id);

        return $this;
    }

    public function withName($name)
    {
        $this->name = new ProjectName($name);

        return $this;
    }

    public function withDuration($start, $end)
    {
        $this->duration = ProjectDuration::fromString($start, $end);

        return $this;
    }

    public function withVacancies($vacancies)
    {
        $this->vacancies = new ProjectVacancies($vacancies);

        return $this;
    }

    public function build()
    {
        return new Project($this->id, $this->name, $this->duration, $this->vacancies);
    }
}