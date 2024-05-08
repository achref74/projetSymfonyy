<?php

namespace App\Repository;

use App\Entity\Formation;
use App\Entity\Offre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use App\Repository\OffreRepository;

/**
 * @extends ServiceEntityRepository<Formation>
 *
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }
    // public function findAllWithOffres(): array
    // {
    //     return $this->createQueryBuilder('f')
    //         ->leftJoin('App\Entity\Offre', 'o', 'WITH', 'o.formation = f.idFormation')
    //         ->addSelect('o')
    //         ->getQuery()
    //         ->getResult();
    // }
    public function findAllWithOffres()
    {
        $formations = $this->createQueryBuilder('f')
        ->getQuery()
        ->getResult();

    $offreRepository = $this->getEntityManager()->getRepository(Offre::class);

    foreach ($formations as $formation) {
        $offres = $offreRepository->findBy(['formation' => $formation]);
        $formation->setOffres($offres);
    }

    return $formations;
    }

    // Inside your FormationRepository.php
    public function findBySearchTerm($searchTerm)
    {
        $queryBuilder = $this->createQueryBuilder('f');
    
        if ($searchTerm) {
            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('f.nom', ':searchTerm'),
                $queryBuilder->expr()->like('f.description', ':searchTerm'),
                $queryBuilder->expr()->like('f.dated', ':searchTerm'),
                $queryBuilder->expr()->like('f.datef', ':searchTerm'),
                $queryBuilder->expr()->like('f.prix', ':searchTerm'),
                $queryBuilder->expr()->like('f.nbrcours', ':searchTerm')
            ))
            ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    
        return $queryBuilder->getQuery()->getResult();
    }
    


//    /**
//     * @return Formation[] Returns an array of Formation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Formation
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
