<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateurRepository;
use App\Service\Email\SendEmailService;
use App\Service\JWT\JWTService;
use App\Service\User\UserCreationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
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
            try {
                $email->send(
                    $this->getParameter('app.devemail'),
                    $user->getEmail(),
                    'Activation de votre compte sur Skull Darts 71',
                    'register',
                    compact('user', 'token')
                );
            } catch (TransportExceptionInterface $e) {
            }

            $this->addFlash('success', 'Un message vous a été envoyé à ' . $user->getEmail() . ' pour valider votre inscription');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verif/{token}', name: 'app_verify_user')]
    public function verifyUser($token, JWTService $jwt, UtilisateurRepository $repository, EntityManagerInterface $em): Response
    {
        //TOKEN VERIFICATION (NOT EXPIRED, NOT MODIFIED)
        if($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            //at this point the token is valid, we retrieve the data
            $payload = $jwt->getPayload($token);
            //PAYLOAD READING TO RETRIEVE THE USER
            $user = $repository->find($payload['user_id']);
            // VERIFICATION
            if($user && !$user->isVerified()) {
                $user->setVerified(true);
                $em->flush();
                $this->addFlash('success', 'L\'activation est réussie !');
                $this->redirectToRoute('app_account');
            }
        }
        $this->addFlash('danger', 'L\'activation a échoué');
        return $this->redirectToRoute('app_login');
    }
}
