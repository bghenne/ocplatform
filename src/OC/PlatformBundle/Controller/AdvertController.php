<?php

namespace OC\PlatformBundle\Controller;

use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\AdvertSkill;
use OC\PlatformBundle\Entity\Skill;
use OC\PlatformBundle\Event\MessagePostedEvent;
use OC\PlatformBundle\Event\PlatformEvents;
use OC\PlatformBundle\Form\AdvertEditType;
use OC\PlatformBundle\Form\AdvertType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
    public function viewAction(Advert $advert) : Response
    {
        $serviceDoctrine = $this->getDoctrine();

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
     * @Security("has_role('ROLE_USER')")
     */
    public function addAction(Request $request) : Response
    {
        $advert = new Advert();

        /** @var FormBuilder $formBuilder */
        $form = $this->createForm(AdvertType::class, $advert);

        if (!$request->isMethod(Request::METHOD_POST) || !$form->handleRequest($request)->isValid()) {
            return $this->render('@OCPlatform/Advert/add.html.twig', ['form' => $form->createView()]);
        }

        $advert->setUser($this->getUser());

        $event = new MessagePostedEvent($advert->getContent(), $advert->getUser());

        $this->get('event_dispatcher')->dispatch(PlatformEvents::POST_MESSAGE, $event);

        $advert->setContent($event->getMessage());

        $entityManager = $this->getDoctrine()->getManager();
        $advert->setIp($request->getClientIp());
        $entityManager->persist($advert);

        $entityManager->flush();

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

        $form = $this->createForm(AdvertEditType::class, $advert);

        if (!$request->isMethod(Request::METHOD_POST) || !$form->handleRequest($request)->isValid()) {
            return $this->render('@OCPlatform/Advert/edit.html.twig', [
                'form' => $form->createView(),
                'advert' => $advert
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($advert);

        $entityManager->flush();

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
    public function deleteAction(int $id, Request $request) : Response
    {
        $serviceDoctrine = $this->getDoctrine();

        $advertRepository = $serviceDoctrine->getRepository('OCPlatformBundle:Advert');

        /** @var Advert $advert */
        $advert = $advertRepository->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException(sprintf('Advert with id %s not found', $id));
        }

        $form = $this->get('form.factory')->create();

        if (!$request->isMethod(Request::METHOD_POST) || !$form->handleRequest($request)->isValid()) {
            return $this->render('@OCPlatform/Advert/delete.html.twig', [
                'form' => $form->createView(),
                'advert' => $advert
            ]);
        }


        $categories = $serviceDoctrine->getRepository('OCPlatformBundle:Category')->findAll();

        if (!empty($categories)) {
            foreach ($categories as $category) {
                $advert->removeCategory($category);
            }
        }

        $entityManager = $serviceDoctrine->getManager();

        $entityManager->remove($advert);
        $entityManager->flush();

        $this->addFlash('notice', 'Annonce supprimée correctement');

        return $this->redirectToRoute('oc_platform_home');
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