<?php
namespace Repositories;

use PDO;
use Models\Subject;

class SubjectRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM subjects ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function create(Subject $subject) {
        $stmt = $this->db->prepare("INSERT INTO subjects (name, code) VALUES (?, ?)");
        $stmt->execute([$subject->name, $subject->code]);
        return $this->db->lastInsertId();
    }

    public function update(Subject $subject) {
        $stmt = $this->db->prepare("UPDATE subjects SET name = ?, code = ? WHERE id = ?");
        return $stmt->execute([$subject->name, $subject->code, $subject->id]);
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
