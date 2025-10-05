<?php

namespace App\Repository;

use App\Entity\WorkspaceCustomInput;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WorkspaceCustomInput>
 */
final class WorkspaceCustomInputRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkspaceCustomInput::class);
    }
}
