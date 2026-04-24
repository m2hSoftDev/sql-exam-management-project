<?php
namespace Repositories;

use PDO;

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

    public function create($data) {
        $sql = "INSERT INTO exams (subject_id, title, duration_minutes, start_time, end_time, total_marks) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        $subjectId = is_object($data) ? $data->subject_id : $data['subject_id'];
        $title = is_object($data) ? $data->title : $data['title'];
        $duration = is_object($data) ? $data->duration_minutes : $data['duration_minutes'];
        $start = is_object($data) ? $data->start_time : $data['start_time'];
        $end = is_object($data) ? $data->end_time : $data['end_time'];
        $marks = is_object($data) ? $data->total_marks : $data['total_marks'];

        $stmt->execute([$subjectId, $title, $duration, $start, $end, $marks]);
        return $this->db->lastInsertId();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT e.*, s.name as subject_name FROM exams e JOIN subjects s ON e.subject_id = s.id WHERE e.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($data) {
        $sql = "UPDATE exams SET subject_id = ?, title = ?, duration_minutes = ?, start_time = ?, end_time = ?, total_marks = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        $subjectId = is_object($data) ? $data->subject_id : $data['subject_id'];
        $title = is_object($data) ? $data->title : $data['title'];
        $duration = is_object($data) ? $data->duration_minutes : $data['duration_minutes'];
        $start = is_object($data) ? $data->start_time : $data['start_time'];
        $end = is_object($data) ? $data->end_time : $data['end_time'];
        $marks = is_object($data) ? $data->total_marks : $data['total_marks'];
        $id = is_object($data) ? $data->id : $data['id'];

        return $stmt->execute([$subjectId, $title, $duration, $start, $end, $marks, $id]);
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
