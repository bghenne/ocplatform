<?php


namespace CoreBundle\Service;


use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class MailNotifier
 *
 * @package
 * @category
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 * @license
 * @copyright
 */
class MailNotifier
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @return \Swift_Mailer
     */
    public function getMailer() : \Swift_Mailer
    {
        return $this->mailer;
    }

    /**
     * @param \Swift_Mailer $mailer
     *
     * @return MailNotifier
     */
    public function setMailer(\Swift_Mailer $mailer) : MailNotifier
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * MailNotifier constructor.
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
     * Notify by mail
     *
     * @param $message
     * @param UserInterface $user
     *
     * @return void
     */
    public function notifiyByMail($message, UserInterface $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject("Nouveau message d'un utilisateur surveillé")
            ->setFrom('benjamin_ghenne@yahoo.fr')
            ->setTo('benjamin_ghenne@yahoo.fr')
            ->setBody(sprintf("L'utilisateur surveillé %s a posté le message suivant : %s", $user->getUsername(), $message))
        ;

        $this->mailer->send($message);

    }


}