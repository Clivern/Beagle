<?php

declare(strict_types=1);

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Annotation\Before;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Home Controller.
 *
 * @Before(namespace="namespace1", version=1, types={"json","xml"})
 */
class HomeController extends AbstractController
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
     * @Route("/", name="app.index")
     * @Before(namespace="namespace2", version=2, types={"json","xml"})
     */
    public function index(Request $request)
    {
        return $this->render('guest/home.html.twig', [
            'site_title' => 'Turtle',
        ]);
    }
}
