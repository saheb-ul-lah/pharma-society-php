<?php
session_name("administrative"); 
session_start();
// Database connection
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

// Handle different actions based on request method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'create':
            createNotification($conn);
            break;
        case 'update':
            updateNotification($conn);
            break;
        case 'delete':
            deleteNotification($conn);
            break;
        case 'mark_read':
            markNotificationRead($conn);
            break;
        case 'mark_all_read':
            markAllNotificationsRead($conn);
            break;
    }
}

// Fetch Notifications
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? 'fetch';

    if ($action === 'fetch') {
        fetchNotifications($conn);
    }
}

// Function to Create Notification
function createNotification($conn) {
    $title = $_POST['title'] ?? '';
    $message = $_POST['message'] ?? '';
    $date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO notifications (title, message, date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $message, $date);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'id' => $stmt->insert_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
}

// Function to Update Notification
function updateNotification($conn) {
    $id = $_POST['id'] ?? 0;
    $title = $_POST['title'] ?? '';
    $message = $_POST['message'] ?? '';

    $stmt = $conn->prepare("UPDATE notifications SET title = ?, message = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $message, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
}

// Function to Delete Notification
function deleteNotification($conn) {
    $id = $_POST['id'] ?? 0;

    $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
}

// Function to Mark Single Notification as Read
function markNotificationRead($conn) {
    $id = $_POST['id'] ?? 0;

    $stmt = $conn->prepare("UPDATE notifications SET is_read = !is_read WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
}

// Function to Mark All Notifications as Read
function markAllNotificationsRead($conn) {
    $stmt = $conn->prepare("UPDATE notifications SET is_read = TRUE");
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    $stmt->close();
}

// Function to Fetch Notifications
function fetchNotifications($conn) {
    $query = "SELECT * FROM notifications ORDER BY created_at DESC";
    $result = $conn->query($query);

    $notifications = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notifications[] = $row;
        }
    }

    echo json_encode($notifications);
}

$conn->close();
?>