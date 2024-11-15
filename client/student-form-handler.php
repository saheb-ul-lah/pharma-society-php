<?php
// Set JSON header
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmaceutical_society";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        'status' => 'error', 
        'message' => 'Database connection failed: ' . $conn->connect_error
    ]);
    exit;
}

// Validate and sanitize input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $fullName = sanitizeInput($_POST['fullName']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = sanitizeInput($_POST['phone']);
    $course = sanitizeInput($_POST['course']);

    // Validate inputs
    $errors = [];

    if (empty($fullName)) {
        $errors[] = "Full Name is required";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be 10 digits";
    }

    if (empty($course)) {
        $errors[] = "Course selection is required";
    }

    // If there are validation errors
    if (!empty($errors)) {
        echo json_encode([
            'status' => 'error', 
            'message' => implode(', ', $errors)
        ]);
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO student_registration (full_name, email, phone, course) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $email, $phone, $course);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success', 
            'message' => 'Form submitted successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Error submitting form: ' . $stmt->error
        ]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If not a POST request
    echo json_encode([
        'status' => 'error', 
        'message' => 'Invalid request method'
    ]);
}
?>