<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Online Exam System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>Create Account</h2>
            <p class="auth-subtitle">Join us to start your examination journey</p>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label for="role">Account Type</label>
                    <select name="role" id="role" class="form-control" required style="cursor: pointer;">
                        <option value="student">Student</option>
                        <option value="admin">Teacher / Administrator</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>
            
            <div style="margin-top: 24px; text-align: center; font-size: 14px; color: var(--text-secondary);">
                Already have an account? <a href="login" style="color: var(--primary); font-weight: 600; text-decoration: none;">Sign In</a>
            </div>
        </div>
    </div>
</body>
</html>
