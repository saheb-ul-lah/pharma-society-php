<?php
session_name("administrative"); 
session_start();
// Database connection parameters
$host = 'localhost'; // Change to your database host
$dbname = 'pharmaceutical_society'; // Change to your database name
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch student data
    $stmt = $pdo->query("SELECT id, full_name, email, phone, course, submitted_at, profile_pic, dob, year_of_admission, validation FROM student_registration");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($students);

} catch (PDOException $e) {
    echo 'Database Error: ' . $e->getMessage();
}
?>