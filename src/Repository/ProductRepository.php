<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{

    public function findByWithJoin($id):array
    {

        return $this->createQueryBuilder('p')
            ->select('p.name', 'p.description', 'p.price','cat.name as categoryName')
            ->andWhere('p.id = :id')
            ->innerJoin('p.category', 'cat')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }
//    public function findByWithJoin($id):Product
//    {
//
//
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.id = :id')
//            ->innerJoin('p.category', 'cat')
//            ->addSelect('cat')
//            ->setParameter('id', $id)
    /**
     * @param string $categoryName
     * @return Product[] Returns an array of Product objects
     */
    public function searchByCategoryName(string $categoryName):array
    {
        return $this->createQueryBuilder('p')
            ->select('p.name', 'p.description', 'p.price','cat.name as categoryName')
            ->andWhere('cat.name = :categoryName')
            ->innerJoin('p.category', 'cat')
            ->setParameter('categoryName', $categoryName)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /*
    public function findOneBySomeField($value): Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * @param $price
     * @return Product[]
     */
    public function findAllGreaterThanPrice($price): array
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.price > :price')
            ->setParameter('price', $price)
            ->orderBy('p.price', 'ASC')
            ->getQuery();

        return $qb->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }

}
