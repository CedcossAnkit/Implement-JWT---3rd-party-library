<?php

use Phalcon\Mvc\Controller;

class SignupController extends Controller
{

    public function IndexAction()
    {
    }

    public function signupAction()
    {
        if ($this->request->getPost()) {
            // die(print_r($this->request->getPost()));

            $helper = new \App\Components\Helper();
            $email =     $helper->stz($this->request->getPost("email"));
            $password =  $helper->stz($this->request->getPost("password"));
            $cpassword = $helper->stz($this->request->getPost("cpassword"));
            $role = $helper->stz($this->request->getPost("role"));
            $token = $helper->createToken($role, $email);

            if ($password == $cpassword) {

                $arr = array(
                    'email' => $email,
                    'password' => $password,
                    'role' => $role,
                    'token' => $token
                );

                $users = new Users();
                $users->assign($arr);
                $suc = $users->save();
                if ($suc) {
                    die("Account Created");
                } else {
                    die("Something Went Wrong!");
                }
            } else {
                die("Password Does Not Match");
            }
        }
    }

    public function registerAction()
    {
        $user = new Users();

        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        $success = $user->save();

        $this->view->success = $success;

        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register succesfully due to following reason: <br>" . implode("<br>", $user->getMessages());
        }
    }
}
