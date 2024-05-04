<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
 /**
     * Get the number of users with role = 0
     *
     * @return int
     */
    public function countUsersWithRoleZero(): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->andWhere('u.role = :role')
            ->setParameter('role', 0)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get the number of users with role = 1
     *
     * @return int
     */
    public function countUsersWithRoleOne(): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(u)')
            ->andWhere('u.role = :role')
            ->setParameter('role', 1)
            ->getQuery()
            ->getSingleScalarResult();
    }


    /**
     * Finds users by their name containing the provided search term.
     *
     * @param string $searchTerm
     * @return array
     */
    public function findByNomContaining(string $searchTerm): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.nom LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
