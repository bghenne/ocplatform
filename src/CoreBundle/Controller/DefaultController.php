<?php

namespace CoreBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
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
        $listAdverts = $this->getDoctrine()->getRepository('OCPlatformBundle:Advert')->findAll();

        // sort array to get the most recents first based on dates
        usort($listAdverts, function($item1, $item2) {
            $date1 = $item1->getDate()->format('Y-m-d');
            $date2 = $item2->getDate()->format('Y-m-d');
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


    /**
     * Test stuffs
     *
     * @access public
     *
     * @return Response
     */
    public function testAction() : Response
    {
        $advert = new Advert();
        $advert->setContent('Blabla')
            ->setAuthor('1')
            ->setEmail('totototo.com');

        $validator = $this->get('validator');

        $errors = $validator->validate($advert);

        return new Response((string) $errors);

    }
}
