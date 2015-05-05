<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classification
 *
 * @ORM\Table(name="classification")
 * @ORM\Entity
 */
class Classification {
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
     *      message="Classification name cannot be blank"
     * )
     * @Assert\Length(
     *      max = 20,
     *      maxMessage = "Classification name cannot be longer than 20 characters"
     * )
     * @ORM\Column(name="name", type="string", length=20)
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
     * @return Classification
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
}
