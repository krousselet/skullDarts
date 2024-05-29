<?php

namespace App\Controller\Admin;

use App\Entity\Commentaire;
use App\Entity\Detail;
use App\Entity\Image;
use App\Entity\Publication;
use App\Entity\Reponse;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'app_admin')]
    #[isGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SkullDarts71');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Menu', 'fa fa-home');
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::subMenu('Actions utilisateurs', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir mes Utilisateurs', 'fas fa-eye', Utilisateur::class),
        ]);
        yield MenuItem::section('Publications');
        yield MenuItem::subMenu('Actions sur les publications', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir mes publications', 'fas fa-eye', Publication::class),
            MenuItem::linkToCrud('Ajouter une publication', 'fas fa-plus', Publication::class)->setAction(crud::PAGE_NEW),
        ]);
        yield MenuItem::section('Commentaires');
        yield MenuItem::subMenu('Actions sur les commentaires', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir mes commentaires', 'fas fa-eye', Commentaire::class),
        ]);
        yield MenuItem::section('Images');
        yield MenuItem::subMenu('Actions sur les images', 'fas fa-bars fa-picture')->setSubItems([
            MenuItem::linkToCrud('Voir mes images', 'fas fa-eye', Image::class),
            MenuItem::linkToCrud('Ajouter une image', 'fas fa-plus', Image::class)->setAction(crud::PAGE_NEW),
        ]);
        yield MenuItem::section('Réponses');
        yield MenuItem::subMenu('Actions sur les réponses', 'fas fa-bars fa-picture')->setSubItems([
            MenuItem::linkToCrud('Voir mes réponses', 'fas fa-eye', Reponse::class),
        ]);
        yield MenuItem::section('Details');
        yield MenuItem::subMenu('Actions sur les details', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir mes details', 'fas fa-eye', Detail::class),
            MenuItem::linkToCrud('Ajouter des details', 'fas fa-plus', Detail::class)->setAction(crud::PAGE_NEW),
        ]);
    }
}
