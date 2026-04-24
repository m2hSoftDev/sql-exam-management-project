<?php $title = "Exam Submitted"; include __DIR__ . '/../layout/student_header.php'; ?>

<div class="card dash-card text-center" style="padding: 60px 40px; max-width: 600px; margin: 40px auto;">
    <div style="font-size: 5rem; color: #10b981; margin-bottom: 24px; animation: scaleUp 0.5s ease-out;">
        <i class="fas fa-check-circle"></i>
    </div>
    <h2 style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin-bottom: 16px;">Congratulations!</h2>
    <p style="font-size: 1.1rem; color: var(--text-secondary); margin-bottom: 40px; line-height: 1.6;">
        Your exam has been submitted successfully. Your results have been recorded and your score is available below.
    </p>
    
    <div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); padding: 32px; border-radius: var(--radius-lg); border: 1px solid var(--border); display: inline-block; min-width: 300px; margin-bottom: 40px;">
        <div style="font-size: 0.95rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 1px;">Final Score</div>
        <div style="font-size: 3.5rem; font-weight: 800; color: var(--primary);">
            <?php echo $score; ?> <span style="font-size: 1.5rem; color: var(--text-secondary); font-weight: 500;">/ <?php echo $total; ?></span>
        </div>
        <div style="margin-top: 15px;">
            <?php 
                $perc = ($total > 0) ? ($score / $total) * 100 : 0;
                $color = $perc >= 50 ? '#10b981' : '#ef4444';
                $text = $perc >= 50 ? 'Passed' : 'Failed';
            ?>
            <span class="badge" style="background: <?php echo $color; ?>20; color: <?php echo $color; ?>; font-size: 0.9rem; padding: 6px 16px;">
                <?php echo $text; ?> (<?php echo round($perc, 1); ?>%)
            </span>
        </div>
    </div>

    <div>
        <a href="<?php echo $baseUrl; ?>/student/dashboard" class="btn btn-primary" style="width: auto; padding: 14px 40px; border-radius: 30px; font-weight: 600; font-size: 1.1rem;">
            <i class="fas fa-home" style="margin-right: 8px;"></i> Return to Dashboard
        </a>
    </div>
</div>

<style>
@keyframes scaleUp {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>

<?php include __DIR__ . '/../layout/student_footer.php'; ?>
