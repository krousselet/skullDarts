<?php

namespace App\Controller;

use App\Entity\Sondage;
use App\Entity\Vote;
use App\Form\VoteFormType;
use App\Repository\SondageRepository;
use App\Repository\VoteRepository;
use App\Service\Sort\VoteSortingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SondageController extends AbstractController
{
    private VoteSortingService $voteSortingService;

    public function __construct(VoteSortingService $voteSortingService)
    {
        $this->voteSortingService = $voteSortingService;
    }

    #[Route('/sondages', name: 'app_sondages')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, SondageRepository $sondageRepository, VoteRepository $voteRepository): Response
    {
        $sondages = $sondageRepository->findAll();
        $user = $this->getUser();
        $userVotes = [];
        foreach ($sondages as $sondage) {
            $vote = $voteRepository->findOneBy(['sondage' => $sondage, 'user' => $user]);
            $userVotes[$sondage->getId()] = $vote ? $vote->isVoted() : false;
        }

        return $this->render('sondage/index.html.twig', [
            'sondages' => $sondages,
            'userVotes' => $userVotes,
        ]);
    }

    #[Route('/sondages/{id}/vote', name: 'vote_sondage', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function voteSondage(Sondage $sondage = null, Request $request, VoteRepository $voteRepository, Security $security): Response
    {
        if (!$sondage) {
            throw $this->createNotFoundException('No sondage found for id ' . $request->attributes->get('id'));
        }
        $vote = new Vote();
        $form = $this->createForm(VoteFormType::class, $vote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vote->setSondage($sondage);
            $vote->setUser($security->getUser());
            $vote->setVoted(true);
            $voteRepository->save($vote, true);
            $this->addFlash('success', 'Votre vote a bien été pris en compte !');

            return $this->redirectToRoute('app_sondages');
        }

        return $this->render('sondage/index-id.html.twig', [
            'voteForm' => $form->createView(),
            'sondage' => $sondage,
        ]);
    }

    #[Route('/sondages/{id}/resultats', name: 'resultat_sondage', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function showResult(Sondage $sondage = null, Request $request, SondageRepository $sondageRepository, VoteRepository $voteRepository): Response
    {
        if (!$sondage) {
            return new JsonResponse(['status' => 'Sondage introuvable'], Response::HTTP_NOT_FOUND);
        }

        $votes = $voteRepository->findBy(['sondage' => $sondage]);
        $sortedVotes = $this->voteSortingService->sortVotes($votes);

        return $this->render('sondage/index-id-consult.html.twig', [
            'sondage' => $sondage,
            'votes' => $sortedVotes,
        ]);
    }
}
