<?php

namespace OC\PlatformBundle\Service\Mailer;


use OC\PlatformBundle\Entity\Application;

/**
 * Class ApplicationMailer
 *
 * @package Service
 * @category Mailer
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class ApplicationMailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Get mailer
     *
     * @return \Swift_Mailer
     */
    public function getMailer(): \Swift_Mailer
    {
        return $this->mailer;
    }

    /**
     * Set mailer
     *
     * @param \Swift_Mailer $mailer
     *
     * @return ApplicationMailer
     */
    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * ApplicationMailer constructor.
     *
     * @param \Swift_Mailer $mailer
     *
     * @return void
     */
    public function __construct(\Swift_Mailer $mailer)
    {
        $this->setMailer($mailer);
    }

    /**
     * Send notification when application is created
     *
     * @param Application $application
     *
     * @return int
     */
    public function sendNotification(Application $application) : int
    {
        $message = new \Swift_Message(
            'Nouvelle candidature',
            sprintf('Vous avez reçu une nouvelle candidature de %s', $application->getAuthor())
        );

        $message->addTo($application->getAdvert()->getEmail())
            ->addFrom('symfony@localhost');

        return $this->getMailer()->send($message);
    }
}