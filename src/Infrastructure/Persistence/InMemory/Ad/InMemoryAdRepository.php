<?php

namespace Ats\Infrastructure\Persistence\InMemory\Ad;

use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\Repository\AdRepository;
use Ats\Domain\Ad\ValueObject\AdId;

class InMemoryAdRepository implements AdRepository
{
    protected $ads = [];

    /**
     * @param Ad $ad
     * @return void
     */
    public function save(Ad $ad)
    {
        $this->ads[$ad->id()->id()] = $ad;
    }

    /**
     * @param Ad $ad
     * @return void
     */
    public function remove(Ad $ad)
    {
        if (isset($this->ads[$ad->id()->id()])) {
            unset($this->ads[$ad->id()->id()]);
        }
    }

    /**
     * @param AdId $adId
     * @return Ad
     */
    public function adOfId(AdId $adId)
    {
        if (isset($this->ads[$adId->id()])) {
            return $this->ads[$adId->id()];
        }

        return null;
    }

    /**
     * @return Ad[]
     */
    public function all(): array
    {
        return array_values($this->ads);
    }

    /**
     * @return AdId
     */
    public function nextIdentity(): AdId
    {
        return AdId::generate();
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->ads);
    }
}