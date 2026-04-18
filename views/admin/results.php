<?php $title = "Exam Results: " . $exam->title; include __DIR__ . '/../layout/admin_header.php'; ?>

<div class="flex-between mb-32">
    <a href="dashboard" class="btn btn-sm" style="background: var(--surface); color: var(--text-primary); border: 1px solid var(--border);">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<div class="card dash-card">
    <h3 style="margin-bottom: 20px;"><i class="fas fa-chart-line" style="color: var(--primary);"></i> Student Performances</h3>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th style="text-align: right;">Submitted At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                <tr>
                    <td style="font-weight: 600;"><?php echo $result->student_name; ?></td>
                    <td style="color: var(--text-secondary);"><?php echo $result->student_email; ?></td>
                    <td>
                        <span class="badge" style="background: #dcfce7; color: #166534; font-weight: 700;">
                            <?php echo $result->score; ?> / <?php echo $result->total_possible_marks; ?>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <?php 
                                $percentage = ($result->total_possible_marks > 0) ? ($result->score / $result->total_possible_marks) * 100 : 0;
                            ?>
                            <div style="width: 100px; height: 8px; background: #e2e8f0; border-radius: 4px; overflow: hidden;">
                                <div style="width: <?php echo $percentage; ?>%; height: 100%; background: var(--primary);"></div>
                            </div>
                            <span style="font-weight: 600; min-width: 45px;"><?php echo round($percentage, 2) . '%'; ?></span>
                        </div>
                    </td>
                    <td style="text-align: right; color: var(--text-secondary);"><?php echo date('M d, Y H:i', strtotime($result->submitted_at)); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($results)): ?>
                <tr><td colspan="5" class="text-center" style="padding: 40px; color: var(--text-secondary);">No results found for this exam yet. Once students take the exam, they will appear here.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layout/admin_footer.php'; ?>
