<?php

use Ats\Application\Project\Command\EditProjectCommand;
use Ats\Application\Project\Command\Handler\EditProjectCommandHandler;
use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;
use Ats\Infrastructure\Persistence\InMemory\Project\InMemoryProjectRepository;

class EditProjectCommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_updates_project()
    {
        $repository = new InMemoryProjectRepository();

        $id = $repository->nextIdentity();
        $repository->save(new Project(
            $id,
            new ProjectName('Project 1'),
            new ProjectDuration(new \DateTimeImmutable()),
            new ProjectVacancies(2)
        ));

        $project = $repository->projectOfId($id);
        $this->assertEquals('Project 1', $project->name()->name());

        $command = new EditProjectCommand($id->getId(), 'Project 2', date('Y-m-d'), null, 5);
        $handler = new EditProjectCommandHandler($repository);
        $handler->handle($command);

        $project = $repository->projectOfId($id);
        $this->assertEquals('Project 2', $project->name()->name());
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Project\Exception\ProjectDoesNotExistException
     */
    public function it_throws_exception_on_non_existing_project()
    {
        $repository = new InMemoryProjectRepository();

        $id = new ProjectId('non-existing-id');

        $command = new EditProjectCommand($id->getId(), 'Project 2', date('Y-m-d'), null, 5);
        $handler = new EditProjectCommandHandler($repository);
        $handler->handle($command);
    }
}