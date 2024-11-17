<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmaceutical_society";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch action and tab from request
$action = $_GET['action'] ?? $_POST['action'] ?? '';
$tab = $_GET['tab'] ?? $_POST['tab'] ?? '';
$id = $_GET['id'] ?? $_POST['id'] ?? 0;

// Determine the table based on the tab
$table = $tab === 'alumni' ? 'posts' : 'queries';

if ($action === 'fetch') {
    // Fetch all posts or queries
    $result = $conn->query("SELECT * FROM $table ORDER BY timestamp DESC");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} elseif ($action === 'delete') {
    // Delete a post or query
    $sql = "DELETE FROM $table WHERE id = $id";
    $conn->query($sql);
}

// Close the connection
$conn->close();
?>