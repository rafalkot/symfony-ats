<?php

namespace Ats\Infrastructure\Persistence\Doctrine\Project;

use Ats\Domain\Project\Model\Project;
use Ats\Domain\Project\Repository\ProjectRepository;
use Ats\Domain\Project\ValueObject\ProjectId;
use Doctrine\ORM\EntityManager;

class DoctrineProjectRepository implements ProjectRepository
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

    public function save(Project $project)
    {
        $this->em->persist($project);
        $this->em->flush();
    }

    public function remove(Project $project)
    {
        $this->em->remove($project);
        $this->em->flush();
    }

    public function projectOfId(ProjectId $projectId)
    {
        return $this->em->find(Project::class, $projectId);
    }

    public function all() : array
    {
        return $this->em->createQueryBuilder()
            ->select('p')
            ->from(Project::class, 'p')
            ->getQuery()
            ->getResult();
    }

    public function nextIdentity(): ProjectId
    {
        return ProjectId::generate();
    }

    public function size(): int
    {
        return $this->em->createQueryBuilder()
            ->select('count(p.id)')
            ->from(Project::class, 'p')
            ->getQuery()
            ->getSingleScalarResult();
    }
}