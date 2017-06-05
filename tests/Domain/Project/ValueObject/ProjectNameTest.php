<?php

declare(strict_types=1);

namespace Tests\Domain\Project\ValueObject;

use Ats\Domain\Project\ValueObject\ProjectName;

class ProjectNameTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_constructs_from_string()
    {
        $projectName = new ProjectName('Project name');
        $this->assertEquals('Project name', $projectName->name());
    }

    /**
     * @test
     */
    public function it_is_same_as()
    {
        $projectName = new ProjectName('Project name');
        $projectName2 = new ProjectName('Project name');

        $this->assertTrue($projectName->equals($projectName2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as()
    {
        $projectName = new ProjectName('Project name');
        $projectName2 = new ProjectName('Project name 2');

        $this->assertFalse($projectName->equals($projectName2));
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Project\Exception\ProjectNameIsEmptyException
     */
    public function is_throws_exception_on_empty_name()
    {
        $projectName = new ProjectName('');
    }
}