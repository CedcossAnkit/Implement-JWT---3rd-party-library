<?php

use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{
    public function indexAction()
    {
        $this->response->redirect('http://localhost:8080/products/products');
    }
    public function productsAction()
    {
        // echo "hello world";
        if ($this->request->getPost('action') == 'add') {
            // die(print_r($this->request->getPost()));
            $helper = new App\Components\Helper();

            $name = $helper->stz($this->request->getPost("Name"));
            $desc = $helper->stz($this->request->getPost("Desc"));
            $tag = $helper->stz($this->request->getPost("Tags"));
            $price = $helper->stz($this->request->getPost("Price"));
            $stock = $helper->stz($this->request->getPost("Stock"));
            // die($name);
            $arr = array(
                'Name' => $name,
                'Description' => $desc,
                'Tags' => $tag,
                'Price' => $price,
                'Stock' => $stock,

            );

            // die(print_r($arr));
            $eventManager = $this->eventmanager;
            $arrNew= $eventManager->fire('notification:afterquery', $this, $arr);

            // die(print_r($arrNew));
            $pro = new Products();
            $pro->assign(
                $arrNew
            );
            $suc = $pro->save();
            if ($suc) {
                $this->logger->error("$name product added");
                // $this->di->get('logger')->error("some thing went wrong");
                die("Product Inforamtion Saved");
            } else {
                die("Product Inforamtion Not saved");
            }
        }
    }

    public function productlistAction()
    {
        // die("hwllo world");
        $products = new Products();
        $record = $products->find();
        $arr=json_encode($record);
        $arr2=json_decode($arr);
        echo "<pre>";
        // die(print_r($arr2));
        $this->view->arr2 = $arr2;
    }
}
