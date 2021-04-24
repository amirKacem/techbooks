<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

   
    public function findLastBooks(Int $nb){
        return $this->createQueryBuilder('p')
                ->orderBy('p.id','DESC')
                ->setMaxResults($nb)
                ->getQuery()
                ->getResult();
    }

    public function getBooksStatistcs(){
        $em = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $sql = 'SELECT 
        (SELECT COUNT(*) FROM books ) as books,
        (SELECT COUNT(*) FROM categories) as categories,
        (SELECT COUNT(*) FROM author ) as authors,
        (SELECT COUNT(*) from comment) as comments;
        ';
         $rsm->addScalarResult('books','books');
         $rsm->addScalarResult('categories','categories');
         $rsm->addScalarResult('authors','authors');
         $rsm->addScalarResult('comments','comments');
        return $em->createNativeQuery($sql,$rsm)->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Book
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
