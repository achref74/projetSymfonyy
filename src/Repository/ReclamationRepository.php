<?php

namespace App\Repository;
use App\Entity\Reclamation;
use App\Controller\ReclamationController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reclamation>
 *
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }


    public function findBySearchTerm($searchTerm)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.description LIKE :searchTerm ')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
    }

    public function findBySearchTermAndUserId($searchTerm, $userId)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.description LIKE :searchTerm ')
            ->andWhere('r.user = :userId')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
    
   


    public function calculStat()
{
    $entityManager = $this->getEntityManager();

    $query = $entityManager->createQuery(
        'SELECT 
            f.nom AS formation_nom, 
            COUNT(r.id) AS Nombre_Reclamations,
            (COUNT(r.id) * 100.0 / (SELECT COUNT(r2.id) FROM reclamation r2)) AS Pourcentage_Total
        FROM 
            reclamation r 
        JOIN 
            r.user u 
        JOIN 
            r.formation f
        GROUP BY 
            f.nom'
    );

    return $query->getResult();
}

    
    
    
//    /**
//     * @return Reclamation[] Returns an array of Reclamation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reclamation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
