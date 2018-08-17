<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 *
 * @package CoreBundle\Controller
 * @category Controller
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class ContactController extends Controller
{
    /**
     * Contact action
     *
     * @access public
     *
     * @return Response
     */
    public function contactAction() : Response
    {
        $this->addFlash('info', 'La page contact n\'est pas encore disponible, merci de revenir plus tard');

        return $this->redirectToRoute('core_homepage');
    }
}