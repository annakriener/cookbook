<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipe")
 */
class Recipe {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $author;

    /**
     * @ORM\Column(type="string")
     */
    protected $source;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="recipes")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @ORM\Column(type="time")
     */
    protected $duration;

    /**
     * @ORM\Column(type="integer")
     */
    protected $servings;

    /**
     * @ORM\Column(type="text")
     */
    protected $preparation;

    /**
     * @ORM\Column(type="text")
     */
    protected $instruction;

    /**
     * @ORM\Column(type="string")
     */
    protected $image;

    // -----------------------------------
    // AUTO-GENERATED getters and setters
    // -----------------------------------
    //php app/console doctrine:generate:entities CookbookBundle

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
    public function setCategory(\CookbookBundle\Entity\Category $category = null)
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
}
