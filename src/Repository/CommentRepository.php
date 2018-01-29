<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function findCommentsByPostId($id)
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->select('c')
            ->where('c.post = :id')
            ->setParameter('id', $id)
            ->orderBy('c.id', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }

    public function findAllComments()
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->select('c')
            ->orderBy('c.dateCreation', 'DESC')
        ;

        return $qb;
    }
}
