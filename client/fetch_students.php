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

// Fetch all students
$sql = "SELECT * FROM student_registration WHERE validation=1 ORDER BY submitted_at DESC";
$result = $conn->query($sql);

$students = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

echo json_encode($students);

$conn->close();
?>