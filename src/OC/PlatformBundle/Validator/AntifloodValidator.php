<?php


namespace OC\PlatformBundle\Validator;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AntifloodValidator
 *
 * @package Validator
 * @category Validator
 * @author b-ghenne <benjamin.ghenne@gmail.com>
 */
class AntifloodValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @return RequestStack
     */
    public function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return AntifloodValidator
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;

        return $this;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager() : EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @return AntifloodValidator
     */
    public function setEntityManager($entityManager) : AntifloodValidator
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * AntifloodValidator constructor.
     *
     * @param RequestStack $requestStack
     * @param EntityManager $entityManager
     * @access public
     *
     * @return void
     */
    public function __construct(RequestStack $requestStack, EntityManager $entityManager)
    {
        $this->setRequestStack($requestStack)
            ->setEntityManager($entityManager);
    }

    /**
     * Validate value
     *
     * @param mixed $value
     * @param Constraint $constraint
     *
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        $ip = $this->getRequestStack()->getCurrentRequest()->getClientIp();

        $isFlood = $this->getEntityManager()
            ->getRepository('OCPlatformBundle:Advert')
            ->isFlood($ip, 300);

        if ($isFlood) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%seconds%',  300)
                ->addViolation();
        }
    }
}