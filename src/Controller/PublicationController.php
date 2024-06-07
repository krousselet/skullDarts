<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentFormType;
use App\Repository\CommentaireRepository;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
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
    public function show(PublicationRepository $repository, $id, CommentaireRepository $commentaireRepository, Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Fetch the publication by ID along with its detail
        $publication = $repository->findPublicationWithDetail($id);
        $now = new \DateTimeImmutable();

        if (!$publication) {
            throw $this->createNotFoundException('La publication n\'existe pas');
        }

        $comment = new Commentaire();
        $user = $security->getUser();

        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreation($now);
            $comment->setUtilisateur($user);
            $comment->setPublication($publication);

            $entityManager->persist($comment);
            $entityManager->flush();

            // Redirect to the same page to display the new comment
            return $this->redirectToRoute('app_publication_show', ['id' => $id]);
        }

        $comments = $commentaireRepository->findBy(['publication' => $publication]);

        return $this->render('publication/index-id.html.twig', [
            'addCommentForm' => $form->createView(),
            'publication' => $publication,
            'commentaires' => $comments,
        ]);
    }
}
