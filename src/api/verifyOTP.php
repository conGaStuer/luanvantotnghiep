<!-- <?php
// verifyOTP.php

include "config.php";
$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $data->email;
    $otp = $data->otp;
    $userId = $data->userId;

    // Retrieve OTP from the database
    $stmt = $conn->prepare("SELECT otp_code FROM otp_codes WHERE email = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($stored_otp);
    $stmt->fetch();

    if ($otp == $stored_otp) {
        // Update the email in the `nguo_dung` table
        $updateStmt = $conn->prepare("UPDATE nguoi_dung SET email = ? WHERE taikhoan = ?");
        $updateStmt->bind_param("ss", $email, $userId); // Assuming $newEmail contains the new email address
        $updateStmt->execute();


        echo json_encode(['success' => true, 'message' => 'OTP verified successfully and email updated']);

    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid OTP']);
    }
}
?> -->