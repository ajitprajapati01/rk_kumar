<?php
$servername = "localhost";
$username   = "root";      
$password   = "";          
$dbname     = "ajxcrud";   

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

// ✅ पहले check करेंगे कि email पहले से मौजूद तो नहीं
$check = "SELECT * FROM testing WHERE email = '$email'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "⚠️ User already exists with this email!";
} else {
    // Insert query
    $sql = "INSERT INTO testing (firstname, lastname, email, age, phone, address, password) 
            VALUES ('$firstname', '$lastname', '$email', '$age', '$phone', '$address', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Record inserted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

