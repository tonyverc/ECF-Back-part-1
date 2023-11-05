<?php

namespace App\Repository;

use App\Entity\Emprunteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunteur>
 *
 * @method Emprunteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunteur[]    findAll()
 * @method Emprunteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmprunteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunteur::class);
    }

//    /**
//     * @return Emprunteur[] Returns an array of Emprunteur objects
//     */
   public function findByName(): array
   {
       return $this->createQueryBuilder('e')
           ->orderBy('e.nom', 'ASC')
           ->addOrderBy('e.prenom', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   public function findById($userId) {

    return $this->createQueryBuilder('e')
        ->innerJoin('e.user', 'u')  // Jointure entre Emprunteur (e) et User (u)
        ->where('u.id = :userId')   // Filtrer par ID de l'utilisateur
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function findEmprunteursWithMotCle($motCle) {

        return $this->createQueryBuilder('e')
            ->where('e.nom LIKE :motCle OR e.prenom LIKE :motCle')
            ->setParameter('motCle', '%' . $motCle . '%')
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }
    
    public function findNumberPhone(){

        return $this->createQueryBuilder('e')
        ->where('e.telephone LIKE :keyword')
        ->setParameter('keyword', '%1234%')
        ->orderBy('e.nom', 'ASC')
        ->addOrderBy('e.prenom', 'ASC')
        ->getQuery()
        ->getResult();
    }
    
    public function findEmprunteursByDate(){

        $date = new \DateTime('2021-03-01');
    
        return $this->createQueryBuilder('e')
            ->where('e.createdAt < :date')
            ->setParameter('date', $date)
            ->orderBy('e.nom', 'ASC')
            ->addOrderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getOneOrNullResult();
    }

        
    
}
