<?php

namespace CookbookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeIngredientReference
 *
 * @ORM\Table(name="recipe_ingredient_reference", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class RecipeIngredientReference {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipe_ingredient_references", cascade={"all"})
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     **/
    private $recipe;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Measurement", inversedBy="recipe_ingredient_references", cascade={"all"})
     * @ORM\JoinColumn(name="measurement_id", referencedColumnName="id")
     **/
    private $measurement;

    /**
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipe_ingredient_references", cascade={"all"})
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id")
     **/
    private $ingredient;


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
     * Set amount
     *
     * @param float $amount
     * @return RecipeIngredientReference
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set recipe
     *
     * @param \CookbookBundle\Entity\Recipe $recipe
     * @return RecipeIngredientReference
     */
    public function setRecipe(Recipe $recipe = null)
    {
        $this->recipe = $recipe;
    
        return $this;
    }

    /**
     * Get recipe
     *
     * @return \CookbookBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set measurement
     *
     * @param \CookbookBundle\Entity\Measurement $measurement
     * @return RecipeIngredientReference
     */
    public function setMeasurement(Measurement $measurement = null)
    {
        $this->measurement = $measurement;
    
        return $this;
    }

    /**
     * Get measurement
     *
     * @return \CookbookBundle\Entity\Measurement 
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }

    /**
     * Set ingredient
     *
     * @param \CookbookBundle\Entity\Ingredient $ingredient
     * @return RecipeIngredientReference
     */
    public function setIngredient(Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;
    
        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \CookbookBundle\Entity\Ingredient 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
