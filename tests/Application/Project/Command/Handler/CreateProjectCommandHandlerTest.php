<?php

use Ats\Application\Project\Command\CreateProjectCommand;
use Ats\Application\Project\Command\Handler\CreateProjectCommandHandler;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Infrastructure\Persistence\InMemory\Project\InMemoryProjectRepository;

class CreateProjectCommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_creates_project()
    {
        $repository = new InMemoryProjectRepository();

        $command = new CreateProjectCommand(
            $repository->nextIdentity()->getId(),
            'Project 1',
            date('Y-m-d'),
            null,
            5
        );

        $handler = new CreateProjectCommandHandler($repository);

        $this->assertNull($repository->projectOfId(new ProjectId($command->id())));

        $handler->handle($command);

        $this->assertInstanceOf(Project::class, $repository->projectOfId(new ProjectId($command->id())));
    }
}