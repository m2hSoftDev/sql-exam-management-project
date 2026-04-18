<?php
namespace Models;

class Subject {
    public $id;
    public $name;
    public $code;
    public $created_at;

    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->code = $data['code'] ?? null;
        $this->created_at = $data['created_at'] ?? null;
    }
}
