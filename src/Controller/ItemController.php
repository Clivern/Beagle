<?php

declare(strict_types=1);

/*
 * This file is part of the Beagle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Module\Validator;
use App\Service\ItemService;
use App\Utils\Config;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Item Controller.
 *
 * @Route("/api/v1/item")
 */
class ItemController extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Validator */
    private $validator;

    /** @var ItemService */
    private $itemService;

    /** @var Config */
    private $config;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        Validator $validator,
        ItemService $itemService,
        Config $config
    ) {
        $this->logger = $logger;
        $this->validator = $validator;
        $this->itemService = $itemService;
        $this->config = $config;
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="item.indexAction", requirements={"id"="\d+"})
     */
    public function indexAction(Request $request)
    {
        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("", methods={"GET"}, name="item.listAction")
     */
    public function listAction(Request $request)
    {
        $limit = (int) $request->query->get('limit');
        $offset = (int) $request->query->get('offset');

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("", methods={"POST"}, name="item.createAction")
     */
    public function createAction(Request $request)
    {
        $data = $request->getContent();

        $this->validator->validate($data, 'v1/item/createAction.schema.json');

        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", methods={"PUT"}, name="item.updateAction", requirements={"id"="\d+"})
     *
     * @param mixed $id
     */
    public function updateAction(Request $request, $id)
    {
        $data = $request->getContent();

        $this->validator->validate($data, 'v1/item/updateAction.schema.json');

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="item.deleteAction", requirements={"id"="\d+"})
     *
     * @param mixed $id
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
