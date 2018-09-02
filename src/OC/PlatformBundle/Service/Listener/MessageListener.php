<?php


namespace OC\PlatformBundle\Service\Listener;

use CoreBundle\Service\MailNotifier;
use OC\PlatformBundle\Event\MessagePostedEvent;

/**
 * Class MessageListener
 *
 * @package Service\Listener
 * @category MessageListener
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class MessageListener
{
    /**
     * @var MailNotifier $mailNotifierService
     */
    private $mailNotifierService;

    /**
     * @var array List of users to check
     */
    private $listUsers = [];

    /**
     * @return array
     */
    public function getListUsers() : array
    {
        return $this->listUsers;
    }

    /**
     * @param array $listUsers
     *
     * @return MessageListener
     */
    public function setListUsers($listUsers) : MessageListener
    {
        $this->listUsers = $listUsers;

        return $this;
    }


    /**
     * @return MailNotifier
     */
    public function getMailNotifierService() : MailNotifier
    {
        return $this->mailNotifierService;
    }

    /**
     * @param MailNotifier $mailNotifierService
     *
     * @return MessageListener
     */
    public function setMailNotifierService($mailNotifierService) : MessageListener
    {
        $this->mailNotifierService = $mailNotifierService;

        return $this;
    }

    /**
     * MessageListener constructor.
     *
     * @param MailNotifier $mailNotifierService
     * @param array $listUsers
     *
     * @return void
     */
    public function __construct(MailNotifier $mailNotifierService, array $listUsers)
    {
        $this->setMailNotifierService($mailNotifierService)
            ->setListUsers($listUsers);
    }

    /**
     * Send notification
     *
     * @param MessagePostedEvent $event
     * @access public
     *
     * @return void
     */
    public function sendNotification(MessagePostedEvent $event) : void
    {
        if (in_array($event->getUser()->getUsername(), $this->getListUsers())) {
            $this->getMailNotifierService()->notifiyByMail($event->getMessage(), $event->getUser());
        }
    }

}