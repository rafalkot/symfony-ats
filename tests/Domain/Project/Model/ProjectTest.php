<?php

namespace Tests\Domain\Project\Model;

use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;

class ProjectTest extends \PHPUnit_Framework_TestCase
{


    public function testGetters()
    {
        $projectId = ProjectId::generate();
        $projectName= new ProjectName('Project name');
        $projectDuration = new ProjectDuration(new \DateTimeImmutable(), null);
        $projectVacancies = new ProjectVacancies(5);

        $project = new Project($projectId, $projectName, $projectDuration, $projectVacancies);

        $this->assertInstanceOf(Project::class, $project);
        $this->assertInstanceOf(ProjectId::class, $project->id());
        $this->assertEquals($projectId, $project->id());
        $this->assertInstanceOf(ProjectDuration::class, $project->duration());
        $this->assertEquals($projectDuration, $project->duration());
        $this->assertEquals($projectName, $project->name());
        $this->assertEquals($projectVacancies, $project->vacancies());
    }
}