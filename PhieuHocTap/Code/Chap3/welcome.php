<?php
session_start(); // TODO 1: Khởi động session

// TODO 2: Kiểm tra SESSION lưu tên đăng nhập (ở đây dùng 'username')
if (isset($_SESSION['username'])) {

    // TODO 3: Lấy username từ SESSION
    $loggedInUser = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');

    // TODO 4: In ra lời chào mừng
    echo "<h1>Chào mừng trở lại, $loggedInUser!</h1>";
    echo "<p>Bạn đã đăng nhập thành công.</p>";

    // TODO 5: Tạo link "Đăng xuất" tạm thời (quay về login.html)
    echo '<a href="login.html">Đăng xuất (Tạm thời)</a>';

} else {
    // TODO 6: Nếu chưa đăng nhập, chuyển hướng về login.html
    header('Location: login.html');
    exit;
}
?>