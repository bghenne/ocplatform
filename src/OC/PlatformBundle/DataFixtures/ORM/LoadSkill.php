<?php

namespace OC\PlatformBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\PlatformBundle\Entity\Category;
use OC\PlatformBundle\Entity\Skill;

/**
 * Class LoadSkill
 *
 * - Load skills fixtures
 *
 * @package OCPlatform\Bundle
 * @category Doctrine Fixture
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class LoadSkill implements FixtureInterface
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
        $skills = [
            'PHP',
            'Symfony',
            'C++',
            'Java',
            'Photoshop',
            'Blender',
            'Bloc-note'
        ];

        foreach ($skills as $skillName) {

            $skill = new Skill();
            $skill->setName($skillName);

            $manager->persist($skill);
        }

        $manager->flush();
    }

}