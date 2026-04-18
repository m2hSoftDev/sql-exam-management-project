<?php $title = "Manage Exams"; include __DIR__ . '/../layout/admin_header.php'; ?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Exam Form -->
    <div class="card dash-card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Create New Exam</h3>
        <form action="<?php echo $baseUrl; ?>/admin/exams/add" method="POST">
            <div class="form-group">
                <label for="subject_id">Subject</label>
                <select name="subject_id" id="subject_id" class="form-control" required>
                    <option value="">Select Subject</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo $subject->id; ?>"><?php echo $subject->name; ?> (<?php echo $subject->code; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Exam Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Midterm 2024" required>
            </div>
            <div class="form-group">
                <label for="duration_minutes">Duration (Minutes)</label>
                <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" value="60" required>
            </div>
            <div class="form-group">
                <label for="start_time">Start Date & Time</label>
                <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Date & Time</label>
                <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Exam</button>
        </form>
    </div>

    <!-- Exams List -->
    <div class="card dash-card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-calendar-alt" style="color: var(--primary);"></i> Current Exams</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Exam</th>
                        <th>Subject</th>
                        <th>Duration</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exams as $exam): ?>
                    <tr>
                        <td style="font-weight: 600;"><?php echo $exam->title; ?></td>
                        <td><span class="badge" style="background: #eef2ff; color: var(--primary); font-weight: 600;"><?php echo $exam->subject_name; ?></span></td>
                        <td><?php echo $exam->duration_minutes; ?> mins</td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="<?php echo $baseUrl; ?>/admin/exams/questions?id=<?php echo $exam->id; ?>" class="btn btn-sm" style="background: #f1f5f9; color: var(--text-primary);">
                                    <i class="fas fa-question-circle"></i> Questions
                                </a>
                                <a href="<?php echo $baseUrl; ?>/admin/exams/delete?id=<?php echo $exam->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this exam?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($exams)): ?>
                    <tr><td colspan="4" class="text-center" style="padding: 40px; color: var(--text-secondary);">No exams created yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/admin_footer.php'; ?>
