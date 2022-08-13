<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\CommitteeMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CommitteeMember>
 *
 * @method CommitteeMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommitteeMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommitteeMember[]    findAll()
 * @method CommitteeMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommitteeMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommitteeMember::class);
    }

    public function add(CommitteeMember $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommitteeMember $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
