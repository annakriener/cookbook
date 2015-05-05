<?php

namespace CookbookBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Measurement
 *
 * @ORM\Table(name="measurement")
 * @ORM\Entity
 */
class Measurement {
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
     * @Assert\NotBlank(
     *      message="Measurement name cannot be blank"
     * )
     * @Assert\Length(
     *      max = 20,
     *      maxMessage = "Measurement name cannot be longer than 20 characters"
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
     * @return Measurement
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
