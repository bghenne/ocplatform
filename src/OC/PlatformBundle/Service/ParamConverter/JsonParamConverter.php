<?php


namespace OC\PlatformBundle\Service\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonDecode;

/**
 * Class JsonParamConverter
 *
 * @package OCPlatformBundle
 * @category ParamConverter
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class JsonParamConverter implements ParamConverterInterface
{
    /**
     * Apply converter
     *
     * @param Request $request
     * @param ParamConverter $configuration
     *
     * @return void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $json = $request->attributes->get('json');

        $json = json_decode($json, true);

        $request->attributes->set('json', $json);
    }

    /**
     * Does converter should by applied
     *
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        if ('json' !== $configuration->getName()) {
            return false;
        }

        return true;
    }

}