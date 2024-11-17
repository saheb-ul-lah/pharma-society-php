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

// Get the alumni_id from the query string
$alumni_id = isset($_GET['alumni_id']) ? intval($_GET['alumni_id']) : 0;

if ($alumni_id > 0) {
    $sql = "
        SELECT 
            ar.full_name AS 'Full Name',
            ar.dob AS 'Date of Birth',
            ar.gender AS 'Gender',
            ar.email AS 'Email',
            ar.address AS 'Address',
            ar.job_title AS 'Job Title',
            ar.company AS 'Company',
            ar.linkedin,
            ar.twitter,
            ar.facebook,
            ar.profile_picture AS profileImage,
            GROUP_CONCAT(CONCAT(ad.degree, ' (', ad.year, ')') SEPARATOR ', ') AS 'Degrees'
        FROM 
            alumni_registration ar
        INNER JOIN 
            alumni_degrees ad ON ar.id = ad.alumni_id
        WHERE 
            ar.id = ?
        GROUP BY ar.id;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $alumni_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "No alumni found for the given ID."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Invalid alumni ID."]);
}

$conn->close();
?>
