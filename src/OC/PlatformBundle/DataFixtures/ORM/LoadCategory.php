<?php

namespace OC\PlatformBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Category;

/**
 * Class LoadCategory
 *
 * - Load category fixtures
 *
 * @package OCPlatform\Bundle
 * @category Doctrine Fixture
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class LoadCategory implements FixtureInterface
{
    /**
     * Load fixtures
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $categories = [
            'Développement Web',
            'Développement mobile',
            'Graphisme',
            'Intégration',
            'Réseau'
        ];

        foreach ($categories as $categoryName) {

            $category = new Category();
            $category->setName($categoryName);

            $manager->persist($category);
        }

        $manager->flush();
    }

}