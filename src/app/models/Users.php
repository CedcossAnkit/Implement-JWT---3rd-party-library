<?php

use Phalcon\Mvc\Model;

class Users extends Model
{
    public string $email;
    public string $password;
    public string $role;
    public string $token;
}
