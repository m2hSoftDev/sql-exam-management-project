<?php include __DIR__ . '/../layout/student_header.php'; ?>

<section class="mb-32">
    <h3 class="mb-20" style="display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-clock" style="color: var(--primary);"></i> Available & Upcoming Exams
    </h3>
    <div class="exam-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;">
        <?php foreach ($availableExams as $exam): ?>
            <div class="card dash-card" style="display: flex; flex-direction: column;">
                <div class="flex-between mb-20">
                    <span class="badge" style="background: #eef2ff; color: var(--primary); font-weight: 600;"><?php echo $exam->subject_name; ?></span>
                    <?php 
                        $now = new DateTime();
                        $start = new DateTime($exam->start_time);
                        if ($now >= $start) echo '<span class="badge" style="background: #dcfce7; color: #166534; font-weight: 700;">LIVE NOW</span>';
                        else echo '<span class="badge" style="background: #fef3c7; color: #92400e; font-weight: 700;">UPCOMING</span>';
                    ?>
                </div>
                <h4 style="font-size: 1.25rem; margin-bottom: 12px; color: var(--text-primary);"><?php echo $exam->title; ?></h4>
                <div style="color: var(--text-secondary); font-size: 0.9rem; margin-bottom: 24px; display: flex; flex-direction: column; gap: 8px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-hourglass-half" style="width: 16px; color: var(--primary);"></i> 
                        <span>Duration: <strong><?php echo $exam->duration_minutes; ?> minutes</strong></span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-calendar-alt" style="width: 16px; color: var(--primary);"></i> 
                        <span>Starts: <strong><?php echo date('M d, H:i', strtotime($exam->start_time)); ?></strong></span>
                    </div>
                </div>
                
                <div style="margin-top: auto;">
                    <?php if ($now >= $start): ?>
                        <a href="exam?id=<?php echo $exam->id; ?>" class="btn btn-primary" style="width: 100%;">Take Exam Now</a>
                    <?php else: ?>
                        <button class="btn" style="background: #f1f5f9; color: #94a3b8; cursor: not-allowed; width: 100%;" disabled>
                            <i class="fas fa-lock"></i> Not Yet Started
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($availableExams)): ?>
            <div class="card dash-card" style="grid-column: 1 / -1; text-align: center; padding: 60px;">
                <div style="font-size: 48px; color: #e2e8f0; margin-bottom: 20px;"><i class="fas fa-calendar-times"></i></div>
                <p style="color: var(--text-secondary); font-size: 1.1rem;">No new exams available at the moment. Check back later!</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<section class="mt-3">
    <h3 style="display: flex; align-items: center; gap: 10px; margin-bottom: 24px;">
        <i class="fas fa-history" style="color: var(--primary);"></i> My Past Results
    </h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Exam Title</th>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th style="text-align: right;">Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pastResults as $res): ?>
                <tr>
                    <td><strong style="color: var(--text-primary);"><?php echo $res->exam_title; ?></strong></td>
                    <td><span class="badge" style="background: #f1f5f9; color: var(--text-secondary);"><?php echo $res->subject_name; ?></span></td>
                    <td><span class="badge" style="background: #dcfce7; color: #166534; font-weight: 700;"><?php echo $res->score; ?> / <?php echo $res->total_possible_marks; ?></span></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <?php $perc = ($res->total_possible_marks > 0) ? ($res->score / $res->total_possible_marks) * 100 : 0; ?>
                            <div style="width: 100px; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                                <div style="width: <?php echo $perc; ?>%; height: 100%; background: var(--primary);"></div>
                            </div>
                            <span style="font-weight: 600; min-width: 45px;"><?php echo round($perc, 1) . '%'; ?></span>
                        </div>
                    </td>
                    <td style="text-align: right; color: var(--text-secondary);"><?php echo date('M d, Y', strtotime($res->submitted_at)); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($pastResults)): ?>
                    <tr><td colspan="5" class="text-center" style="padding: 60px; color: var(--text-secondary);">You haven't taken any exams yet. Start your journey today!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../layout/student_footer.php'; ?>
