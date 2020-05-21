<?php

namespace SecureNative\sdk;

class UserTraits
{
    public $name;
    public $email;
    public $createdAt;

    public function __construct($name = null, $email = null, $createdAt = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
    }
}