<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Module\Validator;
use App\Repository\ItemRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Item Controller.
 */
class ItemController extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /** @var Validator */
    private $validator;

    /** @var ItemRepository */
    private $itemRepository;

    /**
     * Class Constructor.
     */
    public function __construct(
        LoggerInterface $logger,
        Validator $validator,
        ItemRepository $itemRepository
    ) {
        $this->logger = $logger;
        $this->validator = $validator;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @Route("/api/v1/item/{id}", methods={"GET"}, name="item.indexAction", requirements={"id"="\d+"})
     */
    public function indexAction(Request $request)
    {
        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/item", methods={"GET"}, name="item.listAction")
     */
    public function listAction(Request $request)
    {
        $limit = (int) $request->query->get('limit');
        $offset = (int) $request->query->get('offset');

        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/item", methods={"POST"}, name="item.createAction")
     */
    public function createAction(Request $request)
    {
        return $this->json([], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/v1/item/{id}", methods={"PUT"}, name="item.updateAction", requirements={"id"="\d+"})
     *
     * @param mixed $id
     */
    public function updateAction(Request $request, $id)
    {
        return $this->json([], Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/item/{id}", methods={"DELETE"}, name="item.deleteAction", requirements={"id"="\d+"})
     *
     * @param mixed $id
     */
    public function deleteAction(Request $request, $id)
    {
        return $this->json([], Response::HTTP_NO_CONTENT);
    }
}
