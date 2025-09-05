<?php
$conn = new mysqli("localhost", "root", "", "ajxcrud");
if ($conn->connect_error) { die("Connection Failed: " . $conn->connect_error); }

$id        = $_POST['record-id'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$lastname  = $_POST['lastname'] ?? '';
$email     = $_POST['email'] ?? '';
$age       = $_POST['age'] ?? 0;
$phone     = $_POST['phone'] ?? '';
$address   = $_POST['address'] ?? '';
$password  = $_POST['password'] ?? '';

if (!$id) { echo "ID not found."; exit; }

if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE testing SET firstname=?, lastname=?, email=?, age=?, phone=?, address=?, password=? WHERE id=?");
    $stmt->bind_param("sssisssi", $firstname, $lastname, $email, $age, $phone, $address, $hashed_password, $id);
} else {
    $stmt = $conn->prepare("UPDATE testing SET firstname=?, lastname=?, email=?, age=?, phone=?, address=? WHERE id=?");
    $stmt->bind_param("sssissi", $firstname, $lastname, $email, $age, $phone, $address, $id);
}

if ($stmt->execute()) {
    echo "Record updated successfully.";
} else {
    echo "Update Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
