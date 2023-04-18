<?php

namespace App\Repository;

use App\Entity\Address;
use App\Entity\AddressSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Address $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Address $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Address[] Returns an array of Address objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Address
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Method to find a Address by his city.
     * @param AddressSearch $addressSearch
     * @return array
     */
    public function findAddressByCity(AddressSearch $addressSearch): array
    {
        // We instanciate the QueryBuilder and we refers to the Address.
        $queryBuilder = $this->createQueryBuilder('address');
        // We say that the :city is egual to the city property of the address Entity. 
        $queryBuilder->where('address.city LIKE :city');
        // We secure the query by setting a parameter to avoid the SQL injections. 
        $queryBuilder->setParameter(':city', "%$addressSearch%");
        // We return the result of the query. 
        return $queryBuilder->getQuery()->getResult();
    }
}
