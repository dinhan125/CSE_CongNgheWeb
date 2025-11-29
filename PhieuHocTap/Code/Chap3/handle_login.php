<?php
// TODO 1: Khởi động session (phải trước bất kỳ output nào)
session_start();

// TODO 2: Kiểm tra xem form đã gửi chưa
if (isset($_POST['username']) && isset($_POST['password'])) {

    // TODO 3: Lấy dữ liệu từ $_POST
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    // TODO 4: Kiểm tra logic đăng nhập (giả lập)
    if ($user === 'admin' && $pass === '123456') {
        // TODO 5: Lưu username vào SESSION
        $_SESSION['username'] = $user;

        // TODO 6: Chuyển hướng sang trang chào mừng
        header('Location: welcome.php');
        exit;
    } else {
        // Đăng nhập thất bại -> quay về login với thông báo lỗi
        header('Location: login.html?error=1');
        exit;
    }
} else {
    // TODO 7: Truy cập trực tiếp file -> chuyển về login.html
    header('Location: login.html');
    exit;
}
?>