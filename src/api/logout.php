<?php
// Bắt đầu phiên làm việc
session_start();

// Xóa tất cả các biến phiên
session_unset();

// Hủy phiên làm việc
session_destroy();

// Chuyển hướng người dùng đến trang đăng nhập hoặc trang chính của ứng dụng
header("Access-Control-Allow-Origin: http://localhost:8080");
exit();
?>