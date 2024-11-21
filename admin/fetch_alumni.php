<?php
session_name("administrative"); 
session_start();
// Database configuration
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "pharmaceutical_society"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch alumni data
$sql = "SELECT a.id, a.full_name, a.dob, a.gender, a.email, a.phone, a.address, a.job_title, a.company, a.company_location, a.linkedin, a.twitter, a.facebook, a.profile_picture, a.created_at, a.validation, GROUP_CONCAT(d.degree SEPARATOR ', ') AS degrees
        FROM alumni_registration a
        LEFT JOIN alumni_degrees d ON a.id = d.alumni_id
        GROUP BY a.id";

$result = $conn->query($sql);
$alumni = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $alumni[] = $row;
    }
}
echo json_encode($alumni);

// Close connection
$conn->close();
?>