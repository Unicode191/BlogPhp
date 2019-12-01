<?php
namespace application\core;

use application\core\View;

class Router {
    protected $routes = [];
    protected $params = [];

    public function __construct() {
        $arr = require 'application/config/routes.php';
        //debug($arr);
        foreach ($arr as $key => $val)
            $this->add($key, $val);
    }

    public function add($route, $params) {
        //echo '<p>' . $route . '</p>';
        //var_dump($params);
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    public function match() {
        $url = trim($_SERVER['REQUEST_URI'], '/');  //Удаляет /
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {   //ищет совпядения
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run() {
        if ($this->match()) {
            $path = 'application\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params);
                    $controller->$action();
                } else {
                    View::errorCode(404);
                }
            } else {
                View::errorCode(404);
            }
//            echo '<p>controller: <b>'. $this->params['controller']. '</b></p>';
//            echo '<p>action: <b>'. $this->params['action']. '</b></p>';
        } else {
            View::errorCode(500);
        }
    }
}