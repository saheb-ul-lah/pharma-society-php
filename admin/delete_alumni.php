<?php
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

if (isset($_POST['delete_id'])) {
    $deleteId = $conn->real_escape_string($_POST['delete_id']);
    $sql = "DELETE FROM alumni_registration WHERE id = $deleteId";
    if ($conn->query($sql) === TRUE) {
        echo "Alumni record deleted successfully.";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Close connection
$conn->close();
?>