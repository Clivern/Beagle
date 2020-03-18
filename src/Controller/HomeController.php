<?php

namespace App\Controller;

use App\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Model(namespace="namespace1", version=1, types={"json","xml"})
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @Model(namespace="namespace2", version=2, types={"json","xml"})
     */
    public function index(Request $request)
    {
        return $this->json(['status' => 'ok']);
    }
}