<?php

namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 *
 * @package CoreBundle\Controller
 * @category Controller
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * Display three ads
     *
     * @access public
     *
     * @return Response
     */
    public function indexAction() : Response
    {
        $listAdverts = array(
            array(
                'title'   => 'Recherche développpeur Symfony',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date'    => new \Datetime('2018-08-01')),
            array(
                'title'   => 'Mission de webmaster',
                'id'      => 2,
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date'    => new \Datetime('2018-08-02')),
            array(
                'title'   => 'Offre de stage webdesigner',
                'id'      => 3,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime('2018-08-03')),
            array(
                'title'   => 'Lead Developer',
                'id'      => 4,
                'author'  => 'Ben',
                'content' => 'Nous proposons un poste de Lead Developer. Blabla…',
                'date'    => new \Datetime('2018-08-04')),
            array(
                'title'   => 'CTO',
                'id'      => 5,
                'author'  => 'Tom',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime('2018-08-05'))
        );

        // sort array to get the most recents first based on dates
        usort($listAdverts, function($item1, $item2) {
            $date1 = $item1['date']->format('Y-m-d');
            $date2 = $item2['date']->format('Y-m-d');
            if ($date1 == $date2)  {
               return 0;
            }

            return $date1 < $date2 ? 1 : -1;
        });

        // extract three first results
        $listAdverts = array_slice($listAdverts, 0, 3);

        return $this->render('@Core/Default/index.html.twig', [
            'listAdverts' => $listAdverts
        ]);
    }
}
