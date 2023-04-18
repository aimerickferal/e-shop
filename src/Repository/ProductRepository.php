<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Method to find a Product by his name.
     * @param ProductSearch $productSearch
     * @return array
     */
    public function findProductByName(ProductSearch $productSearch): array
    {
        // We instanciate the QueryBuilder and we refers to the Product.
        $queryBuilder = $this->createQueryBuilder('product');
        // We say that the :name is egual to the name property of the Product Entity. 
        $queryBuilder->where('product.name LIKE :name');
        // We secure the query by setting a parameter to avoid the SQL injections. 
        $queryBuilder->setParameter(':name', "%$productSearch%");
        // We return the result of the query. 
        return $queryBuilder->getQuery()->getResult();
    }
}
