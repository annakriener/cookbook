<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class Recipe {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *      message = "Title cannot be blank"
     * )
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Title cannot be longer than 100 characters"
     * )
     * @ORM\Column(name="title", type="string", length=100)
     */
    protected $title;

    /**
     * @var string
     *
     * @Assert\Length(
     *      max = 50,
     *      maxMessage = "Author cannot be longer than 50 characters"
     * )
     * @ORM\Column(name="author", type="string", length=50, nullable=true)
     */
    protected $author;

    /**
     * @var string
     *
     * @Assert\Length(
     *      max = 200,
     *      maxMessage = "Source cannot be longer than 200 characters"
     * )
     * @ORM\Column(name="source", type="string", length=200, nullable=true)
     */
    protected $source;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="recipes" )
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="RecipeTagReference", mappedBy="recipe")
     */
    protected $recipe_tag_references;

    /**
     * @Assert\Time()
     * @ORM\Column(name="duration", type="time")
     */
    protected $duration;

    /**
     * @var integer
     *
     * @Assert\Range(
     *      min = 1,
     *      max = 99,
     *      minMessage = "Recipe should make at least 1 serving",
     *      maxMessage = "Recipe cannot make more than 99 servings"
     * )
     * @ORM\Column(name="servings", type="integer")
     */
    protected $servings;

    /**
     * @ORM\OneToMany(targetEntity="RecipeIngredientReference", mappedBy="recipe")
     */
    protected $recipe_ingredient_references;

    /**
     * @ORM\Column(name="preparation", type="text", nullable=true)
     */
    protected $preparation;

    /**
     * @Assert\NotBlank(
     *      message = "Instruction cannot be blank"
     * )
     * @ORM\Column(name="instruction", type="text")
     */
    protected $instruction;

    /**
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    protected $image;


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
        $this->recipe_tag_references = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Recipe
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return Recipe
     */
    public function setSource($source)
    {
        $this->source = $source;
    
        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     * @return Recipe
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set servings
     *
     * @param integer $servings
     * @return Recipe
     */
    public function setServings($servings)
    {
        $this->servings = $servings;
    
        return $this;
    }

    /**
     * Get servings
     *
     * @return integer 
     */
    public function getServings()
    {
        return $this->servings;
    }

    /**
     * Set preparation
     *
     * @param string $preparation
     * @return Recipe
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;
    
        return $this;
    }

    /**
     * Get preparation
     *
     * @return string 
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Set instruction
     *
     * @param string $instruction
     * @return Recipe
     */
    public function setInstruction($instruction)
    {
        $this->instruction = $instruction;
    
        return $this;
    }

    /**
     * Get instruction
     *
     * @return string 
     */
    public function getInstruction()
    {
        return $this->instruction;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Recipe
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \CookbookBundle\Entity\Category $category
     * @return Recipe
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \CookbookBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add recipe_tag_references
     *
     * @param \CookbookBundle\Entity\RecipeTagReference $recipeTagReferences
     * @return Recipe
     */
    public function addRecipeTagReference(RecipeTagReference $recipeTagReferences)
    {
        $this->recipe_tag_references[] = $recipeTagReferences;
    
        return $this;
    }

    /**
     * Remove recipe_tag_references
     *
     * @param \CookbookBundle\Entity\RecipeTagReference $recipeTagReferences
     */
    public function removeRecipeTagReference(RecipeTagReference $recipeTagReferences)
    {
        $this->recipe_tag_references->removeElement($recipeTagReferences);
    }

    /**
     * Get recipe_tag_references
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipeTagReferences()
    {
        return $this->recipe_tag_references;
    }

    /**
     * Add recipe_ingredient_references
     *
     * @param \CookbookBundle\Entity\RecipeIngredientReference $recipeIngredientReferences
     * @return Recipe
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
