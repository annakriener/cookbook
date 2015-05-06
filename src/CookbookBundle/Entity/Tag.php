<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tag
 *
 * @ORM\Table(name="tag", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class Tag {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *      message="Tag name cannot be blank"
     * )
     * @Assert\Length(
     *      max = 30,
     *      maxMessage = "Tag name cannot be longer than 30 characters"
     * )
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="RecipeTagReference", mappedBy="tag")
     */
    private $recipe_tag_references;


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
     * @return Tag
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
     * Add recipe_tag_references
     *
     * @param \CookbookBundle\Entity\RecipeTagReference $recipeTagReferences
     * @return Tag
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
}
