<?php

use Ats\Domain\Ad\Event\AdContentChanged;
use Ats\Domain\Ad\Event\AdCreated;
use Ats\Domain\Ad\Event\AdMovedToProject;
use Ats\Domain\Ad\Event\AdPublicationChanged;
use Ats\Domain\Ad\Event\AdTitleChanged;
use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdTitle;
use Ats\Domain\Ad\ValueObject\AdContent;
use Ats\Domain\Ad\ValueObject\AdPublication;
use Ats\Domain\Project\ValueObject\ProjectId;

class AdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Ad
     */
    protected $ad;

    public function setUp()
    {
        $this->ad = new Ad(
            new AdId('ID'),
            new ProjectId('Project-ID'),
            new AdTitle('Ad title'),
            new AdContent('Ad content'),
            new AdPublication(new \DateTimeImmutable('today'))
        );
    }

    /**
     * @test
     */
    public function it_publishes_ad_created_event()
    {
        $this->assertEventPublished(AdCreated::class);
    }

    /**
     * @test
     */
    public function it_has_an_id()
    {
        $this->assertInstanceOf(AdId::class, $this->ad->id());
        $this->assertEquals('ID', $this->ad->id()->id());
    }

    /**
     * @test
     */
    public function it_has_a_project_id()
    {
        $this->assertInstanceOf(ProjectId::class, $this->ad->projectId());
        $this->assertEquals('Project-ID', $this->ad->projectId()->id());
    }

    /**
     * @test
     */
    public function it_has_a_title()
    {
        $this->assertInstanceOf(AdTitle::class, $this->ad->title());
        $this->assertEquals('Ad title', $this->ad->title());
    }

    /**
     * @test
     */
    public function it_has_a_content()
    {
        $this->assertInstanceOf(AdContent::class, $this->ad->content());
        $this->assertEquals('Ad content', $this->ad->content());
    }

    /**
     * @test
     */
    public function it_has_a_publication()
    {
        $this->assertInstanceOf(AdPublication::class, $this->ad->publication());
        $this->assertEquals(new AdPublication(new \DateTimeImmutable('today')), $this->ad->publication());
    }

    /**
     * @test
     */
    public function it_changes_a_title_and_publishes_event()
    {
        $newTitle = new AdTitle('New title');
        $this->ad->changeTitle($newTitle);

        $this->assertEquals($newTitle, $this->ad->title());
        $this->assertEquals('New title', $this->ad->title()->title());
        $this->assertEventPublished(AdTitleChanged::class);
    }

    /**
     * @test
     */
    public function it_does_not_publish_event_on_changing_title_to_the_same_value()
    {
        $this->assertEventNotPublished(function () {
            $newTitle = new AdTitle('Ad title');
            $this->ad->changeTitle($newTitle);
        });
    }

    /**
     * @test
     */
    public function it_moves_to_project_and_publishes_event()
    {
        $newId = new ProjectId('New-Project-Id');
        $this->ad->moveToProject($newId);

        $this->assertEquals($newId, $this->ad->projectId());
        $this->assertEquals('New-Project-Id', $this->ad->projectId()->id());
        $this->assertEventPublished(AdMovedToProject::class);
    }

    /**
     * @test
     */
    public function it_does_not_publish_event_on_moving_to_the_project()
    {
        $this->assertEventNotPublished(function () {
            $newId = new ProjectId('Project-ID');
            $this->ad->moveToProject($newId);
        });
    }

    /**
     * @test
     */
    public function it_changes_a_content_and_publishes_event()
    {
        $newContent = new AdContent('New content');
        $this->ad->changeContent($newContent);

        $this->assertEquals($newContent, $this->ad->content());
        $this->assertEquals('New content', $this->ad->content()->content());
        $this->assertEventPublished(AdContentChanged::class);
    }

    /**
     * @test
     */
    public function it_does_not_publish_event_on_changing_content_to_the_same_value()
    {
        $this->assertEventNotPublished(function () {
            $newContent = new AdContent('Ad content');
            $this->ad->changeContent($newContent);
        });
    }

    /**
     * @test
     */
    public function it_changes_a_publication_and_publishes_event()
    {
        $newPublication = new AdPublication(new \DateTimeImmutable('tomorrow'));
        $this->ad->changePublication($newPublication);

        $this->assertEquals($newPublication, $this->ad->publication());
        $this->assertEventPublished(AdPublicationChanged::class);
    }

    /**
     * @test
     */
    public function it_does_not_publish_event_on_changing_publication_to_the_same_value()
    {
        $this->assertEventNotPublished(function () {
            $newPublication = new AdPublication(new \DateTimeImmutable('today'));
            $this->ad->changePublication($newPublication);
        });
    }

    protected function assertEventPublished($class)
    {
        $event = $this->getLastEvent();
        $this->assertInstanceOf($class, $event);
        $this->assertTrue($this->ad->id()->equals($event->adId()));
    }

    protected function assertEventNotPublished($callback)
    {
        $this->ad->releaseEvents();
        $callback();
        $this->assertFalse($this->getLastEvent());
    }

    protected function getLastEvent()
    {
        $events = $this->ad->releaseEvents();
        return end($events);
    }
}