<?php

namespace App\Repository;

use App\Entity\Workspace;
use App\Model\Pagination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workspace>
 */
final class WorkspaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workspace::class);
    }

    /**
     * @return list<Workspace>
     */
    public function findForList(Pagination $pagination): array
    {
        $qb = $this->createQueryBuilder('workspace');
        $qb->setFirstResult(($pagination->page - 1) * $pagination->perPage);
        $qb->setMaxResults($pagination->perPage);
        $qb->orderBy('workspace.id', 'ASC');
        return $qb->getQuery()->getResult();
    }
}
