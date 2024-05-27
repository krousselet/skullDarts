<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoiController extends AbstractController
{
    #[Route('/loi', name: 'app_loi')]
    public function index(): Response
    {
        return $this->render('loi/index.html.twig', [
            'controller_name' => 'LoiController',
        ]);
    }
}
