<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\Event;

use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdPublication;
use Ats\Domain\Ad\ValueObject\AdTitle;

class AdPublicationChanged extends AdEvent
{
    /**
     * @var AdPublication
     */
    protected $adPublication;

    public function __construct(AdId $adId, AdTitle $adTitle, AdPublication $adPublication)
    {
        parent::__construct($adId, $adTitle);

        $this->adPublication = $adPublication;
    }

    /**
     * @return AdPublication
     */
    public function adPublication(): AdPublication
    {
        return $this->adPublication;
    }
}
