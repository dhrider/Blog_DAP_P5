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

    public function findAllNonValidateComments()
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->select('c')
            ->where('c.validate = :valid')
            ->setParameter('valid', 0)
            ->orderBy('c.dateCreation', 'DESC')
        ;

        return $qb;
    }
}
