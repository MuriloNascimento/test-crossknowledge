<?php
/**
 * Created by PhpStorm.
 * User: murilo
 * Date: 28/11/16
 * Time: 23:08
 */

namespace App;


class Conn
{
    public static function getDb()
    {
        return new \PDO("mysql:host=localhost;dbname=project;charset=utf8", "root", "niane", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
}