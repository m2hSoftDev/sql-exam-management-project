<?php $title = "Manage Subjects"; include __DIR__ . '/../layout/admin_header.php'; ?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
    <!-- Add Subject Form -->
    <div class="card dash-card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-plus-circle" style="color: var(--primary);"></i> Add New Subject</h3>
        <form action="<?php echo $baseUrl; ?>/admin/subjects/add" method="POST">
            <div class="form-group">
                <label for="name">Subject Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Mathematics" required>
            </div>
            <div class="form-group">
                <label for="code">Subject Code</label>
                <input type="text" name="code" id="code" class="form-control" placeholder="e.g. MATH101" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Subject</button>
        </form>
    </div>

    <!-- Subjects List -->
    <div class="card dash-card">
        <h3 style="margin-bottom: 20px;"><i class="fas fa-list" style="color: var(--primary);"></i> Existing Subjects</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <td><code style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; color: var(--primary); font-weight: 600;"><?php echo $subject->code; ?></code></td>
                        <td style="font-weight: 500;"><?php echo $subject->name; ?></td>
                        <td style="text-align: right;">
                            <a href="<?php echo $baseUrl; ?>/admin/subjects/delete?id=<?php echo $subject->id; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure? All related exams will be deleted.')">
                               <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($subjects)): ?>
                    <tr><td colspan="3" class="text-center" style="padding: 40px; color: var(--text-secondary);">No subjects found. Start by adding one!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layout/admin_footer.php'; ?>
