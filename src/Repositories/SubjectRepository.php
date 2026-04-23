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

    public function create(array $data) {
        $stmt = $this->db->prepare("INSERT INTO subjects (name, code) VALUES (?, ?)");
        $stmt->execute([$data['name'], $data['code']]);
        return $this->db->lastInsertId();
    }

    public function update(array $data) {
        $stmt = $this->db->prepare("UPDATE subjects SET name = ?, code = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['code'], $data['id']]);
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
