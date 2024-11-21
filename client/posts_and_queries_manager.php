<?php
session_start();
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

$user_name = 'Guest';
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT user_name FROM `signup-users` WHERE user_email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();
        $user_name = $row['user_name'];
    }
    $stmt->close();
}
// Fetch action and tab from request
$action = $_GET['action'] ?? $_POST['action'] ?? '';
$tab = $_GET['tab'] ?? $_POST['tab'] ?? '';
$id = $_GET['id'] ?? $_POST['id'] ?? 0;

// Determine the table based on the tab
$table = $tab === 'alumni' ? 'posts' : 'queries';

if ($action === 'fetch') {
    // Fetch all posts or queries
    $result = $conn->query("SELECT * FROM $table WHERE is_validated = 0 ORDER BY timestamp DESC");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
} elseif ($action === 'get') {
    // Fetch a single post or query by ID
    $result = $conn->query("SELECT * FROM $table WHERE id = $id");
    echo json_encode($result->fetch_assoc());
} elseif ($action === 'create') {
    // Create a new post or query
    $author = $user_name;  //Replace this with authenticated user data if needed
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $sql = "INSERT INTO $table (author, title, content, email) VALUES ('$author', '$title', '$content', '$user_email')";
    $conn->query($sql);
} elseif ($action === 'update') {
    // Update an existing post or query
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $sql = "UPDATE $table SET title = '$title', content = '$content' WHERE id = $id";
    $conn->query($sql);
} elseif ($action === 'delete') {
    // Delete a post or query
    $sql = "DELETE FROM $table WHERE id = $id";
    $conn->query($sql);
}

// Close the connection
$conn->close();
?>