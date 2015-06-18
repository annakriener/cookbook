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

    public function findDefaultRecipes()
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.category', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findRecipesByCategory($categoryName, $limit) {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.category','c')
            ->where('c.name = :categoryName')
            ->setParameter('categoryName', $categoryName)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findRecipesByTitle($recipeTitle)
    {
        $splitPattern = '/[;, ]/';
        $searchTerms = preg_split($splitPattern, $recipeTitle);

        $qb = $this->createQueryBuilder('r');

        foreach ($searchTerms as $key => $searchTerm) {
            $qb->andWhere('r.title LIKE :searchTerm' . $key)
                ->setParameter('searchTerm' . $key, "%$searchTerm%");
        }

        $result = $qb->getQuery()
            ->getResult();

        return $result;
    }

    public function findRecipes($title, $category, $ingredientNames, $tagNames, $dietaryRecipeTags, $withPhoto)
    {
        $splitPattern = '/[;, ]/';
        $searchTerms = preg_split($splitPattern, $title);

        $ingredients = array();
        $tags = array();
        $dietaryTagNames = array();

        foreach ($ingredientNames as $ingredientName) {
            if (!empty($ingredientName)) {
                $foundIngredients = $this->findIngredientByName($ingredientName);
                foreach ($foundIngredients as $foundIngredient) {
                    $ingredients[] = $foundIngredient;
                }
            }
        }

        foreach ($tagNames as $tagName) {
            if (!empty($tagName)) {
                $foundTags = $this->findTagByName($tagName);
                foreach ($foundTags as $foundTag) {
                    $tags[] = $foundTag;
                }
            }
        }

        foreach ($dietaryRecipeTags as $dietaryRecipeTag) {
            if (!empty($dietaryRecipeTag)) {
                $foundTags = $this->findTagByName($dietaryRecipeTag->getTag()->getName());
                foreach ($foundTags as $foundTag) {
                    $dietaryTagNames[] = $foundTag->getName();
                }
            }
        }

        $qb = $this->createQueryBuilder('r');

        if (count($searchTerms) > 0) {
            foreach ($searchTerms as $key => $searchTerm) {
                $qb->andWhere('r.title LIKE :searchTerm' . $key)
                    ->setParameter('searchTerm' . $key, "%$searchTerm%");
            }
        }

        if ($category) {
            $categoryName = $category->getName();
            $qb->leftJoin('r.category', 'c')
                ->andWhere('c.name LIKE :categoryName')
                ->setParameter('categoryName', $categoryName);
        }

        if (count($ingredients) > 0) {
            $qb->leftJoin('r.ingredients', 'ri')
                ->andWhere('ri.ingredient IN (:ingredients)')
                ->setParameter('ingredients', $ingredients);
        }

        if (count($dietaryTagNames) > 0) {
            $dietaryRecipes = $this->createQueryBuilder('r')
                ->leftJoin('r.tags', 'rt')
                ->leftJoin('rt.classification', 'c')
                ->where('c.name = :dietary')
                ->setParameter('dietary', 'dietary')
                ->getQuery()
                ->getResult();

            $recipeIDs = array();

            foreach ($dietaryRecipes as $key => $dietaryRecipe) {
                $dietaryRecipeTagNames = array();
                $recipeTags = $dietaryRecipe->getTags();

                foreach ($recipeTags as $recipeTag) {
                    $dietaryRecipeTagNames[] = $recipeTag->getTag()->getName();
                }
                $diff = array_diff($dietaryTagNames, $dietaryRecipeTagNames);
                if (count($diff) === 0) {
                    $recipeIDs[] = $dietaryRecipe->getId();
                }
            }

            $qb->andWhere('r.id IN (:recipeIDs)')
                ->setParameter('recipeIDs', $recipeIDs);
        }

        if (count($tags) > 0) {
            $qb->leftJoin('r.tags', 'rt')
                ->andWhere('rt.tag IN (:tags)')
                ->setParameter('tags', $tags);
        }

        if ($withPhoto) {
            $qb->andWhere('r.imagePath IS NOT NULL');
        }


        $results = $qb->getQuery()
            ->getResult();

        return $results;
    }

    private function findIngredientByName($ingredientName)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('i')
            ->from('CookbookBundle:Ingredient', 'i')
            ->where('i.name LIKE :ingredientName')
            ->setParameter('ingredientName', "%$ingredientName%")
            ->getQuery()
            ->getResult();
    }

    private function findTagByName($tagName)
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->select('t')
            ->from('CookbookBundle:Tag', 't')
            ->where('t.name LIKE :tagName')
            ->setParameter('tagName', "%$tagName%")
            ->getQuery()
            ->getResult();
    }
}
