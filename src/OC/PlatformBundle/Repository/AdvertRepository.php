<?php

namespace OC\PlatformBundle\Repository;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAdvertWithCategories(array $categoryNames)
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->addSelect('c')
            ->join('a.categories', 'c');

        $queryBuilder->where($queryBuilder->expr()->in('c.name', $categoryNames));

        return $queryBuilder->getQuery()->getResult();

    }
}
