<?php

namespace App;

class Route
{
    private $route;

    public function __construct()
    {
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    public function initRoutes()
    {
        $routes['index'] = array(
            "method"=>"get","route"=>'/',"controller"=>"indexController","action"=>"index"
        );
        $routes['list'] = array(
            "method"=>"get","route"=>'/users',"controller"=>"userController","action"=>"list"
        );
        $routes['create'] = array(
            "method"=>"post","route"=>'/users/create',"controller"=>"userController","action"=>"create"
        );
        $routes['find'] = array(
            "method"=>"get","route"=>'/users/find',"controller"=>"userController","action"=>"find"
        );
        $routes['update'] = array(
            "method"=>"put","route"=>'/users/update',"controller"=>"userController","action"=>"update"
        );
        $routes['remove'] = array(
            "method"=>"delete","route"=>'/users/remove',"controller"=>"userController","action"=>"remove"
        );
        $this->setRoute($routes);
    }

    public function run($url)
    {
        array_walk($this->route,function($route)use($url){
            if($url == $route['route']){
                $class = "App\\Controllers\\".ucfirst($route['controller']);
                $controller = new $class;
                $action = $route['action'];
                $method = $route['method'];
                if ($method != "get"){
                    $input = file_get_contents('php://input');
                    $request = json_decode($input);
                    $controller->$action($request);
                } else {
                    $controller->$action($_REQUEST);
                }
            }
        });
    }

    public function setRoute(array $routes)
    {
        $this->route = $routes;
    }

    public function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    }
}