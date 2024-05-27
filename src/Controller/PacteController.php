<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PacteController extends AbstractController
{
    #[Route('/pacte', name: 'app_pacte')]
    public function index(): Response
    {
        return $this->render('pacte/index.html.twig', [
            'controller_name' => 'PacteController',
        ]);
    }
}
