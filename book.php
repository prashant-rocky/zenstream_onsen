<?php
// Database connection details
$servername = "localhost"; // or your hosting server
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "zenstream_onsen"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize form data
$Name = isset($_POST['Name']) ? trim($_POST['Name']) : '';
$service = isset($_POST['service']) ? trim($_POST['service']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Basic validation
if (empty($Name) || empty($service) || empty($email) || empty($phone)) {
    die("All required fields must be filled!");
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO book (Name, service, email, phone, message) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sssss", $Name, $service, $email, $phone, $message);

// Execute query
if ($stmt->execute()) {
    // Redirect to thank you page after successful submission
    header("Location: thankyou.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
