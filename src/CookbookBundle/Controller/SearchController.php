<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 10.06.2015
 * Time: 18:49
 */

namespace CookbookBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use CookbookBundle\Form\Type\SearchType;

class SearchController extends Controller {

    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request) {

        $searchForm = $this->createForm(new SearchType());
        $recipes = null;

        if($request->isMethod('POST')) {
            $searchForm->handleRequest($request);

            if($searchForm->isValid()) {
                $data = $searchForm->getData();
                $searchTerm = $data['search'];

                $em = $this->getDoctrine()->getManager();

                $query = $em->getRepository('CookbookBundle:Recipe')
                    ->createQueryBuilder('r')
                    ->where('r.title LIKE :searchTerm')
                    ->setParameter('searchTerm', "%$searchTerm%")
                    ->getQuery();

                //var_dump($query);
                $recipes = $query->getResult();
            }
        }

        return $this->render('CookbookBundle:default:base.html.twig', array(
            'recipes' => $recipes,
            'searchForm' => $searchForm->createView()));
    }
}