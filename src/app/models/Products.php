<?php

use Phalcon\Mvc\Model;

class Products extends Model
{
    public string $Name;
    public string $Description;
    public string $Tags;
    public string $Price;
    public string $Stock;
}
