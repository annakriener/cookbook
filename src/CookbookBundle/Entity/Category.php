<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category {

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
     *      message="Category name cannot be blank"
     * )
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Category name cannot be longer than 30 characters"
     * )
     * @ORM\Column(name="name", type="string", length=30)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="category")
     */
    protected $recipes;


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
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Category
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
     * Add recipes
     *
     * @param \CookbookBundle\Entity\Recipe $recipes
     * @return Category
     */
    public function addRecipe(\CookbookBundle\Entity\Recipe $recipes)
    {
        $this->recipes[] = $recipes;
    
        return $this;
    }

    /**
     * Remove recipes
     *
     * @param \CookbookBundle\Entity\Recipe $recipes
     */
    public function removeRecipe(\CookbookBundle\Entity\Recipe $recipes)
    {
        $this->recipes->removeElement($recipes);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}
