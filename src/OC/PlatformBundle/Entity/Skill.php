<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Skill
 *
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\SkillRepository")
 */
class Skill
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection(AdvertSkill)
     *
     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\AdvertSkill", mappedBy="advert")
     */
    private $advertSkills;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Skill
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->advertSkills = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add advertSkill.
     *
     * @param AdvertSkill $advertSkill
     *
     * @return Skill
     */
    public function addAdvertSkill(AdvertSkill $advertSkill)
    {
        $this->advertSkills[] = $advertSkill;

        return $this;
    }

    /**
     * Remove advertSkill.
     *
     * @param AdvertSkill $advertSkill
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAdvertSkill(AdvertSkill $advertSkill)
    {
        return $this->advertSkills->removeElement($advertSkill);
    }

    /**
     * Get advertSkills.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdvertSkills()
    {
        return $this->advertSkills;
    }
}
