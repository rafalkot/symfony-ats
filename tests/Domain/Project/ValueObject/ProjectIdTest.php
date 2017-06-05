<?php

namespace Tests\Domain\Project\ValueObject;


use Ats\Domain\Project\ValueObject\ProjectId;

class ProjectIdTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_generates_self_object()
    {
        $this->assertInstanceOf(ProjectId::class, ProjectId::generate());
    }

    /**
     * @test
     */
    public function it_constructs_from_string()
    {
        $projectId = new ProjectId('1234');
        $this->assertEquals('1234', $projectId->id());
    }

    /**
     * @test
     */
    public function it_is_same_as()
    {
        $projectId = new ProjectId('1234');
        $projectId2 = new ProjectId('1234');

        $this->assertTrue($projectId->equals($projectId2));
    }

    /**
     * @test
     */
    public function it_is_not_same_as()
    {
        $projectId = new ProjectId('1234');
        $projectId2 = new ProjectId('12345');

        $this->assertFalse($projectId->equals($projectId2));
    }

    /**
     * @test
     */
    public function it_casts_to_string()
    {
        $projectId = new ProjectId('1234');
        $this->assertEquals('1234', (string)$projectId);
    }
}