<?php

namespace Ats\Infrastructure\Persistence\Doctrine\Ad;

use Ats\Domain\Ad\Model\Ad;
use Ats\Domain\Ad\Repository\AdRepository;
use Ats\Domain\Ad\ValueObject\AdId;
use Doctrine\ORM\EntityManager;

class DoctrineAdRepository implements AdRepository
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function save(Ad $ad)
    {
        $this->em->persist($ad);
        $this->em->flush();
    }

    public function remove(Ad $ad)
    {
        $this->em->remove($ad);
        $this->em->flush();
    }

    public function adOfId(AdId $adId)
    {
        return $this->em->find(Ad::class, $adId);
    }

    public function all(): array
    {
        return $this->em->createQueryBuilder()
            ->select('p')
            ->from(Ad::class, 'p')
            ->getQuery()
            ->getResult();
    }

    public function nextIdentity(): AdId
    {
        return AdId::generate();
    }

    public function size(): int
    {
        return $this->em->createQueryBuilder()
            ->select('count(a.id)')
            ->from(Ad::class, 'a')
            ->getQuery()
            ->getSingleScalarResult();
    }
}