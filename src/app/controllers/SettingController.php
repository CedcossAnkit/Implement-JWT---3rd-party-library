<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Query;
use Phalcon\Di;

class SettingController extends Controller
{
    public function settingAction()
    {
        $setting = new Setting();
        $record = $setting->find()[0];
        $arr = json_encode($record);
        $arr2 = json_decode(($arr));
        // if($record)
        // DIE($arr2);
        // die(print_r($record[0]));
        $helper = new \App\Components\Helper();

        if ($this->request->getPost()) {
            if ($helper->checkEmpty($arr2) == false) {

                $tag = $this->request->getPost("tag");
                $Dprice = $this->request->getPost("Dprice");
                $Dstock = $this->request->getPost("DStock");
                $Dzipcode = $this->request->getPost("Dzipcode");

                $arr5 = array(
                    'sid' => 5,
                    'dtag' => $tag,
                    'dprice' => $Dprice,
                    'dstock' => $Dstock,
                    'dzipcode' => $Dzipcode,


                );
                // die(print_r($arr));
                // die(print_r($arr));
                $setting->assign(
                    $arr5,
                    [
                        'sid',
                        'dtag',
                        'dprice',
                        'dstock',
                        'dzipcode'
                    ]
                );
                $ss = $setting->save();
                if ($ss) {
                    die('Setting udpaed');
                } else {
                    die('Setting Not updaed');
                }
            } else {
                $tag = $this->request->getPost("tag");
                $Dprice = $this->request->getPost("Dprice");
                $Dstock = $this->request->getPost("DStock");
                $Dzipcode = $this->request->getPost("Dzipcode");

                $arr = array(
                    'dtag' => $tag,
                    'dprice' => $Dprice,
                    'dstock' => $Dstock,
                    'dzipcode' => $Dzipcode,


                );
                // die(print_r($arr));
                $setting->assign($arr);
                $ss = $setting->save();
                if ($ss) {
                    die('Setting Recorded');
                } else {
                    die('Setting Not Recorded');
                }
            }
            // die(json_encode($record));
        }

        // return '<h1>Hello World!</h1>';
    }
}
