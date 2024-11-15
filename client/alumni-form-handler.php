<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";  // Replace with your database password
$dbname = "pharmaceutical_society";  // Replace with your database name

// Set header for JSON response
header('Content-Type: application/json');

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Personal information
    $fullName = mysqli_real_escape_string($conn, $_POST['fullName']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Career information
    $jobTitle = isset($_POST['jobTitle']) ? mysqli_real_escape_string($conn, $_POST['jobTitle']) : null;
    $company = isset($_POST['company']) ? mysqli_real_escape_string($conn, $_POST['company']) : null;
    $companyLocation = isset($_POST['companyLocation']) ? mysqli_real_escape_string($conn, $_POST['companyLocation']) : null;
    
    // Social media links
    $linkedin = isset($_POST['linkedin']) ? mysqli_real_escape_string($conn, $_POST['linkedin']) : null;
    $twitter = isset($_POST['twitter']) ? mysqli_real_escape_string($conn, $_POST['twitter']) : null;
    $facebook = isset($_POST['facebook']) ? mysqli_real_escape_string($conn, $_POST['facebook']) : null;
    
    // Profile picture
    $profilePicture = null;
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] == UPLOAD_ERR_OK) {
        $profilePicture = 'uploads/' . basename($_FILES['profilePicture']['name']);
        if (!move_uploaded_file($_FILES['profilePicture']['tmp_name'], $profilePicture)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file.']);
            exit; // Stop further execution
        }
    }

    // Insert into alumni_registration table
    $stmt = $conn->prepare("INSERT INTO alumni_registration (full_name, dob, gender, email, phone, address, job_title, company, company_location, linkedin, twitter, facebook, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $fullName, $dob, $gender, $email, $phone, $address, $jobTitle, $company, $companyLocation, $linkedin, $twitter, $facebook, $profilePicture);
    
    if ($stmt->execute()) {
        $alumniId = $stmt->insert_id;

        // Insert degrees
        if (isset($_POST['degree']) && is_array($_POST['degree'])) {
            foreach ($_POST['degree'] as $key => $degree) {
                $year = mysqli_real_escape_string($conn, $_POST['year'][$key]);
                $degreeStmt = $conn->prepare("INSERT INTO alumni_degrees (alumni_id, degree, year) VALUES (?, ?, ?)");
                $degreeStmt->bind_param("iss", $alumniId, $degree, $year);
                
                if (!$degreeStmt->execute()) {
                    echo json_encode(['status' => 'error', 'message' => 'Error inserting degree: ' . $degreeStmt->error]);
                    exit; // Stop further execution
                }
            }
        }
        
        echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error occurred while submitting the form: ' . $stmt->error]);
    }
    
    $stmt->close();
    $conn->close();
}
?>