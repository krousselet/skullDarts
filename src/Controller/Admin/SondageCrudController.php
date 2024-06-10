<?php

namespace App\Controller\Admin;

use App\Entity\Sondage;
use App\Event\Sondage\SondageCreatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ORM\EntityManagerInterface;
class SondageCrudController extends AbstractCrudController
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getEntityFqcn(): string
    {
        return Sondage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('question'),
            DateTimeField::new('date'),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Sondage) {
            parent::persistEntity($entityManager, $entityInstance);  // Ensure ID is generated
            $entityManager->flush();  // Persist changes to database

            $event = new SondageCreatedEvent($entityInstance);
            $this->eventDispatcher->dispatch($event, SondageCreatedEvent::NAME);
        } else {
            parent::persistEntity($entityManager, $entityInstance);
        }
    }
}