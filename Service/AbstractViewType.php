<?php

namespace Ekyna\Bundle\CommerceBundle\Service;

use Ekyna\Component\Commerce\Common\Model;
use Ekyna\Component\Commerce\Common\View\AbstractViewType as BaseType;
use Ekyna\Component\Commerce\Subject\Provider\SubjectProviderRegistryInterface;
use Ekyna\Component\Commerce\Subject\SubjectHelperInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class AbstractViewType
 * @package Ekyna\Bundle\CommerceBundle\Service
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractViewType extends BaseType
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var SubjectHelperInterface
     */
    private $subjectHelper;


    /**
     * Sets the url generator.
     *
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function setUrlGenerator(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Sets the subject provider registry.
     *
     * @param SubjectHelperInterface $subjectHelper
     */
    public function setSubjectHelper(SubjectHelperInterface $subjectHelper)
    {
        $this->subjectHelper = $subjectHelper;
    }

    /**
     * Generates the url.
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return string
     */
    protected function generateUrl($name, array $parameters = [])
    {
        return $this->urlGenerator->generate($name, $parameters, UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * Resolves the item's subject.
     *
     * @param Model\SaleItemInterface $item
     * @param bool                    $throw
     *
     * @return mixed
     *
     * @see SubjectProviderRegistryInterface
     */
    protected function resolveItemSubject(Model\SaleItemInterface $item, $throw = true)
    {
        return $this->subjectHelper->resolve($item, $throw);
    }
}
