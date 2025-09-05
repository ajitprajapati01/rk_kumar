<?php
// Database connection
$conn = mysqli_connect("localhost","root","","ajxcrud");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the ID from the POST request
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

// Validate the ID
if ($id <= 0) {
    echo "Invalid ID provided.";
    $conn->close();
    exit();
}

// Prepare the DELETE statement
$stmt = $conn->prepare("DELETE FROM testing WHERE id = '$id'");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter to the placeholder
//$stmt->bind_param("i", $id);

// Execute the DELETE statement
if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Record deleted successfully.";
    } else {
        echo "No record found with the provided ID.";
    }
} else {
    echo "Error executing query: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>