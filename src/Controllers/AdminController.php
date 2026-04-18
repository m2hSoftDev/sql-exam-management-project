<?php
namespace Controllers;

use Models\Subject;
use Models\Exam;
use Models\Question;
use Repositories\SubjectRepository;
use Repositories\ExamRepository;
use Repositories\QuestionRepository;
use Repositories\ResultRepository;

class AdminController {
    private $subjectRepo;
    private $examRepo;
    private $questionRepo;
    private $resultRepo;

    public function __construct(
        SubjectRepository $subjectRepo,
        ExamRepository $examRepo,
        QuestionRepository $questionRepo,
        ResultRepository $resultRepo
    ) {
        $this->subjectRepo = $subjectRepo;
        $this->examRepo = $examRepo;
        $this->questionRepo = $questionRepo;
        $this->resultRepo = $resultRepo;
    }

    // --- Dashboard ---
    public function dashboard() {
        $subjects = $this->subjectRepo->getAll();
        $exams = $this->examRepo->getAllWithSubject();
        return compact('subjects', 'exams');
    }

    // --- Subjects ---
    public function listSubjects() {
        return $this->subjectRepo->getAll();
    }

    public function addSubject($data) {
        $subject = new Subject($data);
        return $this->subjectRepo->create($subject);
    }

    public function deleteSubject($id) {
        return $this->subjectRepo->delete($id);
    }

    // --- Exams ---
    public function listExams() {
        return $this->examRepo->getAllWithSubject();
    }

    public function addExam($data) {
        $exam = new Exam($data);
        return $this->examRepo->create($exam);
    }

    public function deleteExam($id) {
        return $this->examRepo->delete($id);
    }

    public function getExam($id) {
        return $this->examRepo->findById($id);
    }

    // --- Questions ---
    public function listQuestions($exam_id) {
        return $this->questionRepo->getByExamId($exam_id);
    }

    public function addQuestion($data) {
        $question = new Question($data);
        return $this->questionRepo->create($question);
    }

    public function deleteQuestion($id) {
        return $this->questionRepo->delete($id);
    }

    // --- Results ---
    public function viewResults($exam_id) {
        return $this->resultRepo->getByExam($exam_id);
    }
}
