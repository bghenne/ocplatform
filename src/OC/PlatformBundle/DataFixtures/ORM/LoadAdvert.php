<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;
use OC\UserBundle\DataFixtures\ORM\LoadUser;

/**
 * Class LoadAdvert
 *
 * - Load advert fixtures
 *
 * @package OCPlatform\Bundle
 * @category Doctrine Fixture
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class LoadAdvert extends Fixture
{
    /**
     * Load ten advert fixtures into database
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository('OCUserBundle:User')->find(1);

        for ($i = 1; $i <= 10; $i++) {

            $advert = new Advert();
            $advert->setTitle(sprintf('Advert %s', $i))
                   ->setAuthor(sprintf('Author %s', $i))
                   ->setEmail(sprintf('author_%s@toto.com', $i))
                   ->setContent(sprintf('Content %s', $i))
                   ->setDate(new \DateTime('2018-08-' . (10 == $i ? '10' : '0' . $i)))
                   ->setIp('127.0.0.1')
                   ->setUser($this->getReference(LoadUser::USER_REFERENCE))
                   ->setPublished(true);

            $manager->persist($advert);
        }

        $manager->flush();
    }

}