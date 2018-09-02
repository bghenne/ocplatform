<?php

namespace OC\PlatformBundle\Twig\Extension;

use OC\PlatformBundle\Service\Antispam\Antispam as AntispamService;

/**
 * Class Antispam
 *
 * @package OC\PlatformBundle
 * @category Twig Extension
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class Antispam extends \Twig_Extension
{
    /**
     * @var AntispamService $ocAntispamService
     */
    private $antispamService;

    /**
     * Get antispam service
     *
     * @return AntispamService
     */
    public function getAntispamService() : AntispamService
    {
        return $this->antispamService;
    }

    /**
     * @param AntispamService $antispamService
     *
     * @return Antispam
     */
    public function setAntispamService(AntispamService $antispamService) : Antispam
    {
        $this->antispamService = $antispamService;

        return $this;
    }

    /**
     * Antispam constructor.
     *
     * @param AntispamService $antispamService
     * $access public
     *
     * @return void
     */
    public function __construct(AntispamService $antispamService)
    {
        $this->setAntispamService($antispamService);
    }

    /**
     * Check if argument is spam
     *
     * @param string $testedText
     * @access public
     *
     * @return bool
     */
    public function checkIfArgumentIsSpam(string $testedText) : bool
    {
        return $this->getAntispamService()->isSpam($testedText);
    }

    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('checkIfSpam', [$this, 'checkIfArgumentIsSpam'])
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'AntispamExtension';
    }


}