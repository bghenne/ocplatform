<?php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\UserBundle\Entity\User;

/**
 * Class LoadUser
 *
 * @package OCUserBundle
 * @category Doctrine Fixture
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class LoadUser implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $listUsernames = ['Ben', 'Sam', 'Rémy'];

        foreach ($listUsernames as $username) {

            $user = new User();

            $user->setUsername($username)
                ->setPassword($username . '_password')
                ->setSalt('')
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);

        }

        $manager->flush();
    }

}