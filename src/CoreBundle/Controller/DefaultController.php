<?php

namespace CoreBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
        $advertRepository = $this->getDoctrine()->getRepository('OCPlatformBundle:Advert');
        $listAdverts = $advertRepository->findBy([], ['date' => 'DESC'], 3);
        $totalNumberOfAdverts = $advertRepository->getTotalAdverts();
//
//        // sort array to get the most recents first based on dates
//        usort($listAdverts, function($item1, $item2) {
//            $date1 = $item1->getDate()->format('Y-m-d');
//            $date2 = $item2->getDate()->format('Y-m-d');
//            if ($date1 == $date2)  {
//               return 0;
//            }
//
//            return $date1 < $date2 ? 1 : -1;
//        });
//
//        // extract three first results
//        $listAdverts = array_slice($listAdverts, 0, 3);

        return $this->render('@Core/Default/index.html.twig', [
            'listAdverts' => $listAdverts,
            'totalNumberOfAdverts' => $totalNumberOfAdverts
        ]);
    }


    /**
     * Translation
     *
     * @access public
     * @param string $name
     *
     * @return Response
     */
    public function translationAction(string $name) : Response
    {
        return $this->render('@Core/Default/translation.html.twig', [
            'name' => $name
        ]);

        /**

        <?php
        $translator = $this->get('translator'); // depuis un contrôleur

        // Texte simple
        $translator->trans('maChaîne',  array('%placeholder%' => $placeholderValue) , 'domaine', $locale);

        // Texte avec gestion de pluriels
        $translator->transchoice($count, 'maChaîne',  array('%placeholder%' => $placeholderValue) , 'domaine', $locale)

         **/
    }

    /**
     * Test stuffs
     *
     * @param array $json
     *
     * @return void
     *
     * @ParamConverter("json")
     */
    public function testAction(array $json)
    {
        var_dump($json); die;
    }
}
