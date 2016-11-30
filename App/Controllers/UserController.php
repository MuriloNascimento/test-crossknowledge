<?php
/**
 * Created by PhpStorm.
 * User: murilo
 * Date: 28/11/16
 * Time: 21:52
 */

namespace App\Controllers;


use App\Conn;
use App\Models\User;

class UserController
{
    private $views;

    public function __construct()
    {
        $this->views = new \stdClass;
    }

    public function list($request)
    {
        $user = new User(Conn::getDb());
        $this->views->users = $user->all();
        echo json_encode($this->views->users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function create($request)
    {
        $user = new User(Conn::getDb());
        $this->views->users = $user->create($request);
        $request->user_id = $this->views->users;
        echo json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function update($request)
    {
        $user = new User(Conn::getDb());
        $user->update($request);
        echo json_encode($request, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function find($request)
    {
        $user = new User(Conn::getDb());
        echo json_encode($user->find($request['id']), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function remove($request)
    {
        $user = new User(Conn::getDb());
        echo json_encode($user->remove($request), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function render($action)
    {
        $current = get_class($this);
        $singleClassName = strtolower(str_replace("Controller","",str_replace("App\\Controllers\\","",$current)));
        include_once "../App/Views/".$singleClassName."/".$action.".phtml";
    }
}