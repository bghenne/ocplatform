<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
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
     * @param string $page
     * @access public
     *
     * @return Response
     */
    public function indexAction(string $page) : Response
    {
        if ($page < 1) {
            return new NotFoundHttpException(sprintf('Page %s does not exist', $page));
        }

        $numberPerPage = $this->container->getParameter('paginator_number_per_page');

        $listAdverts = $this->getDoctrine()->getRepository('OCPlatformBundle:Advert')->getAdvertsWithCategoriesAndImage($page, $numberPerPage);

        $numberOfPages = ceil(count($listAdverts) / $numberPerPage);

        if ($page > $numberOfPages) {
            throw $this->createNotFoundException(sprintf('La page %s n\'existe pas', $page));
        }

        return $this->render('@OCPlatform/Advert/index.html.twig', [
            'page' => $page,
            'listAdverts' => $listAdverts,
            'numberOfPages' => $numberOfPages
        ]);
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
        $serviceDoctrine = $this->getDoctrine();

        $advertRepository = $serviceDoctrine->getRepository('OCPlatformBundle:Advert');

        $advert = $advertRepository->find($id);

        if (null === $advert) {
            return $this->render('@OCPlatform/Advert/view.html.twig');
        }

        $applicationRepository = $serviceDoctrine->getRepository('OCPlatformBundle:Application');
        $advertSkillsRpository = $serviceDoctrine->getRepository('OCPlatformBundle:AdvertSkill');

        $applications = $applicationRepository->findBy(['advert' => $advert]);
        $advertSkills = $advertSkillsRpository->findBy(['advert' => $advert]);

        return $this->render('@OCPlatform/Advert/view.html.twig', array(
            'advert' => $advert,
            'applications' => $applications,
            'advertSkills' => $advertSkills
        ));
    }

    /**
     * Add new ad
     * 
     * @access public
     *
     * @return Response
     */
    public function addAction(Request $request) : Response
    {
        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->render('@OCPlatform/Advert/add.html.twig');
        }

        $this->addFlash('notice', 'Annonce sauvegardée correctement');

        return $this->redirectToRoute('oc_platform_view', ['id' => $advert->getId()]);
    }

    /**
     * Edit ad
     *
     * @param int $id
     * @param Request $request
     * @access public
     *
     * @return Response
     */
    public function editAction(int $id, Request $request) : Response
    {
        $serviceDoctrine = $this->getDoctrine();

        $advertRepository = $serviceDoctrine->getRepository('OCPlatformBundle:Advert');

        /** @var Advert $advert */
        $advert = $advertRepository->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException(sprintf('Advert with id %s not found', $id));
        }

        if (!$request->isMethod(Request::METHOD_POST)) {
            return $this->render('@OCPlatform/Advert/add.html.twig');
        }

        $this->addFlash('notice', 'Annonce sauvegardée correctement');

        return $this->redirectToRoute('oc_platform_view', ['id' => $advert->getId()]);

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
        $serviceDoctrine = $this->getDoctrine();

        $advertRepository = $serviceDoctrine->getRepository('OCPlatformBundle:Advert');

        /** @var Advert $advert */
        $advert = $advertRepository->find($id);

        $categories = $serviceDoctrine->getRepository('OCPlatformBundle:Category')->findAll();

        foreach ($categories as $category) {
            $advert->removeCategory($category);
        }

        $serviceDoctrine->getManager()->flush();

        return $this->render('@OCPlatform/Advert/delete.html.twig');
    }

    /**
     * Purge adverts without applications
     *
     * @param int $days
     * @access public
     *
     * @return Response
     */
    public function purgeAction(int $days) : Response
    {
        try {
            /** @var \OC\PlatformBundle\Service\Purger\Advert $advertService */
            $purgerAdvertService = $this->get('oc_platform_service_purger.advert');

            $purgerAdvertService->purge($days);

            $message = sprintf('Purge for %s last days done with success !', $days);
        } catch(\Exception $e) {
            $message = 'An error occurred while purging';
        }

        return new Response($message);
    }
}