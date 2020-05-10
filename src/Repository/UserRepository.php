<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail($email)
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->select('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findAllUser()
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->select('u')
            ->orderBy('u.dateCreation', 'DESC')
        ;

        return $qb;
    }
}
