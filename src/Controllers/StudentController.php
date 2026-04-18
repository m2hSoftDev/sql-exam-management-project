<?php
namespace Controllers;

use Models\Result;
use Repositories\ExamRepository;
use Repositories\QuestionRepository;
use Repositories\ResultRepository;

class StudentController {
    private $examRepo;
    private $questionRepo;
    private $resultRepo;

    public function __construct(
        ExamRepository $examRepo,
        QuestionRepository $questionRepo,
        ResultRepository $resultRepo
    ) {
        $this->examRepo = $examRepo;
        $this->questionRepo = $questionRepo;
        $this->resultRepo = $resultRepo;
    }

    public function dashboard($user_id) {
        $availableExams = $this->examRepo->getUpcomingExams();
        $pastResults = $this->resultRepo->getByUser($user_id);
        
        // Filter out exams already taken
        $availableExams = array_filter($availableExams, function($exam) use ($user_id) {
            return !$this->resultRepo->checkUserAttempt($user_id, $exam->id);
        });

        return compact('availableExams', 'pastResults');
    }

    public function startExam($exam_id, $user_id) {
        // Check if already taken
        if ($this->resultRepo->checkUserAttempt($user_id, $exam_id)) {
            return "You have already attempted this exam.";
        }

        $exam = $this->examRepo->findById($exam_id);
        if (!$exam) return "Exam not found.";

        // Check if exam is live
        $now = new \DateTime();
        $start = new \DateTime($exam->start_time);
        $end = new \DateTime($exam->end_time);

        if ($now < $start) return "This exam has not started yet.";
        if ($now > $end) return "This exam has already ended.";

        $questions = $this->questionRepo->getByExamId($exam_id);
        return compact('exam', 'questions');
    }

    public function submitExam($data, $user_id) {
        $exam_id = $data['exam_id'];
        
        // Prevent double submission
        if ($this->resultRepo->checkUserAttempt($user_id, $exam_id)) {
            return "Error: Double submission detected.";
        }

        $questions = $this->questionRepo->getByExamId($exam_id);
        $score = 0;
        $totalPossible = 0;

        foreach ($questions as $q) {
            $totalPossible += $q->marks;
            $submittedAnswer = $data['answers'][$q->id] ?? null;
            if ($submittedAnswer === $q->correct_option) {
                $score += $q->marks;
            }
        }

        $result = new Result([
            'user_id' => $user_id,
            'exam_id' => $exam_id,
            'score' => $score,
            'total_possible_marks' => $totalPossible
        ]);

        return $this->resultRepo->create($result);
    }
}
