<?php

namespace App\Form\Model;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please enter an email!")
     * @Assert\Email(message="Invalid email format!")
     * @UniqueUser()
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Choose a password!")
     * @Assert\Length(min="5", minMessage="Choose a longer password!")
     */
    public $plainPassword;

    /**
     * @Assert\IsTrue(message="You must agree to the terms!")
     */
    public $agreeTerms;
}
