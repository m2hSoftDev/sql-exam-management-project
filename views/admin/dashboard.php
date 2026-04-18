<?php include __DIR__ . '/../layout/admin_header.php'; ?>

<div class="stats-grid">
    <div class="stat-card">
        <span class="stat-label">Total Subjects</span>
        <span class="stat-value"><?php echo count($subjects); ?></span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Total Exams</span>
        <span class="stat-value"><?php echo count($exams); ?></span>
    </div>
</div>

<div class="card">
    <div class="flex-between mb-20">
        <h3>Recent Exams</h3>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Subject</th>
                    <th>Duration</th>
                    <th>Starts</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exams as $exam): ?>
                <tr>
                    <td style="font-weight: 600;"><?php echo $exam->title; ?></td>
                    <td><span class="badge" style="background: #eef2ff; color: var(--primary);"><?php echo $exam->subject_name; ?></span></td>
                    <td><?php echo $exam->duration_minutes; ?> mins</td>
                    <td style="color: var(--text-secondary);"><?php echo date('M d, H:i', strtotime($exam->start_time)); ?></td>
                    <td>
                        <?php 
                            $now = new DateTime();
                            $start = new DateTime($exam->start_time);
                            $end = new DateTime($exam->end_time);
                            if ($now < $start) echo '<span class="badge badge-warning">Upcoming</span>';
                            elseif ($now > $end) echo '<span class="badge" style="background: #f1f5f9; color: #94a3b8;">Finished</span>';
                            else echo '<span class="badge badge-success">Live</span>';
                        ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="exams/questions?id=<?php echo $exam->id; ?>" class="btn btn-sm" style="background: #f1f5f9; color: var(--text-primary);">Questions</a>
                            <a href="exams/results?id=<?php echo $exam->id; ?>" class="btn btn-sm btn-primary">Results</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($exams)): ?>
                <tr><td colspan="6" class="text-center" style="padding: 40px; color: var(--text-secondary);">No exams found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/admin_footer.php'; ?>
