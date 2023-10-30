<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Genre;
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
        $livreAuthor = $LivreRepository->findByAuthor();  
        
        //liste des livres dont le genre contient le mot clé `roman`, triée par ordre alphabétique de titre
        $genre = $LivreRepository->findByGenre('roman');

        $auteur = $em->getRepository(Auteur::class)->find(2);
        $genre = $em->getRepository(Genre::class)->find(6);

        //création d'un nouveau livre
        $livreNew = new Livre();
        $livreNew->setTitre('Totum autem id externum');
        $livreNew->setAnneeEdition(2020);
        $livreNew->setNombrePages(300);
        $livreNew->setCodeIsbn('9790412882714');
        $livreNew->setAuteur($auteur);
        $livreNew->addGenre($genre);
        $em->persist($livreNew);

        $em->flush();

        //mise a jour du livre avec l'id 2
        $livre2 = $em->getRepository(Livre::class)->find(2);
        $genre2 = $em->getRepository(Genre::class)->find(5);
        $livre2->setTitre('Aperiendum est igitur');
        $livre2->addGenre($genre2);
        $em->flush();

        //suppression du livre dont l'id est 123
        $livre123 = $em->getRepository(Livre::class)->find(123); 

        if ($livre123) {
            $emprunts = $em->getRepository(Emprunt::class)->findBy(['livre' => $livre123]);

            foreach ($emprunts as $emprunt) {
                $em->remove($emprunt);
            }

            $em->remove($livre123);
            $em->flush();
        }


        //affichage des resultat dans le template test/livre/index.html.twig
        return $this->render('test/livre/index.html.twig', [
          'orderByTitre' => $orderByTitre,
          'livre' => $livre,
          'title' => $title,
          'livreAuthor' => $livreAuthor,
          'genre' => $genre,
        ]);
    }
    
    #[Route('/emprunteur', name: 'emprunteur_test')]
    public function index2(): Response
    {
        return $this->render('test/emprunteur/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/emprunteur', name: 'emprunteur_test')]
    public function emprunteur( ManagerRegistry $doctrine ): Response
    {
        $em = $doctrine->getManager();
        $EmprunteurRepository= $em->getRepository(Emprunteur::class);

        //Liste des emprunteurs trieé par ordre alphabetique de nom et prenom
        $orderByNom = $EmprunteurRepository->findByName();

        //l'emprunteur dont l'id est 3
        $emprunteur3 = $EmprunteurRepository->find(3);

        //affichage des resultat dans le template test/emprunteur/index.html.twig
        return $this->render('test/emprunteur/index.html.twig', [
          'orderByNom' => $orderByNom,
          'emprunteur3' => $emprunteur3
        ]);

    }
};
    
