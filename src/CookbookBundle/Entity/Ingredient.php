<?php

namespace CookbookBundle\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class Ingredient
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(
     *      message="Ingredient name cannot be blank"
     * )
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Ingredient name cannot be longer than 30 characters"
     * )
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /*
     * -------------------
     * AUTO-GENERATED CODE
     * -------------------
     */


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Ingredient
     */
    public function setName($name)
    {
        $this->name = strtolower($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * This will be called on newly created entities
     */
    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        // we're interested in Dishes only
        if ($entity instanceof Recipe) {

            $entityManager = $args->getEntityManager();
            $recipeIngredients = $entity->getIngredients();

            foreach ($recipeIngredients as $key => $recipeIngredient) {

                // let's check for existance of this ingredient
                $ingredients = $entityManager->getRepository('CookbookBundle:Ingredient')->findBy(array('name' => $recipeIngredient->getIngredient()->getName()), array('id' => 'ASC'));

                // if ingredient exists use the existing ingredient
                if (count($ingredients) > 0) {
                    $entity->removeIngredient($recipeIngredient);

                    $knownIngredient = $ingredients[0];
                    $newRecipeIngredient = new RecipeIngredient();
                    $newRecipeIngredient->setRecipe($entity);
                    $newRecipeIngredient->setMeasurement($recipeIngredient->getMeasurement());
                    $newRecipeIngredient->setIngredient($knownIngredient);
                    $newRecipeIngredient->setAmount($recipeIngredient->getAmount());

                    $entity->addIngredient($newRecipeIngredient);
                } else {
                    // ingredient doesn't exist yet, add relation
                    $entity->addIngredient($recipeIngredient);
                }

            }

        }

    }
}
