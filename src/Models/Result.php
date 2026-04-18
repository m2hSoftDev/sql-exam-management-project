<?php
namespace Models;

class Result {
    public $id;
    public $user_id;
    public $exam_id;
    public $score;
    public $total_possible_marks;
    public $submitted_at;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->user_id = $data['user_id'] ?? null;
        $this->exam_id = $data['exam_id'] ?? null;
        $this->score = $data['score'] ?? null;
        $this->total_possible_marks = $data['total_possible_marks'] ?? null;
        $this->submitted_at = $data['submitted_at'] ?? null;
    }
}
