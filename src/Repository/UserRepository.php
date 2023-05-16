<?php

namespace App\Repository;

use App\Entity\Admin\AdminUserSearch;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
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

    /**
     * Method to find a user by his role.
     * @param string $roles
     * @return array
     */
    public function findUsersByRoles(string $roles): array
    {
        // We instanciate the QueryBuilder and we refers to the user entity.
        $queryBuilder = $this->createQueryBuilder('user');
        // We say that the :roles is egual to the roles property of the user entity. 
        $queryBuilder->where('user.roles LIKE :roles');
        // We secure the query by setting a parameter to avoid the SQL injections. 
        $queryBuilder->setParameter(':roles', "%$roles%");
        // We return the result of the query. 
        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Method to find a user by his last name.
     * @param AdminUserSearch $adminUserSearch
     * @return array
     */
    public function findUserByLastName(AdminUserSearch $adminUserSearch): array
    {
        // We instanciate the QueryBuilder and we refers to the user entity.
        $queryBuilder = $this->createQueryBuilder('user');
        // We say that the :lastName is egual to the last name property of the user entity. 
        $queryBuilder->where('user.lastName LIKE :lastName');
        // We secure the query by setting a parameter to avoid the SQL injections. 
        $queryBuilder->setParameter(':lastName', "%$adminUserSearch%");
        // We return the result of the query. 
        return $queryBuilder->getQuery()->getResult();
    }
}
