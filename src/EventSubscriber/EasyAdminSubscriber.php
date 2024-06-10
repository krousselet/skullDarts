<?php

namespace App\EventSubscriber;

use App\Entity\Utilisateur;
use App\Event\Sondage\SondageCreatedEvent;
use App\Service\Email\SendEmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private SendEmailService $sendEmailService;
    private EntityManagerInterface $entityManager;

    public function __construct(SendEmailService $sendEmailService, EntityManagerInterface $entityManager)
    {
        $this->sendEmailService = $sendEmailService;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SondageCreatedEvent::NAME => 'onSondageCreated',
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onSondageCreated(SondageCreatedEvent $event): void
    {
        $sondage = $event->getSondage();


        $users = $this->entityManager->getRepository(Utilisateur::class)->findAll();

        foreach ($users as $user) {
            $this->sendEmailService->send(
               'adamrodwebdev@gmail.com',
                $user->getEmail(),
                'Votre présence',
                'presence',
                [
                    'sondage' => $sondage,
                    'user' => $user,
                ]
            );
        }

    }
}
