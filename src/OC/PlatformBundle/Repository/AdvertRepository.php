<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Retrieve adverts with their categories
     *
     * @param array $categoryNames
     * @return mixed
     */
    public function getAdvertWithCategories(array $categoryNames)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->addSelect('c')
            ->join('a.categories', 'c');

        $queryBuilder->where($queryBuilder->expr()->in('c.name', $categoryNames));

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Get adverts with their categories and image
     *
     * @return mixed
     */
    public function getAdvertsWithCategoriesAndImage(int $page, int $nbPerPage)
    {
        $query = $this->createQueryBuilder('a')
            ->addSelect(['c', 'i'])
            ->leftJoin('a.categories', 'c')
            ->leftJoin('a.image', 'i')
            ->orderBy('a.date', 'DESC')
            ->getQuery();

        $query->setFirstResult(($page - 1) * $nbPerPage)
              ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }

    /**
     * Find purgeable adverts - there will be removed
     *
     * @param int $days
     *
     * @return mixed
     */
    public function findPurgeableAdverts(int $days)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.date <= :date_minus_days')
            ->andWhere('a.applications IS EMPTY')
            ->setParameter('date_minus_days', new \DateTime(sprintf('-%s days', $days)))
            ->getQuery();

        return $query->getResult();
    }

    /**
     * Check for flooding
     *
     * @param string $ip
     * @param int $frequencyInSeconds
     *
     * @return bool
     * @throws NonUniqueResultException
     */
    public function isFlood(string $ip, int $frequencyInSeconds = 15)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.date > :date_minus_seconds')
            ->andWhere('a.ip = :ip')
            ->setParameters([
                'date_minus_seconds' => new \DateTime(sprintf('-%s seconds', $frequencyInSeconds)),
                'ip' => $ip
            ])
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * Get the total of adverts
     *
     * @access public
     *
     * @return mixed
     * @throws NonUniqueResultException
     */
    public function getTotalAdverts()
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->getQuery();

        return $query->getSingleScalarResult();
    }
}
