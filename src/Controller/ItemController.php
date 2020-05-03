<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Item Controller.
 */
class ItemController extends AbstractController
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * Class Constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/api/v1/item/{id}", methods={"GET"}, name="item.indexAction", requirements={"id"="\d+"})
     */
    public function indexAction(Request $request)
    {
    }

    /**
     * @Route("/api/v1/item", methods={"GET"}, name="item.listAction")
     */
    public function listAction(Request $request)
    {
    }

    /**
     * @Route("/api/v1/item", methods={"POST"}, name="item.createAction")
     */
    public function createAction(Request $request)
    {
    }

    /**
     * @Route("/api/v1/item/{id}", methods={"PUT"}, name="item.updateAction", requirements={"id"="\d+"})
     *
     * @param mixed $id
     */
    public function updateAction(Request $request, $id)
    {
    }

    /**
     * @Route("/api/v1/item/{id}", methods={"DELETE"}, name="item.deleteAction", requirements={"id"="\d+"})
     *
     * @param mixed $id
     */
    public function deleteAction(Request $request, $id)
    {
    }
}
