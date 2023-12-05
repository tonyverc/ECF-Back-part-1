<?php

namespace App\Entity;
namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use App\Entity\Genre;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @extends ServiceEntityRepository<Livre>
 *
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

//    /**
//     * @return Livre[] Returns an array of Livre objects
//     */
   public function findByTitle(): array
   {
       return $this->createQueryBuilder('l')
                    ->select('l.titre')
                    ->where('l.titre LIKE :motCle')
                    ->setParameter('motCle', '%lorem%')
                    ->orderBy('l.titre', 'ASC')
                    ->getQuery()
                    ->getResult();
                
       ;
   }

    public function findByAuthor(): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.auteur = :auteurId')
            ->setParameter('auteurId', 2)
            ->orderBy('l.titre', 'ASC')
            ->getQuery()
            ->getResult()
        ;
                    
    }

    public function findByGenre($genre)
    {
        return $this->createQueryBuilder('l')
        ->innerJoin('l.genres', 'g')
        ->andwhere('g.nom LIKE :nom')
        ->setParameter('nom',"%$genre%")
        ->orderBy('l.titre', 'ASC')
        ->getQuery()
        ->getResult()
        ;
        
    }
//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
