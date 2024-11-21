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

// Fetch alumni data with grouped degrees
$sql = "
    SELECT 
        ar.id AS alumni_id,
        ar.full_name,
        ar.dob,
        ar.gender,
        ar.email,
        ar.phone,
        ar.address,
        ar.job_title,
        ar.company,
        ar.company_location,
        ar.linkedin,
        ar.twitter,
        ar.facebook,
        ar.profile_picture,
        ar.created_at,
        GROUP_CONCAT(ad.degree ORDER BY ad.year SEPARATOR ', ') AS degrees,
        GROUP_CONCAT(ad.year ORDER BY ad.year SEPARATOR ', ') AS years
    FROM 
        alumni_registration ar
    LEFT JOIN 
        alumni_degrees ad ON ar.id = ad.alumni_id
    WHERE
        ar.validation=1
    GROUP BY 
        ar.id
    ORDER BY 
        ar.created_at DESC;
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