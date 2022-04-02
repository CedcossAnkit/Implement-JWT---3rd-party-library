<?php

use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;

class SecureController extends Controller
{
    public function indexAction()
    {
    }
    public function addroleAction()
    {
        if ($this->request->getPost()) {
            // die(print_r($this->request->getPost()));
            $helper = new \App\Components\Helper();
            // $role = $helper->stz($this->request->getPost("role"));
            // $role = new Role();
            // $arr= array('role'=>$role);
            // $role->assign($arr);
            // $suc = $role->save();

            $role = new Role();

            $role->assign(
                $this->request->getPost(),
                [
                    'role',
                ]
            );

            $success = $role->save();

            if ($success) {
                die("Role Added");
            } else {
                die("Role not added");
            }
        }
    }

    public function addcomponentAction()
    {
        if ($this->request->getPost()) {
            $con = new Component();
            // die(print_r($this->request->getPost()));
            $con->assign(
                $this->request->getPost(),
                [
                    'controller',
                    'action',

                ]
            );

            $success = $con->save();

            if ($success) {
                die("Component and action added");
            } else {
                die("Component and action are not added");
            }
        }
    }

    public function aclAction()
    {
    }

    public function buildAction()
    {
        $aclFile = APP_PATH . "/security/acl.cache";

        if (true !== is_file($aclFile)) {
            $acl = new Memory();

            $acl->addRole('admin');
        
            $acl->allow('admin', '*', '*');
            // $acl->allow('customer', '*', '*');


            file_put_contents(
                $aclFile,
                serialize($acl)
            );

            die("permission granted first time");
        } else {
            $acl = unserialize(
                file_get_contents($aclFile)
            );

            echo "<pre>";
            // die(print_r($this->request->getPost()));
            // $acl->addRole('customer');


            // $acl->allow('customer', '*', '*');


            // die("permission granted");
            // die(unserialize(readfile($aclFile)));

            $role = $this->request->getPost("role");
            $acl->addrole($role);
            // die(print_r($this->request->getPost()));
            $comArrId = $this->request->getPost("component");
            // die(print_r($comArrId));

            $b = 0;
            foreach (Component::find() as $key => $value) {

    
                    $acl->addComponent(
                        $value->controller,
                        [
                            $value->action
                        ]
                    );
                    // die(print_r(json_encode($value)));
                    $acl->allow($role, $value->controller, $value->action);
            }

            file_put_contents(
                $aclFile,
                serialize($acl)
            );
            die("access granted");
        }
    }
}
