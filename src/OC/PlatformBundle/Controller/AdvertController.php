<?php
/**
 * Created by PhpStorm.
 * User: ben
 * Date: 13/08/18
 * Time: 14:34
 */

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AdvertController
 *
 * @package OC\PlatformBundle
 * @category Controller
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class AdvertController extends Controller
{
    /**
     * Display ads
     *
     * @param int $page
     * @access public
     *
     * @return Response
     */
    public function indexAction(int $page) : Response
    {
        if ($page < 1) {
            return new NotFoundHttpException(sprintf('Page %s does not exist', $page));
        }

        $listAdverts = array(
            array(
                'title'   => 'Recherche développpeur Symfony',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'Mission de webmaster',
                'id'      => 2,
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'Offre de stage webdesigner',
                'id'      => 3,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'Lead Developer',
                'id'      => 4,
                'author'  => 'Ben',
                'content' => 'Nous proposons un poste de Lead Developer. Blabla…',
                'date'    => new \Datetime()),
            array(
                'title'   => 'CTO',
                'id'      => 5,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime())
        );


        return $this->render('@OCPlatform/Advert/index.html.twig', ['page' => $page, 'listAdverts' => $listAdverts]);
    }

    /**
     * View specific add
     * 
     * @param int $id
     * @access public
     * 
     * @return Response
     */
    public function viewAction(int $id) : Response
    {
        $advert = array(
            'title'   => 'Recherche développpeur Symfony2',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
        );

        return $this->render('@OCPlatform/Advert/view.html.twig', array(
            'advert' => $advert
        ));
    }

    /**
     * Add new ad
     * 
     * @access public
     *
     * @return Response
     */
    public function addAction() : Response
    {
        return new Response();
    }

    /**
     * Edit ad
     *
     * @param int $id
     * @access public
     *
     * @return Response
     */
    public function editAction(int $id) : Response
    {
        $advert = array(
            'title'   => 'Recherche développpeur Symfony',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
        );

        return $this->render('@OCPlatform/Advert/edit.html.twig', array(
            'advert' => $advert
        ));

    }

    /**
     * Delete action
     *
     * @param int $id
     * @access public
     *
     * @return Response
     */
    public function deleteAction(int $id) : Response
    {
        return $this->render('@OCPlatform/Advert/delete.html.twig');
    }
}