<?php
namespace Repositories;

use PDO;

class QuestionRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getByExamId($exam_id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE exam_id = ? ORDER BY id ASC");
        $stmt->execute([$exam_id]);
        return $stmt->fetchAll();
    }

    public function create(array $data) {
        $sql = "INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option, marks) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['exam_id'],
            $data['question_text'],
            $data['option_a'],
            $data['option_b'],
            $data['option_c'],
            $data['option_d'],
            $data['correct_option'],
            $data['marks']
        ]);
        return $this->db->lastInsertId();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update(array $data) {
        $sql = "UPDATE questions SET question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_option = ?, marks = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['question_text'],
            $data['option_a'],
            $data['option_b'],
            $data['option_c'],
            $data['option_d'],
            $data['correct_option'],
            $data['marks'],
            $data['id']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM questions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
