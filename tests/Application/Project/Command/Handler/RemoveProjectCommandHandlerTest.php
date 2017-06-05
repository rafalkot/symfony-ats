<?php

use Ats\Application\Project\Command\Handler\RemoveProjectCommandHandler;
use Ats\Application\Project\Command\RemoveProjectCommand;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;
use Ats\Infrastructure\Persistence\InMemory\Project\InMemoryProjectRepository;

class RemoveProjectCommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_removes_project()
    {
        $repository = new InMemoryProjectRepository();

        $id = $repository->nextIdentity();
        $repository->save(new Project(
            $id,
            new ProjectName('Project 1'),
            new ProjectDuration(new \DateTimeImmutable()),
            new ProjectVacancies(2)
        ));

        $this->assertInstanceOf(Project::class, $repository->projectOfId($id));

        $command = new RemoveProjectCommand($id->getId());
        $handler = new RemoveProjectCommandHandler($repository);
        $handler->handle($command);

        $this->assertNull($repository->projectOfId($id));
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Project\Exception\ProjectDoesNotExistException
     */
    public function it_throws_exception_on_non_existing_project()
    {
        $repository = new InMemoryProjectRepository();

        $id = new ProjectId('non-existing-id');

        $command = new RemoveProjectCommand($id->getId());
        $handler = new RemoveProjectCommandHandler($repository);
        $handler->handle($command);
    }
}