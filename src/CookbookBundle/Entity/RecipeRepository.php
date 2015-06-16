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

    public function findRecipesByIngredients($ingr1, $ingr2, $ingr3) {

        $qb = $this->getEntityManager()->createQueryBuilder();

        $ingredient1 = $qb->select('i')
            ->from('CookbookBundle:Ingredient', 'i')
            ->where('i.name = :ingredientName')
            ->setParameter('ingredientName', $ingr1)
            ->getQuery()
            ->getResult();

        $result = $this->createQueryBuilder('r')
            ->leftJoin('r.ingredients', 'i')
            ->where('i.id = :ingredientId1')
            ->setParameter('ingredientId1', $ingredient1->getId())
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function findRecipesWithPhoto() {
        return $this->createQueryBuilder('r')
            ->where('r.imagePath IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}
