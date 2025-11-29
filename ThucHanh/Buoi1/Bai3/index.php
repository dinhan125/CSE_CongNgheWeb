<?php
// Đường dẫn tới file CSV (Sửa lại cho đúng với thư mục của bạn)
// Ví dụ: nếu file nằm trong folder src: 'src/accounts.csv'
$csvFile = '../src/65HTTT_Danh_sach_diem_danh.csv'; 

$data = [];
$headers = [];

if (file_exists($csvFile)) {
    // Mở file ở chế độ đọc (read)
    if (($handle = fopen($csvFile, "r")) !== FALSE) {
        
        // Đọc dòng đầu tiên làm tiêu đề (Headers)
        if (($headers = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            // Đọc các dòng dữ liệu còn lại
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Gom dữ liệu vào mảng kết hợp (key là header, value là dữ liệu)
                // Điều này rất tiện để sau này insert vào Database theo tên cột
                if (count($headers) == count($row)) {
                    $data[] = array_combine($headers, $row);
                }
            }
        }
        fclose($handle);
    }
} else {
    $error = "Không tìm thấy file: $csvFile";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tài khoản từ CSV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Danh sách tài khoản (Đọc từ CSV)</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (!empty($data)): ?>
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="fw-bold">Dữ liệu sinh viên</span>
                    <button class="btn btn-light btn-sm text-primary">Nhập vào CSDL (Demo)</button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <?php foreach ($headers as $header): ?>
                                        <th scope="col" class="text-capitalize"><?php echo htmlspecialchars($header); ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $student): ?>
                                    <tr>
                                        <?php foreach ($headers as $header): ?>
                                            <td><?php echo htmlspecialchars($student[$header]); ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Tổng số: <?php echo count($data); ?> bản ghi
                </div>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">Không có dữ liệu để hiển thị.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>