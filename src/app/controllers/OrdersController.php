<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Di;

class OrdersController extends Controller
{

    public function orderAction()
    {
        $products = new Products();
        $record = $products->find();
        $arr = json_encode($record);
        $arr2 = json_decode($arr);

        $this->view->data = $arr2;

        $hlper = new \App\Components\Helper();
        if ($this->request->getPost()) {

            $name = $hlper->stz($this->request->getPost('name'));
            $address = $hlper->stz($this->request->getPost('address'));
            $zipcode = $hlper->stz($this->request->getPost('zipcode'));
            $pid = $hlper->stz($this->request->getPost('pid'));

            $arr = array(
                'coustomerName' => $name,
                'address' => $address,
                'zipcode' => $zipcode,
                'id' => $pid,

            );

            $eventmanager = $this->eventmanager;
            $newarr = $eventmanager->fire("notification:afterqueryOrder", $this, $arr);
            $order = new Orders();
            $order->assign($newarr);
            $suc = $order->save();
            if ($suc) {
                die("Inforamtion Saved in Order");
            } else {
                die("Inforamtion Not Saved in Order");
            }
            die(print_r($arr));
        }
    }

    public function orderlistAction()
    {
        echo "<pre>";
        // $order = new Orders();
        // $record = $order->find();
        // $arr=json_encode($record);
        // $arr2=json_decode($arr);


        $container = Di::getDefault();
        $qq = new Query("select Orders.id,Orders.coustomerName,Orders.address,Orders.zipcode,Products.Name from Orders inner join Products on Orders.id=Products.id", $container);
        $rr = $qq->execute();
        echo "<pre>";
        // die(json_encode($rr));
        $arr = json_encode($rr);
        $arr2 = json_decode($arr);
        // die(print_r($arr2));
        $this->view->data = $arr2;

        // $config= $this->config;
        // die($this->config->get('app'));
    }
}
