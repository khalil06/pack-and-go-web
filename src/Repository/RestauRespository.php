<?php

namespace App\Repository;

use App\Entity\Resteau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

class RestauRespository extends  ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resteau::class);
    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Resteau $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findBynomr($nomr)
    {
        return $this->createQueryBuilder('Resteau')
            ->Where('Resteau.nomr LIKE :nomr')
            ->setParameter('nomr','%'.$nomr.'%')
            ->getQuery()
            ->getResult()
            ;
    }
}