<?php

namespace MartenaSoft\Warehouse\Repository;

use MartenaSoft\Warehouse\Entity\Shelving;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShelvingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shelving::class);
    }
}
