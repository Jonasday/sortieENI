<?php

namespace App\Repository;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\SortieInscription;
use App\Form\FiltreSortieType;
use App\Form\Model\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

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


    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function filterFormCustomQuery(Search $search, UserInterface $user, $etatRepository): array
    {
        $queryBuilder = $this->createQueryBuilder('p');

        if ($search->getCampus()){
            $queryBuilder->andWhere('p.campus = :campus' )
                    ->setParameter('campus', $search->getCampus());
        }

        if ($search->getMotsClef()){
            $queryBuilder->andWhere('p.nom LIKE :motclef' )
                ->setParameter('motclef', "%{$search->getMotsClef()}%");
        }

        if ($search->getDateMin()){
            $queryBuilder->andWhere('p.dateHeureDebut > :dateMin' )
                ->setParameter('dateMin', $search->getDateMin());
        }

        if ($search->getDateMax()){
            $queryBuilder->andWhere('p.dateHeureDebut < :dateMax' )
                ->setParameter('dateMax', $search->getDateMax());
        }

        if ($search->isSortiePasse()){
            $etat = $etatRepository->findOneBy(['code' => 'AT']);
            $queryBuilder->andWhere('p.etat = :etat')
                ->setParameter('etat', $etat);
        }


        if ($search->isSortieOrganisateur()){
            $queryBuilder->andWhere('p.organisateur = :user')
                ->setParameter('user', $user);
        }

        if ($search->isSortieInscrit()){
            $queryBuilder->andWhere(':user MEMBER OF p.lstParticipantInscript')
                ->setParameter('user', $user);
        }

        if ($search->isSortiePasInscrit()){
            $queryBuilder->andWhere(':user NOT MEMBER OF p.lstParticipantInscript')
                ->setParameter('user', $user);
        }

        if ($search->isSortiePasse()){
            $etat = $etatRepository->findOneBy(['code' => 'AT']);
            $queryBuilder->andWhere('p.etat = :etat')
                ->setParameter('etat', $etat);
        }


        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }
}
