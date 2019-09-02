<?php

namespace SecureNative\sdk;

class User
{
    public $id;
    public $name;
    public $email;

    public function __construct($id, $name = null, $email = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }
}