<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    #[isGranted('ROLE_USER')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'user' => $user
        ]);
    }
}
