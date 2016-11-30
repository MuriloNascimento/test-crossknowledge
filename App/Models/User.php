<?php
/**
 * Created by PhpStorm.
 * User: murilo
 * Date: 28/11/16
 * Time: 23:15
 */

namespace App\Models;


class User
{
    protected $db;


    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $query = "select * from user order by user_id DESC";
        return $this->db->query($query)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $query = "select * from user WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(':id' => $id));
        return $stmt->fetchObject();
    }

    public function create($user)
    {
        $query = "INSERT INTO user (first_name, last_name, address) VALUES (:first_name, :last_name, :address)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(':first_name' => $user->first_name, ':last_name' => $user->last_name, ':address' => $user->address));
        return $this->db->lastInsertId();
    }

    public function update($user)
    {
        $query = "UPDATE user SET first_name = :first_name, last_name = :last_name, address = :address WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(':id' => $user->user_id, ':first_name' => $user->first_name, ':last_name' => $user->last_name, ':address' => $user->address));
        return $stmt->fetchObject();
    }

    public function remove($user)
    {
        $query = "DELETE FROM user WHERE user_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(':id' => $user->user_id));
        return $stmt->fetchObject();
    }

}