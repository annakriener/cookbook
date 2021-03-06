<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeTagReference
 *
 * @ORM\Table(name="recipe_tag", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class RecipeTag {
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
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="tags", cascade={"persist"})
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     **/
    private $recipe;

    /**
     * @Assert\Type(type="CookbookBundle\Entity\Tag")
     *
     * @ORM\ManyToOne(targetEntity="Tag", cascade={"persist"})
     * @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     **/
    private $tag;

    /**
     * @Assert\Type(type="CookbookBundle\Entity\Classification")
     *
     * @ORM\ManyToOne(targetEntity="Classification", cascade={"persist"})
     * @ORM\JoinColumn(name="classification_id", referencedColumnName="id", nullable=true)
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
     * @return RecipeTag
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
     * Set tag
     *
     * @param \CookbookBundle\Entity\Tag $tag
     * @return RecipeTag
     */
    public function setTag(Tag $tag = null)
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
     * @return RecipeTag
     */
    public function setClassification(Classification $classification = null)
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
