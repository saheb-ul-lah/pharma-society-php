<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmaceutical_society";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

// Get student_id from query parameters
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;

if (!$student_id) {
    echo json_encode(['error' => 'Student ID is required']);
    $conn->close();
    exit;
}

// Fetch details of a specific student
$sql = "SELECT id, full_name, email, phone, course, submitted_at, profile_pic, dob, year_of_admission 
        FROM student_registration WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    echo json_encode($student);
} else {
    echo json_encode(['error' => 'No student found with the given ID']);
}

$stmt->close();
$conn->close();
?>
