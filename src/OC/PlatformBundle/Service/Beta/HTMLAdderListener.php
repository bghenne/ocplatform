<?php


namespace OC\PlatformBundle\Service\Beta;


use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class Listener
 *
 * @package OCPlatformBundle
 * @category Listener
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 * @license
 * @copyright
 */
class HTMLAdderListener
{
    /**
     * @var HTMLAdder $htmlAdderService
     */
    private $htmlAdderService;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @return HTMLAdder
     */
    public function getHtmlAdderService() : HTMLAdder
    {
        return $this->htmlAdderService;
    }

    /**
     * @param HTMLAdder $htmlAdderService
     *
     * @return HTMLAdderListener
     */
    public function setHtmlAdderService($htmlAdderService) : HTMLAdderListener
    {
        $this->htmlAdderService = $htmlAdderService;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate() : \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return HTMLAdderListener
     */
    public function setEndDate($endDate) : HTMLAdderListener
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * HTMLAdderListener constructor.
     *
     * @param HTMLAdder $htmlAdderService
     * @param string $endDate
     *
     * @return void
     */
    public function __construct(HTMLAdder $htmlAdderService, string $endDate)
    {
        $this->setHtmlAdderService($htmlAdderService)
            ->setEndDate(new \DateTime($endDate));
    }

    /**
     * Process add banner
     *
     * @param FilterResponseEvent $event
     * @access public
     *
     * @return void
     */
    public function processAddBanner(FilterResponseEvent $event) : void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $remainingDays = $this->getEndDate()->diff(new \DateTime())->days;

        if ($remainingDays <= 0) {
            return;
        }

        $response = $this->getHtmlAdderService()->addBetaBanner($event->getResponse(), $remainingDays);

        $event->setResponse($response);
    }

}