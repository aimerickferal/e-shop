<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductSearchByName;
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
     * Method to find a product by his name.
     * @param ProductSearchByName $productSearchByName
     * @return array
     */
    public function findProductByName(ProductSearchByName $productSearchByName): array
    {
        // We instanciate the QueryBuilder and we refers to the product.
        $queryBuilder = $this->createQueryBuilder('product');
        // We say that the :name is egual to the name property of the product entity. 
        $queryBuilder->where('product.name LIKE :name');
        // We secure the query by setting a parameter to avoid the SQL injections. 
        $queryBuilder->setParameter(':name', "%$productSearchByName%");
        // We return the result of the query. 
        return $queryBuilder->getQuery()->getResult();
    }
}
