<?php

namespace App\Repository;

use App\Entity\Offer;
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function save(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLikeName(?string $name, ?string $location, ?Category $category): array
    {
        $queryBuilder = $this->createQueryBuilder('o');

        if ($name) {
            $queryBuilder->andWhere('o.title LIKE :name')
            ->setParameter('name', '%' . $name . '%');
        }

        if ($location) {
            $queryBuilder->andWhere('o.location LIKE :location')
                ->setParameter('location', '%' . $location . '%');
        }

        if ($category) {
            $queryBuilder->andWhere('o.category = :category')
                ->setParameter('category', $category);
        }

        $queryBuilder->orderBy('o.title', 'ASC');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }
}
