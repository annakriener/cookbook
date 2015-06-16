<?php

namespace CookbookBundle\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tag
 *
 * @ORM\Table(name="tag", options={"collate"="utf8mb4_general_ci", "charset"="utf8mb4"})
 * @ORM\Entity
 */
class Tag
{
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
     * Set name
     *
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = strtolower($name);

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
     * This will be called on newly created entities
     */
    public function prePersist(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        // we're interested in Dishes only
        if ($entity instanceof Recipe) {

            $entityManager = $args->getEntityManager();
            $recipeTags = $entity->getTags();

            foreach ($recipeTags as $key => $recipeTag) {

                // let's check for existance of this ingredient
                $tags = $entityManager->getRepository('CookbookBundle:Tag')->findBy(array('name' => $recipeTag->getTag()->getName()), array('id' => 'ASC'));

                // if ingredient exists use the existing ingredient
                if (count($tags) > 0) {
                    $entity->removeTag($recipeTag);

                    $knownTag = $tags[0];
                    $newRecipeTag = new RecipeTag();
                    $newRecipeTag->setRecipe($entity);
                    $newRecipeTag->setTag($knownTag);
                    $newRecipeTag->setClassification($recipeTag->getClassification());

                    $entity->addTag($newRecipeTag);
                } else {
                    // ingredient doesn't exist yet, add relation
                    $entity->addTag($recipeTag);
                }

            }

        }

    }


}
