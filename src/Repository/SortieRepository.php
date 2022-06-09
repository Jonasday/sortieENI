<?php

namespace App\Repository;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\FiltreSortieType;
use App\Form\Model\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function customQuerryUpdate()
    {
        $queryBuilder = $this->createQueryBuilder('sortie')
            ->addSelect('sortie', 'etat','participant','organisateur')
            ->join('sortie.lstParticipant', 'participant')
            ->join('sortie.organisateur', 'organisateur')
            ->innerJoin('sortie.etat','etat');

        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function filterFormCustomQuery(Search $search, $currentuser, $etatRepository): array
    {
        $queryBuilder = $this->createQueryBuilder('sortie')
        ->addSelect('participant','campus','lieu','etat', 'organisateur')
        ->join('sortie.organisateur', 'organisateur')
        ->join('sortie.lstParticipant', 'participant')
        ->join('sortie.campus', 'campus')
        ->join('sortie.lieu', 'lieu')
        ->join('sortie.etat', 'etat');

        if ($search->getCampus()){
            $queryBuilder->andWhere('sortie.campus = :campus' )
                    ->setParameter('campus', $search->getCampus());
        }

        if ($search->getMotsClef()){
            $queryBuilder->andWhere('sortie.nom LIKE :motclef' )
                ->setParameter('motclef', "%{$search->getMotsClef()}%");
        }

        if ($search->getDateMin()){
            $queryBuilder->andWhere('sortie.dateHeureDebut > :dateMin' )
                ->setParameter('dateMin', $search->getDateMin());
        }

        if ($search->getDateMax()){
            $queryBuilder->andWhere('sortie.dateHeureDebut < :dateMax' )
                ->setParameter('dateMax', $search->getDateMax());
        }

        if ($search->isSortieOrganisateur()){
            $queryBuilder->andWhere('sortie.organisateur = :user')
                ->setParameter('user', $currentuser);
        }

        if ($search->isSortieInscrit()){
            $queryBuilder->andWhere(':user MEMBER OF sortie.lstParticipant')
                ->setParameter('user', $currentuser);
        }

        if ($search->isSortiePasInscrit()){
            $queryBuilder->andWhere(':user NOT MEMBER OF sortie.lstParticipant')
                ->setParameter('user', $currentuser);
        }

        if ($search->isSortiePasse()){
            $etat = $etatRepository->findOneBy(['code' => 'AT']);
            $queryBuilder->andWhere('sortie.etat = :etat')
                ->setParameter('etat', $etat);
        }

        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

}
