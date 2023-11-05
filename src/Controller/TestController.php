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
        $genreLivre = $LivreRepository->findByGenre('roman');

        $auteur = $em->getRepository(Auteur::class)->find(2);
        $genre = $em->getRepository(Genre::class)->find(6);

        //création d'un nouveau livre
        $livreNew = new Livre();{

            $livreNew->setTitre('Totum autem id externum');
            $livreNew->setAnneeEdition(2020);
            $livreNew->setNombrePages(300);
            $livreNew->setCodeIsbn('9790412882714');
            $livreNew->setAuteur($auteur);
            $livreNew->addGenre($genre);
            $em->persist($livreNew);
        }

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
          'genreLivre' => $genreLivre
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

        //l'unique emprunteur qui est relié au user dont l'id est `3`
        $uniqueEmprunteur = $EmprunteurRepository->findById(3);

        //- la liste des emprunteurs dont le nom ou le prénom contient le mot clé `foo`, triée par ordre alphabétique de nom et prénom
        $emprunteurWord = $EmprunteurRepository->findEmprunteursWithMotCle('foo');

        //la liste des emprunteurs dont le téléphone contient le mot clé `1234`, triée par ordre alphabétique de nom et prénom
        $numberPhone = $EmprunteurRepository->findNumberPhone();

        //la liste des emprunteurs dont la date de création est antérieure au 01/03/2021 exclu (c-à-d strictement plus petit), triée par ordre alphabétique de nom et prénom
        $emprunteurDate = $EmprunteurRepository->findEmprunteursByDate();

        //affichage des resultat dans le template test/emprunteur/index.html.twig
        return $this->render('test/emprunteur/index.html.twig', [
          'orderByNom' => $orderByNom,
          'emprunteur3' => $emprunteur3,
          'uniqueEmprunteur' => $uniqueEmprunteur,
          'emprunteurWord' => $emprunteurWord,
          'numberPhone' => $numberPhone,
          'emprunteurDate' => $emprunteurDate
        ]);

    }

    #[Route('/emprunt', name: 'emprunt_test')]
     public function index4(): Response
    {
        return $this->render('test/emprunt/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/emprunt', name: 'emprunt_test')]
    public function emprunt( ManagerRegistry $doctrine ): Response
    {
        $em = $doctrine->getManager();
        $EmpruntRepository= $em->getRepository(Emprunt::class);

        //la liste des 10 derniers emprunts au niveau chronologique, triée par ordre **décroissant** de date d'emprunt 
        $empruntList = $EmpruntRepository->findLast10Emprunts();

        //la liste des emprunts de l'emprunteur dont l'id est `2`, triée par ordre **croissant** de date d'emprunt
        $empruntUser2 = $EmpruntRepository->findEmprunt();

        //la liste des emprunts du livre dont l'id est `3`, triée par ordre **décroissant** de date d'emprunt
        $empruntLivre3 = $EmpruntRepository->findEmpruntsLivre3();

        // la liste des 10 derniers emprunts qui ont été retournés, triée par ordre **décroissant** de date de retour
        $empruntRetour = $EmpruntRepository->findDerniersEmpruntsRetournes();

        //la liste des emprunts qui n'ont pas encore été retournés triée par ordre **croissant** de date d'emprunt
        $empruntNonRetour = $EmpruntRepository->findEmpruntsNonRetournesTriesParDate();

        //l'unique emprunt relié au livre dont l'id est `3`
        $uniqueEmprunt = $EmpruntRepository->findEmpruntByLivreId(3);

        //création nouvelle emprunt
        //Récupérer l'emprunteur et le livre par leurs ID
         $emprunteur = $entityManager->getRepository(Emprunteur::class)->find(1); 
         $livre = $entityManager->getRepository(Livre::class)->find(1); 
 
         // Créer un nouvel emprunt
         $emprunt = new Emprunt();
         $emprunt->setDateEmprunt(new \DateTime('2020-12-01 16:00:00'));
         $emprunt->setEmprunteur($emprunteur);
         $emprunt->setLivre($livre);
 
         // Persister l'emprunt dans la base de données
         $entityManager->persist($emprunt);
         $entityManager->flush();
    

        return $this->render('test/emprunt/index.html.twig', [
          'empruntList' => $empruntList,
          'empruntUser2' => $empruntUser2,
          'empruntLivre3' => $empruntLivre3,
          'empruntRetour' => $empruntRetour,
          'empruntNonRetour' => $empruntNonRetour,
          'uniqueEmprunt' => $uniqueEmprunt
        ]);

    }

}
    
