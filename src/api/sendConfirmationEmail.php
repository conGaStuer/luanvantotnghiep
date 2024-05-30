<?php
include "config.php";
require 'D:\ComposerSetup\vendor\autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "D:\PHPMailer-PHPMailer-2128d99\src\Exception.php";
require "D:\PHPMailer-PHPMailer-2128d99\src\PHPMailer.php";
require "D:\PHPMailer-PHPMailer-2128d99\src\SMTP.php";

$data = json_decode(file_get_contents("php://input"));

if (isset($data->email) && isset($data->userId)) {
    $email = $data->email;
    $userId = $data->userId;
    $token = bin2hex(random_bytes(16)); // Generate a random token

    // Insert token into the email_confirmations table
    $sql_insert_token = "INSERT INTO email_confirmations (user_id, email, token) VALUES ('$userId', '$email', '$token')";
    if ($conn->query($sql_insert_token) === TRUE) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'dh52003670@student.stu.edu.vn'; // Your email
            $mail->Password = '0854219725Bb'; // Your email password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('dh52003670@student.stu.edu.vn', 'Book Store');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Email Confirmation';
            $mail->Body = "Click <a href='http://localhost/LVTN/book-store/src/api/confirmEmail.php?token=$token'>here</a> to confirm your email address.";

            $mail->send();
            echo json_encode(["emailSent" => true]);
        } catch (Exception $e) {
            echo json_encode(["emailSent" => false, "error" => $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(["emailSent" => false, "error" => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Invalid input"]);
}
?>