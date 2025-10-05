<?php

namespace App\Repository;

use App\Entity\WorkspaceCustomInputValue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkspaceCustomInputValue>
 */
final class WorkspaceCustomInputValueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkspaceCustomInputValue::class);
    }
}
