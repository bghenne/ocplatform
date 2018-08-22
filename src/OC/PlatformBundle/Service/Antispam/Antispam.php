<?php

namespace OC\PlatformBundle\Service\Antispam;

/**
 * Class Antispam
 *
 * @package PlatformBundle
 * @category Service
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class Antispam
{
    private $mailer;
    private $locale;
    private $minLength;

    /**
     * @return mixed
     */
    public function getMailer() : \Swift_Mailer
    {
        return $this->mailer;
    }

    /**
     * @param mixed $mailer
     *
     * @return OCAntispam
     */
    public function setMailer(\Swift_Mailer $mailer) : OCAntispam
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocale() : string
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     *
     * @return OCAntispam
     */
    public function setLocale(string $locale) : OCAntispam
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMinLength() : int
    {
        return $this->minLength;
    }

    /**
     * @param mixed $minLength
     *
     * @return OCAntispam
     */
    public function setMinLength(int $minLength) : OCAntispam
    {
        $this->minLength = $minLength;

        return $this;
    }

    public function __construct(\Swift_Mailer $mailer, string $locale, int $minLength)
    {
        $this->setMailer($mailer)
             ->setLocale($locale)
             ->setMinLength($minLength);
    }

    /**
     * Check if spam
     *
     * @param string $text
     * @access public
     *
     * @return bool
     */
    public function isSpam(string $text) : bool
    {
        return strlen($text) < $this->getMinLength();
    }
}