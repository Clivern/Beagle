<?php

/*
 * This file is part of the Turtle project.
 * (c) Clivern <hello@clivern.com>
 */

namespace App\Controller;

use App\Annotation\Before;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Before(namespace="namespace1", version=1, types={"json","xml"})
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @Before(namespace="namespace2", version=2, types={"json","xml"})
     */
    public function index(Request $request)
    {
        return $this->json(['status' => 'ok']);
    }
}
