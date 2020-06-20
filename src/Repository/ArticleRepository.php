<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findAllPublishedOrderedByNewest()
    {
        return $this->addIsPublishedQueryBuilder()
            ->orderBy('a.published_at', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder
     */
    private function addIsPublishedQueryBuilder(QueryBuilder $qb = null): ?QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)
            ->andWhere('a.published_at IS NOT NULL');
    }

    /**
     * @param QueryBuilder|null $qb
     * @return QueryBuilder|null
     */
    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): ?QueryBuilder
    {
        return $qb ?: $this->createQueryBuilder('a');
    }
}
