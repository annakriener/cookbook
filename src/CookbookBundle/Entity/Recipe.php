<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity(repositoryClass="CookbookBundle\Entity\RecipeRepository")
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
     *
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
     *
     * @ORM\Column(name="source", type="string", length=200, nullable=true)
     */
    protected $source;

    /**
     * @var \CookbookBundle\Entity\Category
     *
     * @Assert\Type(type="CookbookBundle\Entity\Category")
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="recipes", cascade={"persist"} )
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="RecipeTag", mappedBy="recipe", cascade={"persist"} )
     */
    protected $tags;

    /**
     * @Assert\Time()
     *
     * @ORM\Column(name="duration", type="time")
     */
    protected $duration;

    /**
     * @var integer
     *
     * @Assert\NotBlank(
     *      message = "Servings cannot be blank"
     * )
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one ingredient",
     * )
     *
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="recipe", cascade={"persist"})
     */
    protected $ingredients;

    /**
     * @ORM\Column(name="preparation", type="text", nullable=true)
     */
    protected $preparation;

    /**
     * @var Array
     *
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "You must specify at least one step",
     * )
     *
     * @ORM\Column(name="instructions", type="json_array")
     */
    protected $instructions;

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
        $this->tags = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->instructions = array();
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
     * Set instructions
     *
     * @param array $instructions
     * @return Recipe
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
     * Add instruction
     *
     * @param $instruction
     * @return Recipe
     */
    public function addInstruction($instruction) {
        $step = array();
        $paragraphs = preg_split("/\R/", $instruction);

        foreach ($paragraphs as $paragraph) {
            $parts = preg_split("/TIMER/", $paragraph);

            $children = array();

            foreach ($parts as $part) {
                if (preg_match("/(2[0-3]|[01][0-9]):[0-5][0-9]:[0-5][0-9]/", $part)) {
                    $time = preg_split("/:/", $part);
                    $children[] = array("type" => 4, "h" => intval($time[0]), "m" => intval($time[1]), "s" => intval($time[2]));
                    //$step[] = array("type" => 4, "h" => $time[0], "m" => $time[1], "s" => $time[2]);
                } else {
                    $children[] = array("type" => 1, "txt" => $part);
                    //$step[] = array("type" => 1, "txt" => $part);
                }
            }

            //$step[] = array('type' => 5, 'children' => $children);
            $step[] = $children;
        }

        $this->instructions[] = json_decode(json_encode($step));
        return $this;
    }

    /**
     * Remove tags
     *
     * @param $instruction
     */
    public function removeInstruction($instruction) {
        if (in_array($instruction, $this->instructions)) {
            unset($this->instructions[array_search($instruction, $this->instructions)]);
        }
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
     * Add tag
     *
     * @param \CookbookBundle\Entity\RecipeTag $tag
     * @return Recipe
     */
    public function addTag(RecipeTag $tag) {
        $this->tags[] = $tag;
        $tag->setRecipe($this);
        return $this;
    }

    /**
     * Remove tag
     *
     * @param \CookbookBundle\Entity\RecipeTag $tag
     */
    public function removeTag(RecipeTag $tag) {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags() {
        return $this->tags;
    }

    /**
     * Add ingredient
     *
     * @param \CookbookBundle\Entity\RecipeIngredient $ingredient
     * @return Recipe
     */
    public function addIngredient(RecipeIngredient $ingredient) {
        $this->ingredients[] = $ingredient;
        $ingredient->setRecipe($this);
        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \CookbookBundle\Entity\RecipeIngredient $ingredient
     */
    public function removeIngredient(RecipeIngredient $ingredient) {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredients() {
        return $this->ingredients;
    }
}
