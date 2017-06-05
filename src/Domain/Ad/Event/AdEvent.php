<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\Event;

use Ats\Domain\Ad\ValueObject\AdTitle;
use Ats\Domain\Common\Event\DomainEvent;
use Ats\Domain\Ad\ValueObject\AdId;

abstract class AdEvent implements DomainEvent
{
    /**
     * @var AdId
     */
    protected $adId;

    /**
     * @var AdTitle
     */
    protected $adTitle;

    /**
     * @var \DateTime
     */
    protected $occurredOn;

    /**
     * @param AdId $adId
     * @param AdTitle $adTitle
     */
    public function __construct(AdId $adId, AdTitle $adTitle)
    {
        $this->adId = $adId;
        $this->adTitle = $adTitle;
        $this->occurredOn = new \DateTime();
    }

    /**
     * @return AdId
     */
    public function adId(): AdId
    {
        return $this->adId;
    }

    /**
     * @return AdTitle
     */
    public function adTitle(): AdTitle
    {
        return $this->adTitle;
    }

    /**
     * @return \DateTime
     */
    public function occurredOn(): \DateTime
    {
        return $this->occurredOn;
    }
}
