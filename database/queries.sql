-- ========================================================
-- ONLINE EXAMINATION MANAGEMENT SYSTEM - RAW SQL VERSION
-- ========================================================

-- This file contains 100% raw SQL code representing all logic 
-- previously handled by PHP Repositories and Controllers.

-- ==========================================
-- 1. SEED DATA (INITIAL SETUP)
-- ==========================================

-- Add Users (Admin, Teacher, Student)
INSERT INTO users (name, email, password, role) VALUES 
('Admin User', 'admin@example.com', '$2y$10$hashed_admin_pass', 'admin'),
('Teacher Smith', 'teacher@example.com', '$2y$10$hashed_teacher_pass', 'teacher'),
('Hasan', 'hasan@example.com', '$2y$10$hashed_student_pass', 'student');

-- Add Subjects
INSERT INTO subjects (name, code) VALUES 
('Mathematics', 'MATH101'),
('Computer Science', 'CS50'),
('Physics', 'PHYS201');

-- Add an Exam
INSERT INTO exams (subject_id, title, duration_minutes, start_time, end_time, total_marks) VALUES 
(1, 'Calculus Midterm', 60, '2023-11-01 10:00:00', '2023-11-01 11:00:00', 10);

-- Add Questions for Exam 1
INSERT INTO questions (exam_id, question_text, option_a, option_b, option_c, option_d, correct_option, marks) VALUES 
(1, 'What is the derivative of x^2?', 'x', '2x', 'x^2', '2', 'B', 5),
(1, 'What is the integral of 1/x?', 'ln(x)', 'e^x', 'x^2', '1', 'A', 5);


-- ==========================================
-- 2. AUTHENTICATION & USER LOGIC
-- ==========================================

-- Login Check (Returns user if email exists, PHP handles password_verify)
SELECT * FROM users WHERE email = 'hasan@example.com';

-- Get User Profile
SELECT id, name, email, role, created_at FROM users WHERE id = 3;


-- ==========================================
-- 3. STUDENT DASHBOARD LOGIC
-- ==========================================

-- Get AVAILABLE EXAMS (Exams that are live AND user hasn't taken yet)
-- This replaces the array_filter logic in StudentController::dashboard
SELECT e.*, s.name as subject_name 
FROM exams e 
JOIN subjects s ON e.subject_id = s.id 
WHERE e.end_time > CURRENT_TIMESTAMP -- Is still live or upcoming
AND e.id NOT IN (
    SELECT exam_id FROM results WHERE user_id = 3
)
ORDER BY e.start_time ASC;

-- Get PAST RESULTS for Student 3
SELECT r.*, e.title as exam_title, s.name as subject_name 
FROM results r 
JOIN exams e ON r.exam_id = e.id 
JOIN subjects s ON e.subject_id = s.id 
WHERE r.user_id = 3 
ORDER BY r.submitted_at DESC;


-- ==========================================
-- 4. EXAM SUBMISSION LOGIC (The "Magic" Query)
-- ==========================================

-- Instead of calculating score in PHP, we can do it in SQL!
-- Assuming we have a temporary way to pass student answers, 
-- or we just want to see how the score is calculated.

-- CALCULATE SCORE for a given set of answers
-- (Example: User answered 'B' for Q1 and 'C' for Q2)
SELECT 
    SUM(CASE WHEN q.correct_option = user_ans.ans THEN q.marks ELSE 0 END) as calculated_score,
    SUM(q.marks) as total_possible
FROM questions q
JOIN (
    SELECT 1 as q_id, 'B' as ans -- Answer for Q1
    UNION ALL
    SELECT 2 as q_id, 'C' as ans -- Answer for Q2
) as user_ans ON q.id = user_ans.q_id
WHERE q.exam_id = 1;

-- RECORD THE RESULT (The final action after calculation)
INSERT INTO results (user_id, exam_id, score, total_possible_marks) 
VALUES (3, 1, 5, 10);


-- ==========================================
-- 5. ADMIN ANALYTICS
-- ==========================================

-- Get Exam Stats (Total students, Avg Score, Highest Score)
SELECT 
    e.title,
    COUNT(r.id) as total_submissions,
    AVG(r.score) as average_score,
    MAX(r.score) as highest_score,
    MIN(r.score) as lowest_score
FROM exams e
LEFT JOIN results r ON e.id = r.exam_id
GROUP BY e.id;

-- List all questions for an exam with their correct answers (for teacher view)
SELECT question_text, option_a, option_b, option_c, option_d, correct_option, marks 
FROM questions 
WHERE exam_id = 1 
ORDER BY id ASC;
