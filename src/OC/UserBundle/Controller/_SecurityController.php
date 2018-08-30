<?php

namespace OC\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController - NOT USED
 *
 * @package OC\UserBundle
 * @category Controller
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class SecurityController extends Controller
{
    /**
     * NOT USED
     *
     * Login action
     *
     * @param Request $request
     * @access public
     * @deprecated
     *
     * @return Response
     */
    public function loginAction(Request $request) : Response
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('core_homepage');
        }

        // Dans un contrôleur :

        // Pour récupérer le service UserManager du bundle
        $userManager = $this->get('fos_user.user_manager');

        // Pour charger un utilisateur
        $user = $userManager->findUserBy(array('username' => 'winzou'));

        // Pour modifier un utilisateur
        $user->setEmail('cetemail@nexiste.pas');
        $userManager->updateUser($user); // Pas besoin de faire un flush avec l'EntityManager, cette méthode le fait toute seule !

        // Pour supprimer un utilisateur
        $userManager->deleteUser($user);

        // Pour récupérer la liste de tous les utilisateurs
        $users = $userManager->findUsers();

        /** @var AuthenticationUtils $authenticationUtils */
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('@OCUser/Security/login.html.twig', [
           'last_username' => $authenticationUtils->getLastUsername(),
           'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }
}