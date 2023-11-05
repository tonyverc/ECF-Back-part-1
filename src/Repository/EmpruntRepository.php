<?php

namespace App\Repository;

use App\Entity\Emprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunt>
 *
 * @method Emprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunt[]    findAll()
 * @method Emprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunt::class);
    }

    public function findLast10Emprunts()
    {
        return $this->createQueryBuilder('e')
        ->orderBy('e.dateEmprunt', 'DESC') // Tri décroissant par date d'emprunt
        ->setMaxResults(10) // Limiter à 10 résultats
        ->getQuery()
        ->getResult();
    }

    public function findEmprunt()
    {
        return $this->createQueryBuilder('e')
        ->andWhere('e.emprunteur = :emprunteurId')
        ->setParameter('emprunteurId', 2)
        ->orderBy('e.dateEmprunt', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function findEmpruntsLivre3()
    {
    return $this->createQueryBuilder('e')
        ->andWhere('e.livre = :livreId')
        ->setParameter('livreId', 3)
        ->orderBy('e.dateEmprunt', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findDerniersEmpruntsRetournes()
    {
    return $this->createQueryBuilder('e')
        ->where('e.dateRetour IS NOT NULL')
        ->orderBy('e.dateRetour', 'DESC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();
    }

    public function findEmpruntsNonRetournesTriesParDate()
    {
        return $this->createQueryBuilder('e')
            ->where('e.dateRetour IS NULL')
            ->orderBy('e.dateEmprunt', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findEmpruntByLivreId($livreId)
    {
        return $this->createQueryBuilder('e')
            ->join('e.livre', 'l')
            ->where('l.id = :livreId')
            ->setParameter('livreId', $livreId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
