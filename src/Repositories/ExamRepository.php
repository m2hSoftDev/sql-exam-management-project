<?php
namespace Repositories;

use PDO;
use Models\Exam;

class ExamRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllWithSubject() {
        $sql = "SELECT e.*, s.name as subject_name 
                FROM exams e 
                JOIN subjects s ON e.subject_id = s.id 
                ORDER BY e.start_time DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create(Exam $exam) {
        $sql = "INSERT INTO exams (subject_id, title, duration_minutes, start_time, end_time, total_marks) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $exam->subject_id, 
            $exam->title, 
            $exam->duration_minutes, 
            $exam->start_time, 
            $exam->end_time,
            $exam->total_marks
        ]);
        return $this->db->lastInsertId();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT e.*, s.name as subject_name FROM exams e JOIN subjects s ON e.subject_id = s.id WHERE e.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update(Exam $exam) {
        $sql = "UPDATE exams SET subject_id = ?, title = ?, duration_minutes = ?, start_time = ?, end_time = ?, total_marks = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $exam->subject_id, 
            $exam->title, 
            $exam->duration_minutes, 
            $exam->start_time, 
            $exam->end_time,
            $exam->total_marks,
            $exam->id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM exams WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getUpcomingExams() {
        $sql = "SELECT e.*, s.name as subject_name 
                FROM exams e 
                JOIN subjects s ON e.subject_id = s.id 
                WHERE e.end_time > CURRENT_TIMESTAMP 
                ORDER BY e.start_time ASC";
        return $this->db->query($sql)->fetchAll();
    }
}
