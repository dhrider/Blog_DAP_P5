<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
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
