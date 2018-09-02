<?php


namespace OC\PlatformBundle\Event;

use OC\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class MessagePostedEvent
 *
 * @package OCPlatformBundle
 * @category Event
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class MessagePostedEvent extends Event
{
    /**
     * @var string message
     */
    private $message;

    /**
     * @var User $user
     */
    private $user;

    /**
     * MessagePostEvent constructor.
     *
     * @param string $message
     * @param UserInterface $user
     * @access public
     *
     * @return void
     */
    public function __construct(string $message, UserInterface $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Get message
     *
     * @access public
     *
     * @return string
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Set message
     *
     * @param string $message
     * @access public
     *
     * @return MessagePostedEvent
     */
    public function setMessage(string $message) : MessagePostedEvent
    {
        $this->message = $message;
    }

    /**
     * Get user
     *
     * @access public
     *
     * @return UserInterface
     */
    public function getUser() : UserInterface
    {
        return $this->user;
    }
}