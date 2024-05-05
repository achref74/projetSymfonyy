<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

     /**
     * Find all questions by evaluation_id.
     *
     * @param int $evaluationId
     * @return Question[]
     */
    public function findAllByEvaluationId(int $evaluationId): array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.evaluation = :evaluationId')
            ->setParameter('evaluationId', $evaluationId)
            ->orderBy('q.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findLastByEvaluationId(int $evaluationId): ?array
    {
        $query = $this->createQueryBuilder('q')
            ->andWhere('q.evaluation = :evaluationId')
            ->setParameter('evaluationId', $evaluationId)
            ->orderBy('q.id', 'DESC') // Trie par ID de façon décroissante pour obtenir le dernier
            ->setMaxResults(1) // Limite le résultat à un seul enregistrement (le dernier)
            ->getQuery();
    
        // Exécutez la requête et récupérez le résultat sous forme de tableau associatif
        $result = $query->getOneOrNullResult();
    
        // Si aucun résultat n'est trouvé, retournez simplement null
        if (!$result) {
            return null;
        }
    
        // Retournez le résultat sous forme de tableau
        return [$result];
    }
    public function findByEvaluationId(int $evaluationId): array
    {
        return $this->createQueryBuilder('q')
            ->innerJoin('q.evaluation', 'e')
            ->andWhere('e.id = :evaluationId')
            ->setParameter('evaluationId', $evaluationId)
            ->getQuery()
            ->getResult();
    }

    public function findByEvaluationAndCourseIds( int $courseId): array
    {
        return $this->createQueryBuilder('q')
        ->join('q.evaluation', 'e')
        ->join('e.cours', 'c')
        ->andWhere('c.id = :courseId')
        ->setParameter('courseId', $courseId)
        ->orderBy('e.id', 'DESC') // Order by evaluation ID in descending order to get the latest
        ->getQuery()
        ->getResult();
    }
//    /**
//     * @return Question[] Returns an array of Question objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
