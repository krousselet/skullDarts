<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Form\AvatarFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ModifyAvatarController extends AbstractController
{
    #[Route('/modify/avatar', name: 'app_modify_avatar')]
    public function index(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $user = $this->getUser();
        $avatar = $user->getAvatar() ?: new Avatar();

        $form = $this->createForm(AvatarFormType::class, $avatar);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where avatars are stored
                try {
                    $imageFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception if something happens during file upload
                }

                // Update the 'path' property to store the image file name
                // instead of its contents
                $avatar->setPath($newFilename);
            }

            $avatar->setModification(new \DateTime()); // Update modification date
            $avatar->setUtilisateur($user);

            $entityManager->persist($avatar);
            $entityManager->flush();

            $this->addFlash('success', 'Avatar updated successfully');

            return $this->redirectToRoute('app_modify_avatar');
        }

        return $this->render('account/modify_avatar/index.html.twig', [
            'avatarForm' => $form->createView(),
        ]);
    }
}
