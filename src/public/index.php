<?php
// print_r(apache_get_modules());
// echo "<pre>"; print_r($_SERVER); die;
// $_SERVER["REQUEST_URI"] = str_replace("/phalt/","/",$_SERVER["REQUEST_URI"]);
// $_GET["_url"] = "/";
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Config\ConfigFactory;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream as newstream;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

require_once(BASE_PATH . "/vendor/autoload.php");

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
    ]
);

$loader->register();

$container = new FactoryDefault();

$loader->registerNamespaces([
    'App\Components' => APP_PATH . "/components",
    'App\Listener' => APP_PATH . "/Listener",

]);


$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'config',
    function () {
        $filename = "../app/etc/Config.php";
        $load = new ConfigFactory();
        return $load->newInstance('php', $filename);
    }

);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);



$container->set(
    'logger',
    function () {
        $adapter = new newstream('../app/log/main.log');


        $logger = new Logger(
            'messages',
            [
                'main' => $adapter,
            ]
        );
        return $logger;
    }
);
$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host'     => $this->get('config')->get('host'),
                'username' => $this->get('config')->get('username'),
                'password' => $this->get('config')->get('password'),
                'dbname'   => $this->get('config')->get('dbname')
            ]
        );
    }
);

$container->set(
    "modelsManager",
    function () {
        $modelsManager = new Manager();
        return $modelsManager;
    }
);

// $container->set(
//     'mongo',
//     function () {
//         $mongo = new MongoClient();

//         return $mongo->selectDB('phalt');
//     },
//     true
// );



$eventmanager = new EventsManager();

$container->set(
    'eventmanager',
    $eventmanager
);

$eventmanager->attach(
    'notification',
    new App\Listener\Notificationlistener()
);

$eventmanager->attach(
    'application:beforeHandleRequest',
    new App\Listener\Notificationlistener()
);

$application->setEventsManager($eventmanager);
try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}
