<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\CategorySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Method to find a Category by his name.
     * @param CategorySearch $categorySearch
     * @return array
     */
    public function findCategoryByName(CategorySearch $categorySearch): array
    {
        // We instanciate the QueryBuilder and we refers to the Category.
        $queryBuilder = $this->createQueryBuilder('category');
        // We say that the :name is egual to the name property of the Category Entity. 
        $queryBuilder->where('category.name LIKE :name');
        // We secure the query by setting a parameter to avoid the SQL injections. 
        $queryBuilder->setParameter(':name', "%$categorySearch%");
        // We return the result of the query. 
        return $queryBuilder->getQuery()->getResult();
    }
}
