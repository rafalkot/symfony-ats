<?php

namespace Ats\Domain\Ad\Repository;

use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\ValueObject\AdId;

interface AdRepository
{
    /**
     * @param Ad $ad
     * @return void
     */
    public function save(Ad $ad);

    /**
     * @param Ad $ad
     * @return void
     */
    public function remove(Ad $ad);

    /**
     * @param AdId $adId
     * @return Ad
     */
    public function adOfId(AdId $adId);

    /**
     * @return Ad[]
     */
    public function all(): array;

    /**
     * @return AdId
     */
    public function nextIdentity(): AdId;

    /**
     * @return int
     */
    public function size(): int;
}
