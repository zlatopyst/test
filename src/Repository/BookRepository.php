<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    // /**
    //  * @return Book[] Returns an array of Book objects
    //  */
    
    public function findAllORM(int $two): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT title, count(b.author_id)
            FROM App\Entity\Book b
			GROUP BY b.title
			HAVING count(b.author_id) >= :two'
        )->setParameter('two', $two);

        // returns an array of Product objects
        return $query->getResult();
    }
    
	/**
	* @return Book[] Returns an array of Book objects
	*/  
    public function findAllSQL(int $two): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT b.title, COUNT(b.author_id) FROM Book b
            GROUP BY b.title
			HAVING COUNT(b.author_id) >= :two
			';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['two' => $two]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }
    
}
