<?php

namespace App\Repository;

use App\Entity\Workspace;
use App\Model\Pagination;
use App\ORM\Utils\PlatformTools;
use App\Utils\Strings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workspace>
 */
final class WorkspaceRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly PlatformTools $platformTools,
    ) {
        parent::__construct($registry, Workspace::class);
    }

    /**
     * @return list<Workspace>
     */
    public function findForList(Pagination $pagination): array
    {
        $qb = $this->createQueryBuilder('workspace');
        $qb->where($qb->expr()->isNull('workspace.deletedAt'));
        $qb->setFirstResult(($pagination->page - 1) * $pagination->perPage);
        $qb->setMaxResults($pagination->perPage);
        $qb->orderBy('workspace.id', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findForDetail(int $id, ?string $query = null): ?Workspace
    {
        $qb = $this->createQueryBuilder('workspace');
        $qb->select('workspace, contact, contactGroup, customInputValue, workspaceCustomInput');
        if (Strings::isNullOrWhiteSpace($query)) {
            $qb->leftJoin('workspace.contacts', 'contact');
        } else {
            $qb->leftJoin(
                join: 'workspace.contacts',
                alias: 'contact',
                conditionType: Join::WITH,
                condition: $qb->expr()->orX(
                    $qb->expr()->like('contact.firstname', ':query'),
                    $qb->expr()->like('contact.lastname', ':query'),
                    $qb->expr()->like('contact.email', ':query'),
                ),
            );
            $qb->setParameter('query', '%' . $this->platformTools->escapeStringForLike($query) . '%');
        }
        $qb->leftJoin('contact.groups', 'contactGroup');
        $qb->leftJoin('contact.customInputValues', 'customInputValue');
        $qb->leftJoin('customInputValue.workspaceCustomInput', 'workspaceCustomInput');
        $qb->where($qb->expr()->eq('workspace.id', $qb->createNamedParameter($id)));
        $qb->andWhere($qb->expr()->isNull('workspace.deletedAt'));
        return $qb->getQuery()->getOneOrNullResult();
    }
}
