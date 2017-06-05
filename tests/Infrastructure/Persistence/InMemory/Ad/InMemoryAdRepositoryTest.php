<?php

use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdTitle;
use Ats\Domain\Ad\ValueObject\AdContent;
use Ats\Domain\Ad\ValueObject\AdPublication;
use Ats\Domain\Project\ValueObject\ProjectId;
use Ats\Infrastructure\Persistence\InMemory\Ad\InMemoryAdRepository;

class InMemoryAdRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function it_saves_new_ad()
    {
        $ad = $this->createAd();

        $repository = new InMemoryAdRepository();
        $repository->save($ad);

        $this->assertEquals(1, $repository->size());
        $this->assertEquals($ad, $repository->adOfId($ad->id()));
    }

    /**
     * @test
     */
    public function it_updates_existing_ad()
    {
        $ad = $this->createAd();

        $repository = new InMemoryAdRepository();
        $repository->save($ad);

        $this->assertEquals('Ad title', $repository->adOfId($ad->id())->title()->title());

        $ad->changeTitle(new AdTitle('Ad title 2'));
        $repository->save($ad);

        $this->assertEquals('Ad title 2', $repository->adOfId($ad->id())->title()->title());
        $this->assertEquals(1, $repository->size());
    }

    /**
     * @test
     */
    public function is_removes_ad()
    {
        $ad = $this->createAd();

        $repository = new InMemoryAdRepository();
        $repository->save($ad);

        $this->assertEquals(1, $repository->size());

        $repository->remove($ad);

        $this->assertEquals(0, $repository->size());
        $this->assertNull($repository->adOfId($ad->id()));
    }

    /**
     * @test
     */
    public function it_counts_ads()
    {
        $repository = new InMemoryAdRepository();

        $this->assertEquals(0, $repository->size());

        $repository->save($this->createAd());
        $this->assertEquals(1, $repository->size());

        $repository->save($this->createAd());
        $this->assertEquals(2, $repository->size());

        $repository->save($this->createAd());
        $this->assertEquals(3, $repository->size());

        $ad = $this->createAd();
        $repository->save($ad);
        $this->assertEquals(4, $repository->size());

        $repository->remove($ad);
        $this->assertEquals(3, $repository->size());
    }

    /**
     * @test
     */
    public function it_generates_identities()
    {
        $repository = new InMemoryAdRepository();

        $this->assertInstanceOf(AdId::class, $repository->nextIdentity());

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
    public function it_returns_all_ads()
    {
        $repository = new InMemoryAdRepository();

        $ads = [
            $this->createAd(),
            $this->createAd(),
            $this->createAd()
        ];

        foreach ($ads as $ad) {
            $repository->save($ad);
        }

        $this->assertEquals($ads, $repository->all(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10,
            $canonicalize = true);

        $repository->remove($ads[0]);

        unset($ads[0]);

        $this->assertEquals($ads, $repository->all(), "\$canonicalize = true", $delta = 0.0, $maxDepth = 10,
            $canonicalize = true);

        $repository = new InMemoryAdRepository();
        $this->assertEquals([], $repository->all());
    }

    protected function createAd($id = null, $title = 'Ad title')
    {
        $id = $id ? new AdId($id) : AdId::generate();

        return new Ad(
            $id,
            ProjectId::generate(),
            new AdTitle($title),
            new AdContent('Ad content'),
            new AdPublication(new \DateTimeImmutable())
        );
    }
}