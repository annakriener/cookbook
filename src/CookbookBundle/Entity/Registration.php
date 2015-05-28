<?php
/**
 * Created by PhpStorm.
 * User: Anna Kriener
 * Date: 27.05.2015
 * Time: 17:00
 */

namespace CookbookBundle\Entity;
use CookbookBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class Registration
{
    /**
     * @Assert\Type(type="CookbookBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    // Assert\NotBlank()
    // Assert\True()
    //protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    /*
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (bool)$termsAccepted;
    }
    */
}