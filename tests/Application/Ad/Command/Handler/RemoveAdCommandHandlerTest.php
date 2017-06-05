<?php

use Ats\Application\Ad\Command\Handler\RemoveAdCommandHandler;
use Ats\Application\Ad\Command\RemoveAdCommand;
use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Infrastructure\Persistence\InMemory\Ad\InMemoryAdRepository;
use Tests\Domain\Ad\Model\AdBuilder;

class RemoveAdCommandHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_removes_ad()
    {
        $repository = new InMemoryAdRepository();

        $ad = AdBuilder::anAd()->withProjectId(ProjectId::generate())->build();

        $repository->save($ad);

        $this->assertInstanceOf(Ad::class, $repository->adOfId($ad->id()));

        $command = new RemoveAdCommand($ad->id()->id());
        $handler = new RemoveAdCommandHandler($repository);
        $handler->handle($command);

        $this->assertNull($repository->adOfId($ad->id()));
    }

    /**
     * @test
     * @expectedException \Ats\Domain\Ad\Exception\AdDoesNotExistException
     */
    public function it_throws_exception_on_non_existing_ad()
    {
        $repository = new InMemoryAdRepository();

        $command = new RemoveAdCommand('non-existing-id');
        $handler = new RemoveAdCommandHandler($repository);
        $handler->handle($command);
    }
}