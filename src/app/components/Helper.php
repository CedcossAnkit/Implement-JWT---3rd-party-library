<?php

namespace App\Components;

use Phalcon\Escaper;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class Helper
{

    public function stz($data)
    {
        $escaper = new Escaper();
        return $escaper->escapeHtml($data);
    }

    public function checkEmpty($arr2)
    {
        $b = 0;
        foreach ($arr2 as $key => $value) {
            $b = $b + 1;
        }
        if ($b > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getControllerName()
    {
        $foldername = APP_PATH . "/controllers/";
        $dir = opendir($foldername);
        $file = scandir($foldername);
        // echo "<pre>";
        // var_dump($file);
        closedir($dir);

        // print_r($file);

        $arr = array();

        foreach ($file as $key => $value) {
            $b = "";
            if ($value != "." and $value != "..") {
                $index = strpos($value, "Controller.php");
                // echo $index . "<br>";
                for ($i = 0; $i < $index; $i++) {
                    $b = $b . $value[$i];
                }
                // echo $b;
                array_push($arr, $b);
            }
        }

        return $arr;
    }

    public function createToken($email, $role)
    {

        $key = "example_key";
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            'email' => $email,
            'role' => $role
        );

        $jwt = new JWT();

        $encryptedKey = $jwt->encode($payload, $key, 'HS256');
        return $encryptedKey;


        // $signer = new Hmac();
        // $builder = new Builder($signer);


        // $now = new \DateTimeImmutable();
        // $issued     = $now->getTimestamp();
        // $notBefore  = $now->modify('-1 minute')->getTimestamp();
        // $expires    = $now->modify('+1 day')->getTimestamp();
        // $passphrase = 'QcMpZ&b&mo3TPsPk668J6QH8JA$&U&m2';

        // $builder->setAudience('https://target.phalcon.io');
        // $builder->setContentType('application/json');
        // $builder->setExpirationTime($expires);
        // $builder->setId('abcd123456789');
        // $builder->setIssuedAt($issued);
        // $builder->setIssuer('https://phalcon.io');
        // $builder->setNotBefore($notBefore);
        // $builder->setSubject($subject);
        // $builder->setPassphrase($passphrase);

        // $Tokenobj = $builder->getToken();

        // return $Tokenobj->getToken();

    }
}
