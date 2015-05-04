<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category {

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
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="category")
     */
    protected $recipes;

    public function __construct() {
        $this->recipes = new ArrayCollection();
    }


    // -----------------------------------
    // AUTO-GENERATED getters and setters
    // -----------------------------------

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
