<?php
namespace Repositories;

use PDO;
use Models\Result;

class ResultRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(Result $result) {
        $sql = "INSERT INTO results (user_id, exam_id, score, total_possible_marks) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $result->user_id,
            $result->exam_id,
            $result->score,
            $result->total_possible_marks
        ]);
        return $this->db->lastInsertId();
    }

    public function getByUser($user_id) {
        $sql = "SELECT r.*, e.title as exam_title, s.name as subject_name 
                FROM results r 
                JOIN exams e ON r.exam_id = e.id 
                JOIN subjects s ON e.subject_id = s.id 
                WHERE r.user_id = ? 
                ORDER BY r.submitted_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    public function getByExam($exam_id) {
        $sql = "SELECT r.*, u.name as student_name, u.email as student_email 
                FROM results r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.exam_id = ? 
                ORDER BY r.score DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll();
    }

    public function checkUserAttempt($user_id, $exam_id) {
        $stmt = $this->db->prepare("SELECT id FROM results WHERE user_id = ? AND exam_id = ?");
        $stmt->execute([$user_id, $exam_id]);
        return $stmt->fetch();
    }
}
