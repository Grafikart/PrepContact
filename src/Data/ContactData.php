<?php

namespace App\Data;

use Symfony\Component\Validator\Constraints as Assert;

class ContactData
{

    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=10, max=10)
     * @var string
     */
    public $phone;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min= 10)
     * @var string
     */
    public $message;

    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $rgpd;

}
