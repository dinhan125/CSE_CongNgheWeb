<?php
require_once 'db.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_quiz'])) {
    $file = $_FILES['file_quiz']['tmp_name'];
    
    if (file_exists($file)) {
        // Đọc file
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        $currentQuestion = [];
        $count = 0;

        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, 'ANSWER:') === 0) {
                // Gặp dòng ANSWER là kết thúc 1 câu -> Lưu vào DB
                $ans = substr(trim(substr($line, 7)), 0, 1);
                
                // Insert vào DB
                $sql = "INSERT INTO questions (question_content, option_a, option_b, option_c, option_d, answer) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $currentQuestion['content'],
                    $currentQuestion['A'],
                    $currentQuestion['B'],
                    $currentQuestion['C'],
                    $currentQuestion['D'],
                    $ans
                ]);
                
                $count++;
                $currentQuestion = []; // Reset
            } 
            elseif (preg_match('/^([A-D])\./', $line, $matches)) {
                // Dòng đáp án A. B. C. D.
                $key = $matches[1]; // Lấy chữ cái A,B,C,D
                $text = trim(substr($line, 2));
                $currentQuestion[$key] = $text;
            } 
            else {
                // Dòng nội dung câu hỏi
                if (!isset($currentQuestion['content'])) $currentQuestion['content'] = $line;
                else $currentQuestion['content'] .= " " . $line;
            }
        }
        $msg = "Thành công! Đã nhập $count câu hỏi vào CSDL.";
    }
}

// Lấy danh sách câu hỏi từ DB để hiển thị
$stmt = $pdo->query("SELECT * FROM questions");
$questions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload Quiz vào DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Bài 2: Import Câu hỏi từ file Text vào CSDL</h3>
    
    <?php if($msg): ?><div class="alert alert-success"><?=$msg?></div><?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mb-4 border p-4 bg-light">
        <label class="form-label">Chọn file Quiz.txt:</label>
        <input type="file" name="file_quiz" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary">Upload & Lưu vào DB</button>
    </form>

    <h5>Danh sách câu hỏi trong Database:</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Câu hỏi</th>
                <th>Đáp án đúng</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($questions as $q): ?>
            <tr>
                <td><?= $q['id'] ?></td>
                <td><?= htmlspecialchars($q['question_content']) ?></td>
                <td class="text-center fw-bold text-success"><?= $q['answer'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>