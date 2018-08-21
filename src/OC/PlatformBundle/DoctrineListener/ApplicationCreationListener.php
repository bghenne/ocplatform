<?php

namespace OC\PlatformBundle\DoctrineListener;


use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Service\Mailer\ApplicationMailer;

/**
 * Class ApplicationCreationListener
 *
 * @package DoctrineListener
 * @category Listener
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class ApplicationCreationListener
{
    /**
     * @var ApplicationMailer $applicationMailer
     */
    private $applicationMailer;

    /**
     * Get application mailer
     *
     * @return ApplicationMailer
     */
    public function getApplicationMailer()
    {
        return $this->applicationMailer;
    }

    /**
     * Set application mailer
     *
     * @param ApplicationMailer $applicationMailer
     *
     * @return ApplicationCreationListener
     */
    public function setApplicationMailer(ApplicationMailer $applicationMailer)
    {
        $this->applicationMailer = $applicationMailer;

        return $this;
    }

    /**
     * ApplicationCreationListener constructor.
     *
     * @param ApplicationMailer $applicationMailer
     *
     * @return void
     */
    public function __construct(ApplicationMailer $applicationMailer)
    {
        $this->setApplicationMailer($applicationMailer);
    }

    /**
     * Doctrine event
     *
     * @param LifecycleEventArgs $args
     *
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Application) {
            return;
        }

        $this->getApplicationMailer()->sendNotification($entity);
    }
}