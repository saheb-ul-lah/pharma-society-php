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
function sanitizeInput($data)
{
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

    // Handle the profile picture upload
    $profilePicPath = null;
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
        $profilePic = $_FILES['profilePic'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        // Validate image type
        if (!in_array($profilePic['type'], $allowedTypes)) {
            $errors[] = "Only JPEG, PNG, and GIF files are allowed for the profile picture.";
        }

        // Validate file size (max 200KB)
        if ($profilePic['size'] > 200 * 1024) {  // 200KB
            $errors[] = "Profile picture size must be less than 200KB.";
        }

        // Generate a unique file name and move the file to the upload directory
        if (empty($errors)) {
            $uploadDir = 'uploads/students/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
            }
            $fileName = uniqid('profile_', true) . '.' . pathinfo($profilePic['name'], PATHINFO_EXTENSION);
            $uploadPath = $uploadDir . $fileName;

            // Move the uploaded file
            if (move_uploaded_file($profilePic['tmp_name'], $uploadPath)) {
                $profilePicPath = $uploadPath;
            } else {
                $errors[] = "Failed to upload profile picture.";
            }
        }
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
    $stmt = $conn->prepare("INSERT INTO student_registration (full_name, email, phone, course, profile_pic) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fullName, $email, $phone, $course, $profilePicPath);

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