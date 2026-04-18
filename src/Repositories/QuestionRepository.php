<?php
namespace Repositories;

use PDO;
use Models\Question;

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

    public function create(Question $question) {
        $sql = "INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option, marks) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $question->exam_id,
            $question->question_text,
            $question->option_a,
            $question->option_b,
            $question->option_c,
            $question->option_d,
            $question->correct_option,
            $question->marks
        ]);
        return $this->db->lastInsertId();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update(Question $question) {
        $sql = "UPDATE questions SET question_text = ?, option_a = ?, option_b = ?, option_c = ?, option_d = ?, correct_option = ?, marks = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $question->question_text,
            $question->option_a,
            $question->option_b,
            $question->option_c,
            $question->option_d,
            $question->correct_option,
            $question->marks,
            $question->id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM questions WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
