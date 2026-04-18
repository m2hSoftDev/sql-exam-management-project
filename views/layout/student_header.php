<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Student Dashboard'; ?> - ExamPro</title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="container nav-content">
            <a href="dashboard" class="logo">
                <i class="fas fa-graduation-cap"></i> ExamPro
            </a>
            <div class="nav-links">
                <a href="<?php echo $baseUrl; ?>/student/dashboard" class="<?php echo (($title ?? '') == 'Student Dashboard') ? 'active' : ''; ?>">My Dashboard</a>
                <a href="<?php echo $baseUrl; ?>/logout" style="color: var(--danger); font-weight: 600;">Logout</a>
            </div>
        </div>
    </header>
    <main class="container">
        <div class="flex-between mb-32" style="margin-top: 20px;">
            <div>
                <h1 style="font-size: 28px;"><?php echo $title ?? 'Welcome back!'; ?></h1>
                <p style="color: var(--text-secondary); font-size: 14px;">Let's excel in your exams today.</p>
            </div>
            <div class="card" style="padding: 12px 20px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 32px; height: 32px; background: var(--success); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                    <?php echo substr($_SESSION['user_name'], 0, 1); ?>
                </div>
                <span style="font-weight: 600; font-size: 14px;"><?php echo $_SESSION['user_name']; ?></span>
            </div>
        </div>
