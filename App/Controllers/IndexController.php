<?php
/**
 * Created by PhpStorm.
 * User: murilo
 * Date: 28/11/16
 * Time: 21:52
 */

namespace App\Controllers;


class IndexController
{
    private $views;

    public function __construct()
    {
        $this->views = new \stdClass;
    }

    public function index()
    {
        $this->render('index');
    }

    public function render($action)
    {
        $current = get_class($this);
        $singleClassName = strtolower(str_replace("Controller","",str_replace("App\\Controllers\\","",$current)));
        include_once "../App/Views/".$singleClassName."/".$action.".phtml";
    }
}