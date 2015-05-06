<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ingredient
 *
 * @ORM\Table(name="ingredient", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class Ingredient {
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

    /**
     * @ORM\OneToMany(targetEntity="RecipeIngredientReference", mappedBy="ingredient")
     */
    private $recipe_ingredient_references;


    /*
     * -------------------
     * AUTO-GENERATED CODE
     * -------------------
     */

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipe_ingredient_references = new ArrayCollection();
    }

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
        $this->name = $name;
    
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
     * Add recipe_ingredient_references
     *
     * @param \CookbookBundle\Entity\RecipeIngredientReference $recipeIngredientReferences
     * @return Ingredient
     */
    public function addRecipeIngredientReference(RecipeIngredientReference $recipeIngredientReferences)
    {
        $this->recipe_ingredient_references[] = $recipeIngredientReferences;
    
        return $this;
    }

    /**
     * Remove recipe_ingredient_references
     *
     * @param \CookbookBundle\Entity\RecipeIngredientReference $recipeIngredientReferences
     */
    public function removeRecipeIngredientReference(RecipeIngredientReference $recipeIngredientReferences)
    {
        $this->recipe_ingredient_references->removeElement($recipeIngredientReferences);
    }

    /**
     * Get recipe_ingredient_references
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipeIngredientReferences()
    {
        return $this->recipe_ingredient_references;
    }
}
