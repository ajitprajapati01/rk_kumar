<?php
$servername = "localhost";
$username   = "root";      // XAMPP/WAMP/MAMP पर default user
$password   = "";          // default password empty होता है
$dbname     = "ajxcrud";   // अपने database का नाम डाल

// DB connect
$conn = new mysqli($servername, $username, $password, $dbname);

// Error check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$firstname = $_POST['firstname'] ?? '';
$lastname  = $_POST['lastname'] ?? '';
$email     = $_POST['email'] ?? '';
$age       = $_POST['age'] ?? '';
$phone     = $_POST['phone'] ?? '';
$address   = $_POST['address'] ?? '';
$password  = $_POST['password'] ?? '';

// Password hash करना अच्छा है
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert query
$sql = "INSERT INTO testing (firstname, lastname, email, age, phone, address, password) 
        VALUES ('$firstname', '$lastname', '$email', '$age', '$phone', '$address', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "Record inserted successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
