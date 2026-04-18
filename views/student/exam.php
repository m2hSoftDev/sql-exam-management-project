<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Exam: <?php echo $exam->title; ?> - ExamPro</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: var(--background); font-family: 'Outfit', sans-serif; }
        .timer-sticky {
            position: sticky;
            top: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 15px 10%;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .timer-display {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Outfit', monospace;
            color: var(--primary);
            background: #eef2ff;
            padding: 8px 20px;
            border-radius: 30px;
            border: 1px solid var(--primary-light);
        }
        .exam-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px 100px;
        }
        .question-card {
            background: var(--surface);
            padding: 32px;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            margin-bottom: 30px;
            transition: var(--transition);
        }
        .question-card:hover { border-color: var(--primary-light); box-shadow: var(--shadow-md); }
        .options-list { list-style: none; margin-top: 24px; display: grid; gap: 12px; }
        .option-item {
            position: relative;
            padding: 16px 20px;
            background: #fafafa;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .option-item:hover { background: #f8fafc; border-color: var(--primary-light); }
        .option-item input { 
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            transition: var(--transition);
        }
        .option-item input:checked { border-color: var(--primary); background: var(--primary); }
        .option-item input:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: white;
            border-radius: 50%;
        }
        .option-item.selected { background: #eef2ff; border-color: var(--primary-light); }
        .option-item span { font-weight: 500; color: var(--text-primary); }
    </style>
</head>
<body>

    <div class="timer-sticky">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div style="width: 40px; height: 40px; background: var(--primary); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <div style="font-weight: 700; color: var(--text-primary);"><?php echo $exam->title; ?></div>
                <div style="font-size: 0.8rem; color: var(--text-secondary);"><?php echo count($questions); ?> Questions Total</div>
            </div>
        </div>
        <div id="timer" class="timer-display">00:00:00</div>
        <button type="button" onclick="confirmSubmit()" class="btn btn-primary" style="width: auto; padding: 12px 28px; border-radius: 30px;">
            <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Finish Exam
        </button>
    </div>

    <div class="exam-container">
        <form id="examForm" action="<?php echo $baseUrl; ?>/student/exam/submit" method="POST">
            <input type="hidden" name="exam_id" value="<?php echo $exam->id; ?>">
            
            <?php foreach ($questions as $index => $q): ?>
                <div class="question-card">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                        <span style="background: var(--primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Question <?php echo $index + 1; ?></span>
                        <span style="color: var(--text-secondary); font-size: 0.9rem; font-weight: 500;"><i class="fas fa-star" style="color: #fbbf24; margin-right: 4px;"></i> <?php echo $q->marks; ?> Marks</span>
                    </div>
                    <p style="font-size: 1.15rem; font-weight: 600; color: var(--text-primary); line-height: 1.6; margin-bottom: 24px;"><?php echo nl2br(htmlspecialchars($q->question_text)); ?></p>
                    
                    <div class="options-list">
                        <label class="option-item">
                            <input type="radio" name="answers[<?php echo $q->id; ?>]" value="A" required>
                            <span>A) <?php echo htmlspecialchars($q->option_a); ?></span>
                        </label>
                        <label class="option-item">
                            <input type="radio" name="answers[<?php echo $q->id; ?>]" value="B">
                            <span>B) <?php echo htmlspecialchars($q->option_b); ?></span>
                        </label>
                        <label class="option-item">
                            <input type="radio" name="answers[<?php echo $q->id; ?>]" value="C">
                            <span>C) <?php echo htmlspecialchars($q->option_c); ?></span>
                        </label>
                        <label class="option-item">
                            <input type="radio" name="answers[<?php echo $q->id; ?>]" value="D">
                            <span>D) <?php echo htmlspecialchars($q->option_d); ?></span>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>

    <script>
        console.log("Exam script loaded");
        
        // Set the timer
        let duration = <?php echo (int)($exam->duration_minutes * 60); ?>;
        const timerDisplay = document.getElementById('timer');
        const examForm = document.getElementById('examForm');

        function updateTimer() {
            if (!timerDisplay) return;
            
            let hours = Math.floor(duration / 3600);
            let minutes = Math.floor((duration % 3600) / 60);
            let seconds = duration % 60;

            timerDisplay.textContent = 
                (hours < 10 ? "0" + hours : hours) + ":" +
                (minutes < 10 ? "0" + minutes : minutes) + ":" +
                (seconds < 10 ? "0" + seconds : seconds);

            if (duration <= 0) {
                console.log("Time is up, auto-submitting");
                alert("Time is up! Your exam will be submitted automatically.");
                examForm.submit();
            } else {
                duration--;
                if (duration < 60) {
                    timerDisplay.style.color = "#ef4444";
                    timerDisplay.style.background = "#fee2e2";
                }
                setTimeout(updateTimer, 1000);
            }
        }

        window.confirmSubmit = function() {
            console.log("confirmSubmit called");
            if (confirm("Are you sure you want to finish and submit your exam?")) {
                console.log("Submission confirmed, calling submit()");
                examForm.submit();
            }
        };

        // Handle styling of selected options
        document.querySelectorAll('.option-item input').forEach(input => {
            input.addEventListener('change', function() {
                this.closest('.options-list').querySelectorAll('.option-item').forEach(el => el.classList.remove('selected'));
                this.closest('.option-item').classList.add('selected');
            });
        });

        // Start timer
        updateTimer();

        // Prevent back button
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.history.go(1);
        };
    </script>
</body>
</html>
