<?php
namespace Models;

class Exam {
    public $id;
    public $subject_id;
    public $title;
    public $duration_minutes;
    public $start_time;
    public $end_time;
    public $total_marks;
    public $created_at;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->subject_id = $data['subject_id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->duration_minutes = $data['duration_minutes'] ?? null;
        $this->start_time = $data['start_time'] ?? null;
        $this->end_time = $data['end_time'] ?? null;
        $this->total_marks = $data['total_marks'] ?? 0;
        $this->created_at = $data['created_at'] ?? null;
    }
}
