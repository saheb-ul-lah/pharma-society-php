<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pharmaceutical_society';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch alumni data with degrees and year
$sql = "
    SELECT 
        ar.id AS alumni_id,
        ar.full_name,
        ar.profile_picture,
        ar.job_title,
        ar.company,
        ad.degree,
        ad.year
    FROM 
        alumni_registration ar
    INNER JOIN 
        alumni_degrees ad ON ar.id = ad.alumni_id
    ORDER BY ad.year DESC;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $alumni = [];
    while ($row = $result->fetch_assoc()) {
        $alumni[] = $row;
    }
    echo json_encode($alumni);
} else {
    echo json_encode([]);
}

$conn->close();
?>