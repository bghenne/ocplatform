<?php

namespace OC\PlatformBundle\Service\Purger;

use Doctrine\ORM\EntityManager;

/**
 * Class Advert
 *
 * @package Service\Purger
 * @category Service
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class Advert
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @return EntityManager
     */
    public function getEntityManager() : EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @return Advert
     */
    public function setEntityManager(EntityManager $entityManager) : Advert
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * Advert constructor.
     *
     * @param EntityManager $entityManager
     *
     * @return void
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     * Purge adverts
     *
     * @param int $days
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return void
     */
    public function purge(int $days)
    {
        // find purgeable adverts
        $entityManager = $this->getEntityManager();
        $adverts = $entityManager->getRepository('OCPlatformBundle:Advert')->findPurgeableAdverts($days);

        if (empty($adverts)) {
            return;
        }

        foreach ($adverts as $advert) {
            $entityManager->remove($advert);
        }

        $entityManager->flush();
    }
}