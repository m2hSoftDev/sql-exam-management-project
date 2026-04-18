# Getting Started: Online Examination Management System

To run and check the application on your local machine, follow these three simple steps:

## 1. Prepare the Database (PostgreSQL)
1.  **Create Database**: Open your PostgreSQL management tool (like **pgAdmin** or **psql**) and create a new database named `exam_db`.
2.  **Import Schema**: Open the [database.sql](file:///c:/University_Project/dbms_online_exam_management_project/database.sql) file and execute its contents within the `exam_db` database.
3.  **Update Credentials**: Open [config/database.php](file:///c:/University_Project/dbms_online_exam_management_project/config/database.php) and update the `$password` with your local PostgreSQL password.

## 2. Start the Application
If you have PHP installed separately, run this in your terminal inside the project folder:
```powershell
php -S localhost:8000 -t public
```

**If you are using XAMPP/WAMP**:
1.  Move the entire project folder to your `htdocs` (XAMPP) or `www` (WAMP) directory.
2.  Access it via `http://localhost/dbms_online_exam_management_project/public`.

## 3. Recommended Test Flow
Once the server is running, navigate to `http://localhost:8000`:

1.  **Register a Teacher**: Go to **Register**, fill in your details, and select "Teacher/Admin" as the role.
2.  **Create a Subject**: Log in, go to the **Subjects** tab, and add a subject (e.g., Mathematics, MATH101).
3.  **Set Up an Exam**: Go to the **Exams** tab, select your subject, set a title, and set the **Start Time** to "Now" and **End Time** to "Tomorrow".
4.  **Add Questions**: Click on "Questions" next to your exam and add 2–3 MCQs with marks.
5.  **Student Test**: Log out and Register a "Student" account. You will see the exam on your dashboard.
6.  **Take the Exam**: Click "Start Exam" and observe the **Live Timer**. Submit it before time runs out to see your **Automated Grade**.

---

> [!IMPORTANT]
> **Enable PostgreSQL Extension**: Ensure that `extension=pdo_pgsql` and `extension=pgsql` are uncommented in your `php.ini` file for the connection to work.
