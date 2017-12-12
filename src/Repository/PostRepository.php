<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function findAllPostsDescending()
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->select('p')
            ->orderBy('p.dateLastModification', 'DESC')
        ;

        return $qb;
    }
}
