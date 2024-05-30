<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["anhbia"])) {
    $targetDir = "uploads/";
    $fileName = uniqid() . "_" . basename($_FILES["anhbia"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    if (move_uploaded_file($_FILES["anhbia"]["tmp_name"], $targetFilePath)) {
        echo json_encode(["url" => $targetFilePath]);
    } else {
        echo json_encode(["error" => "Failed to upload file"]);
    }
}
?>