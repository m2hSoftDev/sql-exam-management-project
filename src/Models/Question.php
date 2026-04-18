<?php
namespace Models;

class Question {
    public $id;
    public $exam_id;
    public $question_text;
    public $option_a;
    public $option_b;
    public $option_c;
    public $option_d;
    public $correct_option;
    public $marks;
    public $created_at;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->exam_id = $data['exam_id'] ?? null;
        $this->question_text = $data['question_text'] ?? null;
        $this->option_a = $data['option_a'] ?? null;
        $this->option_b = $data['option_b'] ?? null;
        $this->option_c = $data['option_c'] ?? null;
        $this->option_d = $data['option_d'] ?? null;
        $this->correct_option = $data['correct_option'] ?? null;
        $this->marks = $data['marks'] ?? 1;
        $this->created_at = $data['created_at'] ?? null;
    }
}
