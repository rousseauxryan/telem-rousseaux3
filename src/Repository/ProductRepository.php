<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{


    /**
     * @var QueryBuilder $qb queryBuilder utilisé dans les différentes méthodes
     */
    private QueryBuilder $qb;

    /**
     * @var string $alias l'entité manipulée
     */
    private string $alias = 'pdt';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }



//**********************************************************
//region *H1* Méthodes retournant un QueryBuilder
//**********************************************************

    //----------------------------------------------------------
    //region *H2* Initialisation du QueryBuilder
    //----------------------------------------------------------


    /**
     * Initialisation du QueryBuilder courant de la variable qb
     *
     * @return QueryBuilder
     */
    private function initializeQueryBuilder(): void{

        $this->qb = $this->createQueryBuilder($this->alias)
            ->select($this->alias);
    }


    //----------------------------------------------------------
    //endregion *H2* Filtres
    //----------------------------------------------------------






    //----------------------------------------------------------
    //region *H3* Filtres
    //----------------------------------------------------------

    /**
     * Recherche le mot clé passé en argument dans la propriété Name
     * @param string $keyword
     * @return QueryBuilder
     */
    private function orNameLike(string $keyword): void{

        $this->qb->orWhere("$this->alias.name LIKE :name")
            ->setParameter('name','%'.$keyword.'%');
    }

    /**
     * Recherche le mot clé passé en argument dans la propriété Name
     * @param string $keyword
     * @return QueryBuilder
     */
    private function orDescriptionLike(string $keyword): void{

        $this->qb->orWhere("$this->alias.description LIKE :description")
            ->setParameter('description','%'.$keyword.'%');
    }


    /**
     * Filtre sur une propriété avec l'opérateur LIKE à partir de la chaine passée en argument
     *
     * @param string $propertyName
     * @param string $keyword
     * @return void
     */
    private function orPropertyLike(string $propertyName, string $keyword): void{

        $this->qb->orWhere("$this->alias.$propertyName LIKE :$propertyName")
            ->setParameter($propertyName,'%'.$keyword.'%');
    }


    //----------------------------------------------------------
    //endregion *H3*
    //----------------------------------------------------------

//**********************************************************
//endregion *H1*
//**********************************************************


    public function search(string $keyword): array{

        $this->initializeQueryBuilder();

        //on recherche dans le nom
        //$this->orNameLike($keyword);

        //on recherche dans la description
        //$this->orDescriptionLike($keyword);

        //on recherche dans les propriétés
        $this->orPropertyLike('name', $keyword);
        $this->orPropertyLike('description', $keyword);
        $this->orPropertyLike('price', $keyword);

        return $this->qb->getQuery()->getResult();

    }























    public function searchWithSql(string $keyword) : array {
        $connection = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM product p WHERE p.name LIKE :name';

        $statement = $connection->prepare($sql);

        $result = $statement->executeQuery(['name'=>'%'.$keyword.'%']);

        return $result->fetchAllAssociative();

    }

    public function searchWithDQL(string $keyword) : array{

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                '
                SELECT p
                FROM App\Entity\Product p
                WHERE p.name LIKE :name
                '
            )->setParameter('name','%'.$keyword.'%');

        return $query->execute();

    }

    public function searchWithQB(string $keyword) : array{

        $this->qb = $this->createQueryBuilder('p')
            ->where('p.name LIKE :name')
            ->setParameter('name','%'.$keyword.'%');

        $this->filterDescription($keyword);
        return $this->qb->getQuery()->getResult();

    }

    public function filterDescription(string $keyword){
        $this->qb->orWhere('p.description LIKE :name')
        ->setParameter('name', '%'.$keyword.'%');
        return $this->qb;
    }

}