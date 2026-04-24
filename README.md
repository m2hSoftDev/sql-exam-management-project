# 🚀 Raw SQL: Online Examination Management System

[![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777bb4?style=for-the-badge&logo=php)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-MySQL-4479A1?style=for-the-badge&logo=mysql)](https://www.mysql.com/)
[![SQL Focus](https://img.shields.io/badge/SQL-100%25%20Raw-blueviolet?style=for-the-badge)](https://en.wikipedia.org/wiki/SQL)

A performance-optimized, full-stack PHP application where the **entire business logic is powered by Raw SQL**. This project priorities direct database control, query precision, and the "Pure Row" architectural approach.

---

## ✨ Core Features & Functionality

### 🛠️ Administrative Powerhouse
- **Dynamic Exam Architect**: Create, edit, and schedule exams with precise start/end windows.
- **Subject Intelligence**: Organize your curriculum with a code-based subject management system.
- **Automated MCQ Engine**: Add questions with variable marking and auto-grading capabilities.
- **Live Performance Tracking**: Monitor student results in real-time with aggregated statistics.

### 🎓 Premium Student Experience
- **Smart Dashboard**: A tailored view showing only live exams that are ready to be taken.
- **Live Countdown Timer**: A synchronized, JavaScript-enhanced timer that ensures strict exam duration enforcement.
- **Instant Result Generation**: View your scores immediately after submission, calculated server-side for maximum security.
- **Historical Performance**: Access a complete log of all past attempts and grades.

### 🔒 Enterprise-Grade Security
- **Secure Authentication**: Role-based access control (RBAC) for Admins and Students.
- **SQL Injection Protection**: 100% prepared statements using PDO.
- **Atomic Operations**: Database transactions and constraints ensure data integrity.

---

## 💎 The "Raw SQL" Philosophy

This project rejects the use of ORMs (Object-Relational Mappers) in favor of **Raw SQL via PDO**. This ensures:
- **Zero Overhead**: No heavy abstraction layers between PHP and MySQL.
- **Full Control**: Complete mastery over execution plans and query optimization.
- **Pure Data**: Returns raw associative arrays for high-performance data handling.

---

## 📂 Detailed Database Schema

The system is built on a normalized relational schema designed for ACID compliance and referential integrity.

### 🗺️ Table Definitions

| Table | Columns | Purpose |
| :--- | :--- | :--- |
| **`users`** | `id`, `name`, `email`, `password`, `role` | Identity management (Admin/Student). |
| **`subjects`** | `id`, `name`, `code` | Categorization for exams (e.g., CS101). |
| **`exams`** | `id`, `subject_id`, `title`, `duration_minutes`, `start_time`, `end_time`, `total_marks` | Scheduled examination sessions. |
| **`questions`** | `id`, `exam_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks` | Individual MCQ items linked to exams. |
| **`results`** | `id`, `user_id`, `exam_id`, `score`, `total_possible_marks`, `submitted_at` | Persistence for student attempts. |

---

## 🔥 Query Showcase (Deep Dive)

### 1. Smart Student Dashboard Logic
To find exams that are **currently live** and have **not yet been attempted** by a specific student, we use a correlated subquery:

```sql
SELECT e.*, s.name as subject_name 
FROM exams e 
JOIN subjects s ON e.subject_id = s.id 
WHERE e.end_time > CURRENT_TIMESTAMP 
AND e.id NOT IN (
    SELECT exam_id FROM results WHERE user_id = :student_id
)
ORDER BY e.start_time ASC;
```

### 2. Automated Server-Side Grading
Instead of calculating scores in PHP loops, we leverage SQL aggregates to compute results in a single atomic operation:

```sql
SELECT 
    SUM(CASE WHEN q.correct_option = user_ans.ans THEN q.marks ELSE 0 END) as score,
    SUM(q.marks) as total_possible
FROM questions q
JOIN (
    -- This simulates the user's submitted answers
    SELECT 1 as q_id, 'B' as ans UNION ALL
    SELECT 2 as q_id, 'A' as ans
) as user_ans ON q.id = user_ans.q_id
WHERE q.exam_id = :exam_id;
```

### 3. Admin Analytics & Performance
Aggregating global stats across all student attempts for a high-level overview:

```sql
SELECT 
    e.title,
    COUNT(r.id) as total_submissions,
    AVG(r.score) as average_score,
    MAX(r.score) as highest_score
FROM exams e
LEFT JOIN results r ON e.id = r.exam_id
GROUP BY e.id;
```

---

## 🏗️ Architecture & SQL Logic

### 🔗 Referential Integrity Rules
- **Cascading Deletes**: `ON DELETE CASCADE` is implemented on `exams -> questions` and `exams -> results`. If an exam is deleted, all related data is automatically purged.
- **Unique Constraints**: A composite unique key `UNIQUE(user_id, exam_id)` on the `results` table prevents students from submitting the same exam twice.

---

## 🛠️ Setup & Installation

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/m2hSoftDev/sql-exam-management-project.git
    ```
2.  **Initialize Database**
    - Create `exam_db`.
    - Run the commands in `database.sql` to build the schema.
3.  **Config**
    - Edit `config/database.php` with your MySQL credentials.
4.  **Run**
    ```bash
    php -S localhost:8000 -t public
    ```

---

## 🔐 Access Credentials

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@exam.com` | `admin123` |
| **Student** | `student@exam.com` | `student123` |

---

*This project serves as a masterclass in utilizing Raw SQL for high-performance web applications.*
