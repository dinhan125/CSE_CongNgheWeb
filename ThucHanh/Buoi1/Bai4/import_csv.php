<?php
require_once 'db.php';

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_csv'])) {
    $file = $_FILES['file_csv']['tmp_name'];
    
    if (file_exists($file)) {
        if (($handle = fopen($file, "r")) !== FALSE) {
            // Bỏ qua dòng tiêu đề
            fgetcsv($handle, 1000, ","); 
            
            $count = 0;
            
            // --- SỬA TÊN BẢNG Ở ĐÂY (accounts -> dsdiemdanh) ---
            $sql = "INSERT INTO dsdiemdanh (username, password, lastname, firstname, city, email, course1) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                try {
                    $stmt->execute([
                        $data[0], // username
                        $data[1], // password
                        $data[2], // lastname
                        $data[3], // firstname
                        $data[4], // city
                        $data[5], // email
                        $data[6]  // course1
                    ]);
                    $count++;
                } catch (Exception $e) {
                    // Bỏ qua lỗi
                }
            }
            fclose($handle);
            $msg = "Đã nhập $count sinh viên vào bảng 'dsdiemdanh' thành công!";
        }
    }
}

// --- SỬA TÊN BẢNG Ở ĐÂY (accounts -> dsdiemdanh) ---
$stmt = $pdo->query("SELECT * FROM dsdiemdanh");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Điểm danh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Danh sách Điểm danh (Import CSV)</h3>

    <?php if($msg): ?><div class="alert alert-success"><?=$msg?></div><?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="mb-4 border p-4 bg-light">
        <label class="form-label">Chọn file CSV:</label>
        <input type="file" name="file_csv" class="form-control mb-3" required accept=".csv">
        <button type="submit" class="btn btn-primary">Import Dữ Liệu</button>
    </form>

    <div class="card">
        <div class="card-header bg-success text-white">Dữ liệu trong bảng: dsdiemdanh</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Mã SV</th>
                        <th>Họ & Tên</th>
                        <th>Email</th>
                        <th>Lớp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($students as $sv): ?>
                    <tr>
                        <td><?= htmlspecialchars($sv['username']) ?></td>
                        <td><?= htmlspecialchars($sv['lastname'] . ' ' . $sv['firstname']) ?></td>
                        <td><?= htmlspecialchars($sv['email']) ?></td>
                        <td><?= htmlspecialchars($sv['city']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>