<?php

namespace OC\UserBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
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
class LoadUser extends Fixture
{
    public const USER_REFERENCE = 'user-ben';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $listUsernames = ['Sam', 'Rémy', 'Ben'];

        foreach ($listUsernames as $username) {

            $user = new User();

            $user->setUsername($username)
                ->setPassword(hash('sha512', $username . '_password'))
                ->setEmail('benjamin_ghenne_' . $username . '@yahoo.fr')
                ->setSalt('')
                ->setEnabled(true)
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);

        }

        $this->addReference(self::USER_REFERENCE, $user);


        $manager->flush();
    }

}