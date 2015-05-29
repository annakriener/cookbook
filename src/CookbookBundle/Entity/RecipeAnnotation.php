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
     * @var integer
     *
     * @Assert\NotBlank(
     *      message="Recipe id cannot be blank"
     * )
     * @ORM\Column(name="recipe_id", type="integer")
     */
    protected $recipe_id;


    /**
     * @var integer
     *
     * @Assert\NotBlank(
     *      message="User id cannot be blank"
     * )
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
        return $this->recipe_id;
    }

    /**
     * @param int $recipe_id
     */
    public function setRecipeId($recipe_id)
    {
        $this->recipe_id = $recipe_id;
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
}
