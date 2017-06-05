<?php

declare(strict_types=1);

namespace Ats\Domain\Ad\Event;

use Ats\Domain\Ad\ValueObject\AdId;
use Ats\Domain\Ad\ValueObject\AdTitle;
use Ats\Domain\Project\ValueObject\ProjectId;

class AdMovedToProject extends AdEvent
{
    /**
     * @var ProjectId
     */
    protected $projectId;

    public function __construct(AdId $adId, AdTitle $adTitle, ProjectId $projectId)
    {
        parent::__construct($adId, $adTitle);

        $this->projectId = $projectId;
    }

    /**
     * @return ProjectId
     */
    public function projectId(): ProjectId
    {
        return $this->projectId;
    }
}
