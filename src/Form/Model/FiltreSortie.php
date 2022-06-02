<?php

namespace App\Form\Model;

use App\Form\FiltreSortieType;
use App\Repository\SortieRepository;

class FiltreSortie
{
    private SortieRepository $sortieRepository;

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
        public function filtreSortie(FiltreSortieType $filtreSortieType): void
        {

    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

        }
}