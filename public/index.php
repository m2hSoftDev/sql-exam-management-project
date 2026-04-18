<?php
/**
 * Main Index Entry Point (Front Controller)
 */

// Simple Autoloader
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Include Core Config
require_once __DIR__ . '/../config/database.php';

use Config\Database;
use Repositories\UserRepository;
use Repositories\SubjectRepository;
use Repositories\ExamRepository;
use Repositories\QuestionRepository;
use Repositories\ResultRepository;
use Controllers\AuthController;
use Controllers\AdminController;
use Controllers\StudentController;

// Database Connection
$dbConfig = new Database();
$db = $dbConfig->getConnection();

// Repositories
$userRepo = new UserRepository($db);
$subjectRepo = new SubjectRepository($db);
$examRepo = new ExamRepository($db);
$questionRepo = new QuestionRepository($db);
$resultRepo = new ResultRepository($db);

// Controllers
$authController = new AuthController($userRepo);
$adminController = new AdminController($subjectRepo, $examRepo, $questionRepo, $resultRepo);
$studentController = new StudentController($examRepo, $questionRepo, $resultRepo);

// Simple Router
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normalize URI for XAMPP subdirectories
$scriptName = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = $scriptName === '\\' || $scriptName === '/' ? '' : str_replace('\\', '/', $scriptName);
if (strpos($requestUri, $scriptName) === 0) {
    $requestUri = substr($requestUri, strlen($scriptName));
}
if ($requestUri === '' || $requestUri === false) {
    $requestUri = '/';
}
$method = $_SERVER['REQUEST_METHOD'];

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect logic
if ($requestUri == '/' || $requestUri == '/login') {
    if ($method == 'POST') {
        $result = $authController->login($_POST['email'], $_POST['password']);
        if ($result === true) {
            $redirect = ($_SESSION['user_role'] == 'admin' ? '/admin/dashboard' : '/student/dashboard');
            header("Location: " . $baseUrl . $redirect);
            exit();
        } else {
            $error = $result;
            include __DIR__ . '/../views/auth/login.php';
        }
    } else {
        if (isset($_SESSION['user_id'])) {
            $redirect = ($_SESSION['user_role'] == 'admin' ? '/admin/dashboard' : '/student/dashboard');
            header("Location: " . $baseUrl . $redirect);
            exit();
        }
        include __DIR__ . '/../views/auth/login.php';
    }
} elseif ($requestUri == '/register') {
    if ($method == 'POST') {
        $result = $authController->register($_POST);
        if ($result === true) {
            header("Location: " . $baseUrl . "/login?registered=1");
            exit();
        } else {
            $error = $result;
            include __DIR__ . '/../views/auth/register.php';
        }
    } else {
        include __DIR__ . '/../views/auth/register.php';
    }
} elseif ($requestUri == '/logout') {
    $authController->logout();
} 
// --- Admin Routes ---
elseif (strpos($requestUri, '/admin') === 0) {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
        header("Location: " . $baseUrl . "/login");
        exit();
    }

    if ($requestUri == '/admin/dashboard') {
        $data = $adminController->dashboard();
        $subjects = $data['subjects'];
        $exams = $data['exams'];
        include __DIR__ . '/../views/admin/dashboard.php';
    } 
    elseif ($requestUri == '/admin/subjects') {
        $subjects = $adminController->listSubjects();
        include __DIR__ . '/../views/admin/subjects.php';
    }
    elseif ($requestUri == '/admin/subjects/add' && $method == 'POST') {
        $adminController->addSubject($_POST);
        header("Location: " . $baseUrl . "/admin/subjects");
    }
    elseif ($requestUri == '/admin/subjects/delete') {
        $adminController->deleteSubject($_GET['id']);
        header("Location: " . $baseUrl . "/admin/subjects");
    }
    elseif ($requestUri == '/admin/exams') {
        $subjects = $adminController->listSubjects();
        $exams = $adminController->listExams();
        include __DIR__ . '/../views/admin/exams.php';
    }
    elseif ($requestUri == '/admin/exams/add' && $method == 'POST') {
        $adminController->addExam($_POST);
        header("Location: " . $baseUrl . "/admin/exams");
    }
    elseif ($requestUri == '/admin/exams/delete') {
        $adminController->deleteExam($_GET['id']);
        header("Location: " . $baseUrl . "/admin/exams");
    }
    elseif ($requestUri == '/admin/exams/questions') {
        $exam = $adminController->getExam($_GET['id']);
        $questions = $adminController->listQuestions($_GET['id']);
        include __DIR__ . '/../views/admin/questions.php';
    }
    elseif ($requestUri == '/admin/exams/questions/add' && $method == 'POST') {
        $adminController->addQuestion($_POST);
        header("Location: " . $baseUrl . "/admin/exams/questions?id=" . $_POST['exam_id']);
    }
    elseif ($requestUri == '/admin/exams/questions/delete') {
        $adminController->deleteQuestion($_GET['id']);
        header("Location: " . $baseUrl . "/admin/exams/questions?id=" . $_GET['exam_id']);
    }
    elseif ($requestUri == '/admin/exams/results') {
        $exam = $adminController->getExam($_GET['id']);
        $results = $adminController->viewResults($_GET['id']);
        include __DIR__ . '/../views/admin/results.php';
    }
}
// --- Student Routes ---
elseif (strpos($requestUri, '/student') === 0) {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'student') {
        header("Location: " . $baseUrl . "/login");
        exit();
    }

    if ($requestUri == '/student/dashboard') {
        $data = $studentController->dashboard($_SESSION['user_id']);
        $availableExams = $data['availableExams'];
        $pastResults = $data['pastResults'];
        include __DIR__ . '/../views/student/dashboard.php';
    }
    elseif ($requestUri == '/student/exam') {
        $result = $studentController->startExam($_GET['id'], $_SESSION['user_id']);
        if (is_string($result)) {
            $error = $result;
            // Fetch data again for dashboard if there's an error
            $data = $studentController->dashboard($_SESSION['user_id']);
            $availableExams = $data['availableExams'];
            $pastResults = $data['pastResults'];
            include __DIR__ . '/../views/student/dashboard.php';
        } else {
            $exam = $result['exam'];
            $questions = $result['questions'];
            include __DIR__ . '/../views/student/exam.php';
        }
    }
    elseif ($requestUri == '/student/exam/submit' && $method == 'POST') {
        $resultId = $studentController->submitExam($_POST, $_SESSION['user_id']);
        if (is_string($resultId)) {
            echo $resultId; // Show error
        } else {
            // Fetch result to show summary
            $questions = $questionRepo->getByExamId($_POST['exam_id']);
            $total = 0; foreach($questions as $q) $total += $q->marks;
            
            // Calculate score locally for the success page to avoid another DB call
            $score = 0;
            foreach ($questions as $q) {
                if (isset($_POST['answers'][$q->id]) && $_POST['answers'][$q->id] === $q->correct_option) {
                    $score += $q->marks;
                }
            }
            include __DIR__ . '/../views/student/success.php';
        }
    }
}
else {
    echo "404 - Page not found.";
}
