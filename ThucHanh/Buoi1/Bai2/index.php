<?php
// Đường dẫn đến file Quiz.txt (Dựa theo cấu trúc bạn gửi: index.php ở Bai1, Quiz.txt ở src)
// Nếu file Quiz.txt nằm cùng cấp với index.php thì sửa thành: 'Quiz.txt'
$filename = 'src/Quiz.txt'; 
// Hoặc nếu cấu trúc là Bai1/index.php và Bai1/src/Quiz.txt thì dùng:
// $filename = 'src/Quiz.txt';
// Nếu cấu trúc là Buoi1/Bai1/index.php và Buoi1/src/Quiz.txt thì dùng:
$filename = '../src/Quiz.txt'; 


$questions = [];

// --- HÀM ĐỌC VÀ PHÂN TÍCH FILE ---
if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    $currentQuestion = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        // Kiểm tra dòng Đáp án (Bắt đầu bằng ANSWER:)
        if (strpos($line, 'ANSWER:') === 0) {
            $currentQuestion['answer'] = trim(substr($line, 7)); // Lấy chữ cái sau dấu :
            $questions[] = $currentQuestion; // Lưu câu hỏi vào mảng tổng
            $currentQuestion = []; // Reset cho câu tiếp theo
        } 
        // Kiểm tra dòng Lựa chọn (Bắt đầu bằng A., B., C., D.)
        elseif (preg_match('/^[A-D]\./', $line)) {
            $key = substr($line, 0, 1); // Lấy A, B, C...
            $value = substr($line, 2);  // Lấy nội dung
            $currentQuestion['options'][$key] = trim($value);
        } 
        // Dòng Câu hỏi
        else {
            // Nếu chưa có key 'question', khởi tạo
            if (!isset($currentQuestion['question'])) {
                $currentQuestion['question'] = $line;
            } else {
                // Nếu câu hỏi dài nhiều dòng, nối thêm vào
                $currentQuestion['question'] .= " " . $line;
            }
        }
    }
} else {
    $error = "Không tìm thấy file câu hỏi tại: $filename";
}

// --- XỬ LÝ CHẤM ĐIỂM ---
$submitted = false;
$score = 0;
$userAnswers = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submitted = true;
    $userAnswers = $_POST['answer'] ?? [];
    
    foreach ($questions as $index => $q) {
        if (isset($userAnswers[$index]) && $userAnswers[$index] === $q['answer']) {
            $score++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Thi Trắc Nghiệm Android</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .question-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid #0d6efd; }
        .correct-answer { color: green; font-weight: bold; }
        .wrong-answer { color: red; text-decoration: line-through; }
        .result-box { position: fixed; bottom: 20px; right: 20px; z-index: 1000; }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Bài Kiểm Tra Trắc Nghiệm</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php else: ?>

            <form method="POST">
                <?php foreach ($questions as $index => $q): ?>
                    <div class="question-box">
                        <h5 class="mb-3">Câu <?php echo $index + 1; ?>: <?php echo htmlspecialchars($q['question']); ?></h5>
                        
                        <div class="list-group">
                            <?php foreach ($q['options'] as $key => $text): ?>
                                <?php 
                                    // Xác định class CSS khi đã nộp bài
                                    $class = '';
                                    $checked = '';
                                    
                                    // Kiểm tra nếu người dùng đã chọn đáp án này
                                    if (isset($userAnswers[$index]) && $userAnswers[$index] === $key) {
                                        $checked = 'checked';
                                    }

                                    // Hiển thị kết quả sau khi nộp
                                    if ($submitted) {
                                        if ($key === $q['answer']) {
                                            $class = 'list-group-item-success'; // Đáp án đúng tô xanh
                                        } elseif ($checked && $key !== $q['answer']) {
                                            $class = 'list-group-item-danger'; // Chọn sai tô đỏ
                                        }
                                    }
                                ?>
                                
                                <label class="list-group-item <?php echo $class; ?>">
                                    <input type="radio" 
                                           class="form-check-input me-2" 
                                           name="answer[<?php echo $index; ?>]" 
                                           value="<?php echo $key; ?>" 
                                           <?php echo $checked; ?>>
                                    <strong><?php echo $key; ?>.</strong> <?php echo htmlspecialchars($text); ?>
                                    
                                    <?php if ($submitted && $key === $q['answer']): ?>
                                        <span class="badge bg-success float-end">Đúng</span>
                                    <?php endif; ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5">Nộp Bài</button>
                    <a href="index.php" class="btn btn-secondary btn-lg px-5">Làm Lại</a>
                </div>
            </form>

            <?php if ($submitted): ?>
                <div class="alert alert-info result-box shadow">
                    <h4>Kết quả: <?php echo $score; ?> / <?php echo count($questions); ?></h4>
                    <p class="mb-0">Bạn đã trả lời đúng <?php echo round(($score / count($questions)) * 100); ?>% câu hỏi.</p>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</body>
</html>