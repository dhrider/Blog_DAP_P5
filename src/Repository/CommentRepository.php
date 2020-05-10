<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

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
