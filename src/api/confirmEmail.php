<?php
include "config.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if token exists
    $sql_check_token = "SELECT * FROM email_confirmations WHERE token = '$token'";
    $result_check_token = $conn->query($sql_check_token);

    if ($result_check_token->num_rows > 0) {
        $row = $result_check_token->fetch_assoc();
        $userId = $row['user_id'];
        $email = $row['email'];

        // Update email in nguoi_dung table
        $sql_update_email = "UPDATE nguoi_dung SET email = '$email' WHERE maND = '$userId'";
        if ($conn->query($sql_update_email) === TRUE) {
            // Delete the token after successful update
            $sql_delete_token = "DELETE FROM email_confirmations WHERE token = '$token'";
            $sql_update_emailConfirm = "UPDATE nguoi_dung SET emailConfirmed = 'true' WHERE maND = '$userId'";

            $conn->query($sql_delete_token);
            $conn->query($sql_update_emailConfirm);

            echo "Email xác nhận thành công!";
        } else {
            echo "Error updating email: " . $conn->error;
        }
    } else {
        echo "Invalid token";
    }

    $conn->close();
} else {
    echo "No token provided";
}
?>