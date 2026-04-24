<?php
namespace Repositories;

use PDO;

class SubjectRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM subjects ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO subjects (name, code) VALUES (?, ?)");
        $name = is_object($data) ? $data->name : $data['name'];
        $code = is_object($data) ? $data->code : $data['code'];
        $stmt->execute([$name, $code]);
        return $this->db->lastInsertId();
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE subjects SET name = ?, code = ? WHERE id = ?");
        $name = is_object($data) ? $data->name : $data['name'];
        $code = is_object($data) ? $data->code : $data['code'];
        $id = is_object($data) ? $data->id : $data['id'];
        return $stmt->execute([$name, $code, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM subjects WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
