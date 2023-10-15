<?php

namespace App\Entity;
namespace App\Repository;

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
class Author {
    /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    // #[Assert\DateTime]
    protected string $createdAt;
};