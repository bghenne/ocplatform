<?php

namespace OC\PlatformBundle\Service\Beta;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class HTMLAdder
 *
 * @package OCPlatformBundle
 * @category Service
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class HTMLAdder
{
    /**
     * Add beta banner on website
     *
     * @param Response $response
     * @param int $remainingDays
     * @access public
     *
     * @return Response
     */
    public function addBetaBanner(Response $response, int $remainingDays) : Response
    {
        $content = $response->getContent();

        $html = '<div style="position: absolute; top: 0; background: orange; width: 100%; text-align: center; padding: 0.5em;">Beta J-'.(int) $remainingDays.' !</div>';

        $content = str_replace(
            '<body>',
            '<body> '.$html,
            $content
        );

        $response->setContent($content);

        return $response;

    }
}