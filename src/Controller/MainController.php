<?php

namespace App\Controller;

use App\Repository\EmpruntRepository;
use App\Entity\Livre;
use doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class MainController extends AbstractController
{
    #[Route('/', name: 'Accueil', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $livreRepository = $em->getRepository(Livre::class);

        if ($request->isMethod('POST')) {

            $livre = new Livre();
            $livre->setTitre($request->get('livre'));
            $livre->setAnneeEdition($request->get('annee'));
            $livre->setNombrePages($request->get('pages'));
            $livre->setGenre($request->get('genre'));
        
        }

        $livres = $livreRepository->findAll();


        return $this->render('main/index.html.twig'
        ,[
                'livres' => $livres
        ]);
    }



    #[Route("/livre/{id}", name: "details_livre", methods: ["GET"])]

    public function details(Livre $livre, EmpruntRepository $empruntRepository): Response
    {
        // Récupérer les emprunts non retournés pour ce livre
        $empruntsNonRendus = $empruntRepository->findBy([
            'livre' => $livre,
            'dateRetour' => null, // Les emprunts non retournés n'ont pas de date de retour
        ]);

        $disponible = empty($empruntsNonRendus);

        return $this->render('test/livre/details.html.twig', [
            'livre' => $livre,
            'disponible' => $disponible,
        ]);
    }
}



