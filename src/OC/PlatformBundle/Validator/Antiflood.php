<?php


namespace OC\PlatformBundle\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * Class Antiflood
 *
 * @package Validator
 * @category Constraint
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 *
 * @Annotation
 */
class Antiflood extends Constraint
{
    public $message = 'Vous avez déjà posté un message il y a moins de %seconds% secondes, merci d\'attendre un peu.';

    /**
     * Give name of service that will validate constraint
     *
     * @return string
     */
    public function validatedBy()
    {
        return 'oc_platform_antiflood';
    }
}