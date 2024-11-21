<?php
// Database connection (update with your database credentials)
include('includes/db_connect.php');
// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}

// Check if the ID is sent via POST
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize the input

    // Update the validation column for the given ID
    $query = "UPDATE alumni_registration SET validation = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User validated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to validate user.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request. No ID provided.']);
}

$conn->close();
?>
