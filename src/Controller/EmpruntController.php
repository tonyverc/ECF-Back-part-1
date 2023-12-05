<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Form\EmpruntType;
use App\Repository\EmpruntRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/emprunt')]
class EmpruntController extends AbstractController
{
    #[Route('/admin/emprunt', name: 'app_emprunt_index', methods: ['GET'])]
    
    public function index(EmpruntRepository $empruntRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        
        // Récupérer les emprunts en fonction du rôle de l'utilisateur
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur est admin, afficher tous les emprunts
            $emprunts = $empruntRepository->findAll();
        } elseif (in_array('ROLE_USER', $user->getRoles())) {
            // Si l'utilisateur est un emprunteur, afficher ses emprunts seulement
            $emprunts = $empruntRepository->findBy(['emprunteur' => $user]);
        } else {
            return $this->render('error.html.twig', [
                'message' => 'Accès non autorisé.'
            ]);
        }

        return $this->render('emprunt/index.html.twig', [
            'emprunts' => $emprunts,
        ]);
    }    
    #[Route('admin/emprunt/new', name: 'app_emprunt_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $emprunt = new Emprunt();
        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($emprunt);
            $entityManager->flush();

            return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emprunt/new.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    #[Route('admin/emprunt/{id}', name: 'app_emprunt_show', methods: ['GET'])]
    public function show(Emprunt $emprunt): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // Si l'utilisateur est admin, il a accès à tous les emprunts
            return $this->render('emprunt/show.html.twig', [
                'emprunt' => $emprunt,
            ]);
        } elseif (in_array('ROLE_USER', $user->getRoles())) {
            // Si l'utilisateur est un emprunteur
            // Vérifier si l'emprunt appartient à l'utilisateur
            if ($emprunt->getEmprunteur() === $user) {
                return $this->render('emprunt/show.html.twig', [
                    'emprunt' => $emprunt,
                ]);
            } else {
                throw new NotFoundHttpException('Emprunt non trouvé');
            }
        } else {

            return $this->render('error.html.twig', [
                'message' => 'Accès non autorisé.'
            ]);
        }
    }
    #[Route('admin/emprunt/{id}/edit', name: 'app_emprunt_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(EmpruntType::class, $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('emprunt/edit.html.twig', [
            'emprunt' => $emprunt,
            'form' => $form,
        ]);
    }

    #[Route('admin/emprunt/{id}', name: 'app_emprunt_delete', methods: ['DELETE'])]
    public function delete(Request $request, Emprunt $emprunt, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$emprunt->getId(), $request->request->get('_token'))) {
            $entityManager->remove($emprunt);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_emprunt_index', [], Response::HTTP_SEE_OTHER);
    }
}
