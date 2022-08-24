<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgencelocController extends AbstractController
{
    /**
     * @Route("/agenceloc", name="app_agenceloc")
     */
    public function index(): Response
    {
        return $this->render('agenceloc/index.html.twig', [
            'controller_name' => 'AgencelocController',
        ]);
    }
}
