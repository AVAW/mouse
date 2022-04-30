<?php

namespace App\Repository;

use App\Entity\Captcha;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\UuidV4;

/**
 * @method Captcha|null find($id, $lockMode = null, $lockVersion = null)
 * @method Captcha|null findOneBy(array $criteria, array $orderBy = null)
 * @method Captcha[]    findAll()
 * @method Captcha[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaptchaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Captcha::class);
    }

    public function findByIdentifier(UuidV4 $identifier): ?Captcha
    {
        try {
            return $this->findOneBy(['identifier' => $identifier]);
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Captcha $entity, bool $flush = true): void
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
    public function remove(Captcha $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
