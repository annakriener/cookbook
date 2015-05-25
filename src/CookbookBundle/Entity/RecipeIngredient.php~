<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeIngredientReference
 *
 * @ORM\Table(name="recipe_ingredient", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class RecipeIngredient {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Type(type="CookbookBundle\Entity\Recipe")
     *
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="ingredients", cascade={"all"})
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
     * @Assert\Type(type="CookbookBundle\Entity\Measurement")
     *
     * @ORM\ManyToOne(targetEntity="Measurement", cascade={"all"})
     * @ORM\JoinColumn(name="measurement_id", referencedColumnName="id", nullable=true)
     **/
    private $measurement;

    /**
     * @Assert\Type(type="CookbookBundle\Entity\Ingredient")
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Ingredient", cascade={"all"})
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
     * @return RecipeIngredient
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
     * @return RecipeIngredient
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
     * @return RecipeIngredient
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
     * @return RecipeIngredient
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
