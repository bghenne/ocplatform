<?php

namespace OC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use OC\PlatformBundle\Entity\Advert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="OC\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Advert
     *
     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Advert", mappedBy="user")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adverts;

    /**
     * Add advert.
     *
     * @param Advert $advert
     *
     * @return User
     */
    public function addAdvert(Advert $advert)
    {
        $this->adverts[] = $advert;

        $advert->setUser($this);

        return $this;
    }

    /**
     * Remove advert.
     *
     * @param Advert $advert
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAdvert(Advert $advert)
    {
        return $this->adverts->removeElement($advert);
    }

    /**
     * Get adverts.
     *
     * @return Advert
     */
    public function getAdverts()
    {
        return $this->adverts;
    }
}
