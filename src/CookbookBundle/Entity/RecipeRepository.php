<?php

namespace CookbookBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RecipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipeRepository extends EntityRepository
{

    public function findAllOrderedByTitle()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r FROM CookbookBundle:Recipe r ORDER BY r.title ASC'
            )
            ->getResult();
    }

    public function findRecipesByTitle($recipeTitle) {
        return  $this->createQueryBuilder('r')
            ->where('r.title LIKE :searchTerm')
            ->setParameter('searchTerm', "%$recipeTitle%")
            ->getQuery()
            ->getResult();
    }

    public function findRecipesByCategory($categoryName)
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.category', 'c')
            ->where('c.name LIKE :categoryName')
            ->setParameter('categoryName', $categoryName)
            ->getQuery()
            ->getResult();
    }

    public function findRecipesWithPhoto() {
        return $this->createQueryBuilder('r')
            ->where('r.imagePath IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}
