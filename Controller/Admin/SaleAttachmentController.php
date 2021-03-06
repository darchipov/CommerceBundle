<?php

namespace Ekyna\Bundle\CommerceBundle\Controller\Admin;

use Ekyna\Bundle\AdminBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class SaleAttachmentController
 * @package Ekyna\Bundle\CommerceBundle\Controller\Admin
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SaleAttachmentController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function homeAction()
    {
        throw new NotFoundHttpException();
    }

    /**
     * {@inheritdoc}
     */
    public function listAction(Request $request)
    {
        throw new NotFoundHttpException();
    }

    /**
     * {@inheritdoc}
     */
    public function showAction(Request $request)
    {
        throw new NotFoundHttpException();
    }

    /**
     * Download action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function downloadAction(Request $request)
    {
        $context = $this->loadContext($request);

        $resourceName = $this->config->getResourceName();
        /** @var \Ekyna\Component\Commerce\Common\Model\SaleAttachmentInterface $resource */
        $resource = $context->getResource($resourceName);

        $this->isGranted('VIEW', $resource);

        $fs = $this->get('local_commerce_filesystem');
        if (!$fs->has($resource->getPath())) {
            throw new NotFoundHttpException('File not found');
        }
        $file = $fs->get($resource->getPath());

        $response = new Response($file->read());
        $response->setPrivate();

        $response->headers->set('Content-Type', $file->getMimetype());
        $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $resource->guessFilename()
        );

        return $response;
    }
}
