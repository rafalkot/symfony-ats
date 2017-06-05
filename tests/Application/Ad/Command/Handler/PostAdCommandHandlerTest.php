<?php

use Ats\Application\Ad\Command\Handler\PostAdCommandHandler;
use Ats\Application\Ad\Command\PostAdCommand;
use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Infrastructure\Persistence\InMemory\Ad\InMemoryAdRepository;
use Ats\Infrastructure\Persistence\InMemory\Project\InMemoryProjectRepository;
use Tests\Domain\Project\Model\ProjectBuilder;

class PostAdCommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_posts_an_ad()
    {
        $repository = new InMemoryAdRepository();
        $projectRepository = new InMemoryProjectRepository();

        $project = ProjectBuilder::aProject()->build();

        $projectRepository->save($project);

        $command = new PostAdCommand(
            $repository->nextIdentity()->getId(),
            $project->id()->id(),
            'Ad title',
            'Ad content',
            date('Y-m-d'),
            date('Y-m-d', strtotime('+30 days'))
        );

        $handler = new PostAdCommandHandler($repository, $projectRepository);

        $this->assertNull($repository->adOfId(new AdId($command->id())));

        $handler->handle($command);

        $this->assertInstanceOf(Ad::class, $repository->adOfId(new AdId($command->id())));
    }
}
