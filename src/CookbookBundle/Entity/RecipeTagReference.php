<?php

namespace CookbookBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeTagReference
 *
 * @ORM\Table(name="recipe_tag_reference")
 * @ORM\Entity
 */
class RecipeTagReference {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="tags")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     **/
    private $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     **/
    private $tag;

    /**
     * @ORM\ManyToOne(targetEntity="Classification")
     * @ORM\JoinColumn(name="classification_id", referencedColumnName="id")
     **/
    private $classification;


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
     * Set recipe
     *
     * @param \CookbookBundle\Entity\Recipe $recipe
     * @return RecipeTagReference
     */
    public function setRecipe(\CookbookBundle\Entity\Recipe $recipe = null)
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
     * Set tag
     *
     * @param \CookbookBundle\Entity\Tag $tag
     * @return RecipeTagReference
     */
    public function setTag(\CookbookBundle\Entity\Tag $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \CookbookBundle\Entity\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set classification
     *
     * @param \CookbookBundle\Entity\Classification $classification
     * @return RecipeTagReference
     */
    public function setClassification(\CookbookBundle\Entity\Classification $classification = null)
    {
        $this->classification = $classification;
    
        return $this;
    }

    /**
     * Get classification
     *
     * @return \CookbookBundle\Entity\Classification 
     */
    public function getClassification()
    {
        return $this->classification;
    }
}
