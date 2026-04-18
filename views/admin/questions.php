<?php $title = "Question Bank: " . $exam->title; include __DIR__ . '/../layout/admin_header.php'; ?>

<div class="flex-between mb-32">
    <a href="<?php echo $baseUrl; ?>/admin/exams" class="btn btn-sm" style="background: var(--surface); color: var(--text-primary); border: 1px solid var(--border);">
        <i class="fas fa-arrow-left"></i> Back to Exams
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Question Form -->
    <div class="card dash-card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add Question</h3>
        <form action="<?php echo $baseUrl; ?>/admin/exams/questions/add" method="POST">
            <input type="hidden" name="exam_id" value="<?php echo $exam->id; ?>">
            <div class="form-group">
                <label for="question_text">Question Text</label>
                <textarea name="question_text" id="question_text" class="form-control" rows="3" placeholder="What is the capital of..." required></textarea>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <label>Option A</label>
                    <input type="text" name="option_a" class="form-control" placeholder="Option A" required>
                </div>
                <div>
                    <label>Option B</label>
                    <input type="text" name="option_b" class="form-control" placeholder="Option B" required>
                </div>
                <div>
                    <label>Option C</label>
                    <input type="text" name="option_c" class="form-control" placeholder="Option C" required>
                </div>
                <div>
                    <label>Option D</label>
                    <input type="text" name="option_d" class="form-control" placeholder="Option D" required>
                </div>
            </div>
            <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <label for="correct_option">Correct Option</label>
                    <select name="correct_option" id="correct_option" class="form-control" required style="cursor: pointer;">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <div>
                    <label for="marks">Marks / Weight</label>
                    <input type="number" name="marks" id="marks" class="form-control" value="1" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add to Exam</button>
        </form>
    </div>

    <!-- Questions List -->
    <div class="card dash-card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-clipboard-list" style="color: var(--primary);"></i> Exam Questions</h3>
        <?php foreach ($questions as $index => $q): ?>
            <div style="padding: 24px; border-radius: var(--radius-md); border: 1px solid var(--border); margin-bottom: 20px; background: #fafafa;">
                <div class="flex-between mb-20">
                    <strong style="font-size: 16px;">Q<?php echo $index + 1; ?>: <?php echo $q->question_text; ?></strong>
                    <span class="badge badge-success"><?php echo $q->marks; ?> Marks</span>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;">
                    <div style="padding: 8px 12px; border-radius: 6px; background: <?php echo $q->correct_option == 'A' ? '#dcfce7' : '#fff' ?>; border: 1px solid <?php echo $q->correct_option == 'A' ? '#10b981' : '#e2e8f0' ?>;">
                        <span style="font-weight: 600; color: <?php echo $q->correct_option == 'A' ? '#065f46' : '#64748b' ?>;">A)</span> <?php echo $q->option_a; ?>
                    </div>
                    <div style="padding: 8px 12px; border-radius: 6px; background: <?php echo $q->correct_option == 'B' ? '#dcfce7' : '#fff' ?>; border: 1px solid <?php echo $q->correct_option == 'B' ? '#10b981' : '#e2e8f0' ?>;">
                        <span style="font-weight: 600; color: <?php echo $q->correct_option == 'B' ? '#065f46' : '#64748b' ?>;">B)</span> <?php echo $q->option_b; ?>
                    </div>
                    <div style="padding: 8px 12px; border-radius: 6px; background: <?php echo $q->correct_option == 'C' ? '#dcfce7' : '#fff' ?>; border: 1px solid <?php echo $q->correct_option == 'C' ? '#10b981' : '#e2e8f0' ?>;">
                        <span style="font-weight: 600; color: <?php echo $q->correct_option == 'C' ? '#065f46' : '#64748b' ?>;">C)</span> <?php echo $q->option_c; ?>
                    </div>
                    <div style="padding: 8px 12px; border-radius: 6px; background: <?php echo $q->correct_option == 'D' ? '#dcfce7' : '#fff' ?>; border: 1px solid <?php echo $q->correct_option == 'D' ? '#10b981' : '#e2e8f0' ?>;">
                        <span style="font-weight: 600; color: <?php echo $q->correct_option == 'D' ? '#065f46' : '#64748b' ?>;">D)</span> <?php echo $q->option_d; ?>
                    </div>
                </div>
                <div style="text-align: right;">
                    <a href="<?php echo $baseUrl; ?>/admin/exams/questions/delete?id=<?php echo $q->id; ?>&exam_id=<?php echo $exam->id; ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Delete this question?')">
                       <i class="fas fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (empty($questions)): ?>
            <p class="text-center" style="padding: 40px; color: var(--text-secondary);">No questions added yet. Add some to make the exam functional!</p>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layout/admin_footer.php'; ?>
