<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 10.06.2015
 * Time: 18:49
 */

namespace CookbookBundle\Controller;


use CookbookBundle\Form\Type\SearchRefineType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CookbookBundle\Form\Type\SearchType;

class SearchController extends Controller
{

    /**
     * @Route("/search/results", name="search")
     */
    public function searchAction(Request $request)
    {
        $searchForm = $this->createForm(new SearchType(), null, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));
        $searchRefineForm = $this->createForm(new SearchRefineType(), null, array(
            'action' => $this->generateUrl('search'),
            'method' => 'POST'
        ));

        $recipes = null;

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();

            if ($request->request->has('search')) {
                $searchForm->handleRequest($request);

                if ($searchForm->isValid()) {
                    $data = $searchForm->getData();
                    $searchTitle = $data['search'];
                    $recipes = $this->queryRecipesByTitle($em, $searchTitle);
                }
            }

            if ($request->request->has('search_refine')) {
                $searchRefineForm->handleRequest($request);

                if ($searchRefineForm->isValid()) {
                    $data = $searchRefineForm->getData();

                    $searchTitle = $data['title'];
                    $searchCategory = $data['category'];
                    $searchIngr1 = $data['ingredient1'];
                    $searchIngr2 = $data['ingredient2'];
                    $searchIngr3 = $data['ingredient3'];
                    $searchTag1 = $data['tag1'];
                    $searchTag2 = $data['tag2'];
                    $searchTag3 = $data['tag3'];
                    $searchDietary = $data['dietary'];
                    $searchWithPhoto = $data['image'];

                    $searchIngredientNames = array($searchIngr1, $searchIngr2, $searchIngr3);
                    $searchTagNames = array($searchTag1, $searchTag2, $searchTag3);
                    $recipes = $this->queryRecipes($em, $searchTitle, $searchCategory, $searchIngredientNames, $searchTagNames, $searchDietary, $searchWithPhoto);
                }
            }
        }

        return $this->render('CookbookBundle:search:results.html.twig', array(
            'recipes' => $recipes,
            'searchForm' => $searchForm->createView(),
            'searchRefineForm' => $searchRefineForm->createView(),
        ));
    }

    private function queryRecipesByTitle($em, $searchTerm)
    {
        $recipes = $em->getRepository('CookbookBundle:Recipe')->findRecipesByTitle($searchTerm);
        return $recipes;
    }

    private function queryRecipes($em, $title, $category, $ingredientNames, $tagNames, $dietaryRecipeTags, $withPhoto)
    {
        return $em->getRepository('CookbookBundle:Recipe')->findRecipes($title, $category, $ingredientNames, $tagNames, $dietaryRecipeTags, $withPhoto);
    }

}