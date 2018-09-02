<?php


namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CkeditorType
 *
 * @package OcPlatformBundle
 * @category Form
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class CkeditorType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['class' => 'ckeditor']
        ]);
    }

    /**
     * @return null|string
     */
    public function getParent()
    {
        return TextareaType::class;
    }


}