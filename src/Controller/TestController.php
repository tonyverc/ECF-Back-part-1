<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/user', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/user/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    // Fonction qui recupere l'ensemble des users et les trie par ordre alphabetique d'email
    #[Route('/user', name: 'app_test')]
    public function user( ManagerRegistry $doctrine): Response
    {
     $em = $doctrine->getManager();
     $UserRepository= $em ->getRepository(User::class);
     
     $orderByMail = $UserRepository->findBy([],['email' => 'ASC']);
     return $this->render('test/user/index.html.twig', [
        'users' => $orderByMail
     ]);

    }
};
