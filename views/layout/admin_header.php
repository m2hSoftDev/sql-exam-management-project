<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Admin Dashboard'; ?> - ExamPro</title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside>
            <a href="<?php echo $baseUrl; ?>/admin/dashboard" class="logo" style="color: white; margin-bottom: 40px; padding-left: 12px;">
                <i class="fas fa-graduation-cap"></i> ExamPro
            </a>
            <div class="sidebar-links">
                <a href="<?php echo $baseUrl; ?>/admin/dashboard" class="<?php echo (($title ?? '') == 'Admin Dashboard') ? 'active' : ''; ?>">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <a href="<?php echo $baseUrl; ?>/admin/subjects" class="<?php echo (($title ?? '') == 'Manage Subjects') ? 'active' : ''; ?>">
                    <i class="fas fa-book-open"></i> Subjects
                </a>
                <a href="<?php echo $baseUrl; ?>/admin/exams" class="<?php echo (($title ?? '') == 'Manage Exams') ? 'active' : ''; ?>">
                    <i class="fas fa-clipboard-list"></i> Exams
                </a>
                <a href="<?php echo $baseUrl; ?>/logout" style="margin-top: auto; color: #fca5a5;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </aside>
        <main>
            <div class="flex-between mb-32">
                <div>
                    <h1 style="font-size: 28px;"><?php echo $title ?? 'Dashboard Overview'; ?></h1>
                    <p style="color: var(--text-secondary); font-size: 14px;">Welcome back, <?php echo $_SESSION['user_name']; ?></p>
                </div>
                <div class="card" style="padding: 12px 20px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                        <?php echo substr($_SESSION['user_name'], 0, 1); ?>
                    </div>
                    <span style="font-weight: 600; font-size: 14px;"><?php echo $_SESSION['user_name']; ?></span>
                </div>
            </div>
