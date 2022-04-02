<?php

use Phalcon\Mvc\Controller;
use Phalcon\Di;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TestController extends Controller
{
    public function indexAction()
    {
        //code
        // die("asdas");
        
        $helper = new \App\Components\Helper();
        // $arr = $helper->getControllerName();
        $token = $helper->createToken("ankit", 'admin');
        // die($token);
        $key = "example_key";
        $jwt = new JWT();
        $decoded = $jwt->decode($token, new Key($key, 'HS256'));
        $role = $decoded->role;
        echo "<pre>";
        die($role);
        // $die($arr);

    }
}
