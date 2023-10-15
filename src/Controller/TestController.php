<?php

namespace App\Controller;

use App\Entity\Emprunteur;
use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/test')]
class TestController extends AbstractController
{
    #[Route('/user', name: 'user_test')]
    public function index(): Response
    {
        return $this->render('test/user/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    
    #[Route('/user', name: 'user_test')]
    public function user( ManagerRegistry $doctrine): Response
    {
     $em = $doctrine->getManager();
     $UserRepository= $em ->getRepository(User::class);
     
     //Recuperation du user dont l'id est 1
     $user = $UserRepository->find(1);

     //Recuperation de tous les users triés par ordre alphabetique d'email
     $orderByMail = $UserRepository->findBy([],['email' => 'ASC']);

     //recuperation du user avec l'email foo.foo@example.com
     $email = $UserRepository->findBy(['email' => 'foo.foo@example.com']);

    //recuperation des users avec le role 'USER' triés par ordre alphabetique d'email
     $userRoles = $UserRepository->listUsers();

    //liste des utilisateurs inactifs triés par ordre alphabetique d'email
     $userEnabled = $UserRepository->findBy(['enabled' => false],['email' => 'ASC']);

     //affichage des résultat dans le template test/user/index.html.twig
     return $this->render('test/user/index.html.twig', [
        'orderByMail' => $orderByMail,
        'user' => $user,
        'email' => $email,
        'userRoles' => $userRoles,
        'userEnabled' => $userEnabled
     ]);

    }

    #[Route('/livre', name: 'livre_test')]
    public function index1(): Response
    {
        return $this->render('test/livre/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/livre', name: 'livre_test')]
    public function livre( ManagerRegistry $doctrine ): Response
    {
        $em = $doctrine->getManager();
        $LivreRepository= $em->getRepository(Livre::class);

        //Liste des livres triés par ordre alphabetique de titre
        $orderByTitre = $LivreRepository->findBy([],['titre' => 'ASC']);

       //Recuperation du livre dont l'id est 1
       $livre = $LivreRepository->find(1);

       //liste des livres contenant le mot clé 'lorem' triés par ordre alphabetique de titre
        $title = $LivreRepository-> findByTitle();

        //Liste des livres dont l'id de l'auteur est 2 triés par ordre alphabetique 
        $livreAuthor = $LivreRepository->findBy(['auteur' => 2],['titre' => 'ASC']);

        //affichage des resultat dans le template test/livre/index.html.twig
        return $this->render('test/livre/index.html.twig', [
          'orderByTitre' => $orderByTitre,
          'livre' => $livre,
          'title' => $title,
          'livreAuthor' => $livreAuthor
        ]);
    }


};
