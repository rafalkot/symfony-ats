<?php

use Ats\Application\Ad\Command\EditAdCommand;
use Ats\Application\Ad\Command\Handler\EditAdCommandHandler;
use Ats\Domain\Ad\Model\Ad;
use Ats\Infrastructure\Persistence\InMemory\Ad\InMemoryAdRepository;
use Ats\Infrastructure\Persistence\InMemory\Project\InMemoryProjectRepository;
use Tests\Domain\Ad\Model\AdBuilder;
use Tests\Domain\Project\Model\ProjectBuilder;

class EditAdCommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_updates_ad()
    {
        $adRepository = new InMemoryAdRepository();
        $projectRepository = new InMemoryProjectRepository();

        $id = $adRepository->nextIdentity();

        $project1 = ProjectBuilder::aProject()->build();
        $project2 = ProjectBuilder::aProject()->build();

        $projectRepository->save($project1);
        $projectRepository->save($project2);

        $ad = AdBuilder::anAd()
            ->withId($id)
            ->withProjectId($project1->id()->id())
            ->build();

        $adRepository->save($ad);

        $ad = $adRepository->adOfId($id);

        $this->assertInstanceOf(Ad::class, $ad);

        $command = new EditAdCommand($ad->id()->id(), $project2->id()->id(), 'New title', 'New content', date('Y-m-d'));
        $handler = new EditAdCommandHandler($adRepository, $projectRepository);
        $handler->handle($command);

        $ad = $adRepository->adOfId($id);
        $this->assertEquals('New title', $ad->title()->title());
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Ad\Exception\AdDoesNotExistException
     */
    public function it_throws_exception_on_non_existing_ad()
    {
        $adRepository = new InMemoryAdRepository();
        $projectRepository = new InMemoryProjectRepository();

        $command = new EditAdCommand('non-existing-id', 'project-id', 'New title', 'New content', date('Y-m-d'));
        $handler = new EditAdCommandHandler($adRepository, $projectRepository);
        $handler->handle($command);
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Project\Exception\ProjectDoesNotExistException
     */
    public function it_throws_exception_on_non_existing_project()
    {
        $adRepository = new InMemoryAdRepository();
        $projectRepository = new InMemoryProjectRepository();

        $ad = AdBuilder::anAd()->withProjectId('non-existing-project-id')->build();

        $adRepository->save($ad);

        $command = new EditAdCommand($ad->id()->id(), 'non-existing-project-id', 'New title', 'New content',
            date('Y-m-d'));
        $handler = new EditAdCommandHandler($adRepository, $projectRepository);
        $handler->handle($command);
    }
}