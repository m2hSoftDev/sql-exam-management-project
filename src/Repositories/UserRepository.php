<?php
namespace Repositories;

use PDO;

class UserRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $name = is_object($data) ? $data->name : $data['name'];
        $email = is_object($data) ? $data->email : $data['email'];
        $password = is_object($data) ? $data->password : $data['password'];
        $role = is_object($data) ? $data->role : $data['role'];
        $stmt->execute([$name, $email, $password, $role]);
        return $this->db->lastInsertId();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
