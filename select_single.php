<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "ajxcrud"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in POST request and is an integer
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']); // Ensure id is an integer

    // Prepare the SQL statement with a placeholder
    $sql = "SELECT * FROM testing WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the integer parameter
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the result as an associative array
        $record = $result->fetch_assoc();

        // Output the record as JSON
        echo json_encode($record);

        // Close the statement
        $stmt->close();
    } else {
        echo json_encode(["error" => "Failed to prepare statement."]);
    }
} else {
    echo json_encode(["error" => "Invalid ID."]);
}

// Close the connection
$conn->close();
?>