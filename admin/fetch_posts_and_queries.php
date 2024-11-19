<?php
session_name("administrative"); 
session_start();
header('Content-Type: application/json');
require_once 'db_config.php'; // Adjust this to your database configuration file.

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($method === 'GET') {
        // Fetch posts and queries
        $stmt = $pdo->query("SELECT id, title, author, timestamp, content, is_validated, 'post' AS type FROM posts
        UNION ALL
        SELECT id, title, author, timestamp, content, is_validated, 'query' AS type FROM queries
        ORDER BY timestamp DESC");

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $data]);
    } elseif ($method === 'POST') {
        // Delete functionality
        $input = file_get_contents('php://input');
        parse_str($input, $parsed_input);

        if (isset($parsed_input['id']) && isset($parsed_input['type']) && isset($parsed_input['action']) && $parsed_input['action'] === 'toggle_validate') {
            $id = (int)$parsed_input['id'];
            $type = $parsed_input['type'] === 'post' ? 'posts' : 'queries';

            // Fetch the current validation status
            $stmt = $pdo->prepare("SELECT is_validated FROM $type WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $currentStatus = $stmt->fetchColumn();

            // Toggle the validation status
            $newStatus = $currentStatus == 1 ? 0 : 1;

            $stmt = $pdo->prepare("UPDATE $type SET is_validated = :newStatus WHERE id = :id");
            $stmt->execute(['newStatus' => $newStatus, 'id' => $id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Validation status updated.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No rows updated.']);
            }
            exit;
        }
    } else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
