<?php

namespace App\Repository;

use App\Entity\Vessel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

include __DIR__ . '/../../outils/VesselFinderApi.php';
use API\VesselFinderApi;

/**
 * @extends ServiceEntityRepository<Vessel>
 *
 * @method Vessel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vessel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vessel[]    findAll()
 * @method Vessel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VesselRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vessel::class);
    }

    public static function callVesselFinderAPI() : array {
        $client = new VesselFinderApi('daa665c3f0660bc4343348f076b3da21');
        try {
            $vessels = $client->vessels([9228801,9441271], 227441980);
            //print_r($vessels);
        } catch (\Exceptions\ApiErrorException $e) {
            print_r($e->getMessage() . PHP_EOL);
        }
        return $vessels;
    }
    
    public function save(Vessel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vessel $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    
    

//    /**
//     * @return Vessel[] Returns an array of Vessel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vessel
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
