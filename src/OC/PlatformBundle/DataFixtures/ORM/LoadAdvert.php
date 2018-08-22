<?php

namespace OC\PlatformBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Advert;

/**
 * Class LoadAdvert
 *
 * - Load advert fixtures
 *
 * @package OCPlatform\Bundle
 * @category Doctrine Fixture
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class LoadAdvert implements FixtureInterface
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
        for ($i = 1; $i <= 10; $i++) {

            $advert = new Advert();
            $advert->setTitle(sprintf('Advert %s', $i))
                   ->setAuthor(sprintf('Author %s', $i))
                   ->setEmail(sprintf('author_%s@toto.com', $i))
                   ->setContent(sprintf('Content %s', $i))
                   ->setDate(new \DateTime('2018-08-' . (10 == $i ? '10' : '0' . $i)))
                   ->setPublished(true);

            $manager->persist($advert);
        }

        $manager->flush();
    }
}