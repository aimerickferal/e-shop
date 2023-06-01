<?php

namespace App\Repository;

use App\Entity\Admin\AdminDeliveryModeSearchByName;
use App\Entity\DeliveryMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeliveryMode>
 *
 * @method DeliveryMode|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryMode|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryMode[]    findAll()
 * @method DeliveryMode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryMode::class);
    }

    public function save(DeliveryMode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DeliveryMode $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return DeliveryMode[] Returns an array of DeliveryMode objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DeliveryMode
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Method to find a delivery mode by his name.
     * @param AdminDeliveryModeSearchByName $adminDeliveryModeSearchByName
     * @return array
     */
    public function findDeliveryModeByName(AdminDeliveryModeSearchByName $adminDeliveryModeSearchByName): array
    {
        // We instanciate the QueryBuilder and we refers to the delivery mode.
        $queryBuilder = $this->createQueryBuilder('deliveryMode');
        // We say that the :name is egual to the name property of the delivery mode entity. 
        $queryBuilder->where('deliveryMode.name LIKE :name');
        // We secure the query by setting a parameter to avoid the SQL injections. 
        $queryBuilder->setParameter(':name', "%$adminDeliveryModeSearchByName%");
        // We return the result of the query. 
        return $queryBuilder->getQuery()->getResult();
    }
}
