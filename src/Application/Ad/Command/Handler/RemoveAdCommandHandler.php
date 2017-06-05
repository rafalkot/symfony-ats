<?php

namespace Ats\Application\Ad\Command\Handler;

use Ats\Application\Ad\Command\RemoveAdCommand;
use Ats\Domain\Ad\Exception\AdDoesNotExistException;
use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\Repository\AdRepository;
use Ats\Domain\Ad\ValueObject\AdId;

class RemoveAdCommandHandler
{
    /**
     * @var AdRepository
     */
    protected $ads;

    /**
     * @param AdRepository $ads
     */
    public function __construct(AdRepository $ads)
    {
        $this->ads = $ads;
    }

    public function handle(RemoveAdCommand $command)
    {
        $ad = $this->ads->adOfId(new AdId($command->id()));

        $this->checkAdExists($ad);

        $this->ads->remove($ad);
    }

    protected function checkAdExists(Ad $ad = null)
    {
        if (!$ad) {
            throw new AdDoesNotExistException();
        }
    }
}