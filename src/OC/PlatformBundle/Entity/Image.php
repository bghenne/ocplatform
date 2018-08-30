<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Image
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
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @var UploadedFile
     *
     * @Assert\Image()
     */
    private $file;

    /**
     * @var string $tempFileName
     */
    private $tempFileName;

    /**
     * Get temp fileName
     *
     * @return string
     */
    public function getTempFileName()
    {
        return $this->tempFileName;
    }

    /**
     * Set temp fileName
     *
     * @param mixed $tempFileName
     *
     * @return Image
     */
    public function setTempFileName(string $tempFileName)
    {
        $this->tempFileName = $tempFileName;

        return $this;
    }

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
     * Set alt.
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set extension.
     *
     * @param string $extension
     *
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set file
     *
     * @param $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Pre Upload File
     *
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUploadFile()
    {
        $file = $this->getFile();

        if (null === $file) {
            return;
        }

        $this->setExtension($file->guessExtension())
            ->setAlt($file->getClientOriginalName());
    }

    /**
     * Handle file upload
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadFile()
    {
        $file = $this->getFile();

        if (null === $file) {
            return;
        }

        // look for oldFile
        $oldFile = $this->getDestinationDirectory() . '/' . $this->getId() . '.' . $this->getExtension();
        if (file_exists($oldFile)) {
            unlink($oldFile);
        }

        $file->move(
            $this->getDestinationDirectory(),
            $this->getId() . '.' . $this->getExtension());
    }

    /**
     * Pre Remove Upload
     *
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        $this->setTempFileName($this->getDestinationDirectory() . $this->getId() . '.' . $this->getExtension());
    }

    /**
     * Post Remove Upload
     *
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getTempFileName();

        if (null === $file) {
            return;
        }

        if (file_exists($file)) {
            unlink($file);
        }
    }

    /**
     * Get file destination directory
     *
     * @access public
     *
     * @return string
     */
    public function getDestinationDirectory()
    {
        return __DIR__ . '/../../../../web/uploads/images/';
    }


}
