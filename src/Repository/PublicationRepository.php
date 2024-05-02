<?php

namespace App\Repository;

use App\Entity\Publication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Publication>
 *
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    public function findByDateCreationAndForum($idForum)
{
    return $this->createQueryBuilder('d')
        ->andWhere('d.idforum = :idforum')
        ->setParameter('idforum', $idForum)
        ->orderBy('d.datecreation', 'ASC')
        ->getQuery()
        ->getResult();
}
public function findMostFrequentForumId()
{
    $result = $this->createQueryBuilder('p')
        ->select('f.idforum, COUNT(p) AS nombre_de_publications')
        ->leftJoin('p.idforum', 'f')
        ->groupBy('f.idforum')
        ->orderBy('nombre_de_publications', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();

    return $result['idforum'] ?? null;
}
//    /**
//     * @return Publication[] Returns an array of Publication objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Publication
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
