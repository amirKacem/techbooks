<?php

namespace App\Repository;

use App\Entity\Book;
use App\Entity\BookSearch;
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

   
    public function getAllBooksByCategorie($category_id)
    {
        return $this->createQueryBuilder('b')
            ->join('b.category','c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $category_id)
    
            ->getQuery()
           
        ;
    }

    public function findBooks(BookSearch $bookSearch){
        $query = $this->createQueryBuilder('b');
  
            if($bookSearch->getByCategory()){
                $query = $query->andWhere('b.category = :category_id')
                ->setParameter('category_id',$bookSearch->getByCategory()->getId());                
                    
            }
            if($bookSearch->getByKeyword()){
                
                $query = $query->andWhere('b.title LIKE  :k')
                        ->setParameter('k','%'.$bookSearch->getByKeyword().'%');
            }

            if($bookSearch->getByAuthor()){
                $query = $query->andWhere('b.author = :author_id')
                ->setParameter('author_id',$bookSearch->getByAuthor()->getId());    
            }
         
        return $query->getQuery();
    }
}
