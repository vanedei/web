<?php

namespace route;

use app\Controllers\AuthController;
use app\Controllers\UserController;

class Route
{

    protected $method = ''; //GET|POST|PUT|DELETE

    public $requestUri = [];
    public $requestParams = [];

    public function __construct()
    {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        //Массив GET параметров разделенных слешем
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->requestParams = $_REQUEST;

        //Определение метода запроса
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }
    }

    public function run()
    {
        //Первые 2 элемента массива URI должны быть "api" и название таблицы
        if (array_shift($this->requestUri) !== 'api') {
            throw new RuntimeException('API Not Found', 404);
        }

        $request = array_shift($this->requestUri);
        $request = explode('?', $request)[0];
//        echo "request = $request\n\n\n\n\n\n";
        switch ($request) {
            case 'users':
                $controller = new UserController($this->method, $this->requestParams);
                break;
            case 'login':
                $controller = new AuthController($this->method, $this->requestParams);
                break;
            default:
                $controller = new UserController($this->method, $this->requestParams);
        }

        //Если метод(действие) определен в дочернем классе API
        if (method_exists($controller, $controller->getAction($this->requestUri))) {
            return $controller->{$controller->getAction($this->requestUri)}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

}