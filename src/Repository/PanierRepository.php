<?php

namespace App\Repository;

use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Panier>
 *
 * @method Panier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panier[]    findAll()
 * @method Panier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panier::class);
    }

    /**
     * Find all panier rows for a user, eagerly loading related products.
     *
     * @param User $user
     * @return Panier[]
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.produit', 'pr')
            ->addSelect('pr')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.addedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     * @param Produit $produit
     * @return Panier|null
     */
    public function findOneByUserAndProduit(User $user, Produit $produit): ?Panier
    {
        return $this->findOneBy(['user' => $user, 'produit' => $produit]);
    }
}
