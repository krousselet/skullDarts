<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Service\Email\SendEmailService;
use App\Service\JWT\JWTService;
use App\Service\User\UserCreationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserCreationService $userService, JWTService $jwt, SendEmailService $email): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userService->registerUser($user, [
                'plainPassword' => $form->get('plainPassword')->getData(),
                'nom' => $form->get('nom')->getData(),
                'prenom' => $form->get('prenom')->getData(),
                'telephone' => $form->get('telephone')->getData(),
                'email' => $form->get('email')->getData(),
            ]);

            // do anything else you need here, like send an email
            //TOKEN GENERATION (3 parts)

            //part 1 is descriptive
            $header = [
                'type' => 'JWT',
                'alg' => 'HS256'
            ];

            //part 2 is specific data inside the json
            $payload = [
                'user_id' => $user->getId()
            ];

            //part 3 is token generation itself
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));
            //EMAIL SENDING
            $email->send(
                $this->getParameter('app.devemail'),
                $user->getEmail(),
                'Activation de votre compte sur Skull Darts 71',
                'register',
                compact('user', 'token')
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
