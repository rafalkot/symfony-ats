<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\Event;

use Ats\Domain\Ad\ValueObject\AdContent;
use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdTitle;

class AdContentChanged extends AdEvent
{
    /**
     * @var AdContent
     */
    protected $adContent;

    public function __construct(AdId $adId, AdTitle $adTitle, AdContent $adContent)
    {
        parent::__construct($adId, $adTitle);

        $this->adContent = $adContent;
    }

    /**
     * @return AdContent
     */
    public function adContent(): AdContent
    {
        return $this->adContent;
    }
}
