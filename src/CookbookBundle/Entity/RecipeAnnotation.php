<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeAnnotation
 *
 * @ORM\Table(name="recipe_annotations", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class RecipeAnnotation {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    /**
     *
     * @ORM\ManyToOne(targetEntity="Recipe", cascade={"persist"})
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     **/
    protected $recipe;


    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $user_id;


    /**
     * @var Array
     *
     * @ORM\Column(name="instructions", type="json_array")
     */
    protected $instructions;

    /**
     * @var Array
     *
     * @ORM\Column(name="ingredients", type="json_array")
     */
    protected $ingredients;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hide_crossed", type="boolean")
     */
    protected $hide_crossed;

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
        $this->instructions = array();
        $this->ingredients = array();
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
     * @return int
     */
    public function getRecipeId()
    {
        return $this->recipe;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }



    /**
     * @param int $recipe
     */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Set instructions
     *
     * @param array $instructions
     * @return RecipeAnnotation
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get instructions
     *
     * @return array
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Get ingredients
     *
     * @return array
     */
    public function getIngredients() {
        return $this->ingredients;
    }

    /**
     * Set ingredients
     *
     * @param array $ingredients
     * @return RecipeAnnotation
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHideCrossed()
    {
        return $this->hide_crossed;
    }

    /**
     * @param boolean $hide_crossed
     */
    public function setHideCrossed($hide_crossed)
    {
        $this->hide_crossed = $hide_crossed;
    }


}
