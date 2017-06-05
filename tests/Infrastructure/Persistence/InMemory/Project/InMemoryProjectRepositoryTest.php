<?php

use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\ValueObject\ProjectDuration;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Domain\Project\ValueObject\ProjectName;
use Ats\Domain\Project\ValueObject\ProjectVacancies;
use Ats\Infrastructure\Persistence\InMemory\Project\InMemoryProjectRepository;

class InMemoryProjectRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_saves_new_project()
    {
        $project = $this->createProject();

        $repository = new InMemoryProjectRepository();
        $repository->save($project);

        $this->assertEquals(1, $repository->size());
        $this->assertEquals($project, $repository->projectOfId($project->id()));
    }

    /**
     * @test
     */
    public function it_updates_existing_project()
    {
        $project = $this->createProject();

        $repository = new InMemoryProjectRepository();
        $repository->save($project);

        $this->assertEquals('Project name', $repository->projectOfId($project->id())->name()->name());

        $project->rename(new ProjectName('Project name 2'));
        $repository->save($project);

        $this->assertEquals('Project name 2', $repository->projectOfId($project->id())->name()->name());
        $this->assertEquals(1, $repository->size());
    }

    /**
     * @test
     */
    public function is_removes_project()
    {
        $project = $this->createProject();

        $repository = new InMemoryProjectRepository();
        $repository->save($project);

        $this->assertEquals(1, $repository->size());

        $repository->remove($project);

        $this->assertEquals(0, $repository->size());
        $this->assertNull($repository->projectOfId($project->id()));
    }

    /**
     * @test
     */
    public function it_counts_projects()
    {
        $repository = new InMemoryProjectRepository();

        $this->assertEquals(0, $repository->size());

        $repository->save($this->createProject());
        $this->assertEquals(1, $repository->size());

        $repository->save($this->createProject());
        $this->assertEquals(2, $repository->size());

        $repository->save($this->createProject());
        $this->assertEquals(3, $repository->size());

        $project = $this->createProject();
        $repository->save($project);
        $this->assertEquals(4, $repository->size());

        $repository->remove($project);
        $this->assertEquals(3, $repository->size());
    }

    /**
     * @test
     */
    public function it_generates_identities()
    {
        $repository = new InMemoryProjectRepository();

        $this->assertInstanceOf(ProjectId::class, $repository->nextIdentity());

        $ids = [];

        for ($i = 0; $i < 5000; $i++) {
            $ids[] = $repository->nextIdentity()->getId();
        }

        $ids = array_unique($ids);

        $this->assertEquals(5000, count($ids));
    }

    /**
     * @test
     */
    public function it_returns_all_projects()
    {
        $repository = new InMemoryProjectRepository();

        $projects = [
            $this->createProject(),
            $this->createProject(),
            $this->createProject()
        ];

        foreach ($projects as $project) {
            $repository->save($project);
        }

        $this->assertEquals($projects, $repository->all(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10,
            $canonicalize = true);

        $repository->remove($projects[0]);

        unset($projects[0]);

        $this->assertEquals($projects, $repository->all(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10,
            $canonicalize = true);

        $repository = new InMemoryProjectRepository();
        $this->assertEquals([], $repository->all());
    }

    protected function createProject($id = null, $name = 'Project name')
    {
        $id = $id ? new ProjectId($id) : ProjectId::generate();

        return new Project(
            $id,
            new ProjectName($name),
            new ProjectDuration(new \DateTimeImmutable()),
            new ProjectVacancies(5)
        );
    }
}