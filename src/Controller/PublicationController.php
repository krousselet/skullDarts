<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    #[Route('/publication', name: 'app_publication')]
    public function index(PublicationRepository $repository): Response
    {
        // Fetch the 10 most recent publications
        $publications = $repository->findBy([], ['creation' => 'DESC'], 10);

        return $this->render('publication/index.html.twig', [
            'publications' => $publications
        ]);
    }

    #[Route('/publication/{id}', name: 'app_publication_show', requirements: ['id' => '\d+'])]
    public function show(PublicationRepository $repository, $id): Response
    {
        // Fetch the publication by ID along with its detail
        $publication = $repository->findPublicationWithDetail($id);

        if (!$publication) {
            throw $this->createNotFoundException('The publication does not exist');
        }

        return $this->render('publication/index-id.html.twig', [
            'publication' => $publication,
        ]);
    }
}
