<?php
header('Content-Type: application/json');
require_once 'db_config.php'; // Adjust this to your database configuration file.

$method = $_SERVER['REQUEST_METHOD'];

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($method === 'GET') {
        // Fetch posts and queries
        $stmt = $pdo->query("SELECT id, title, author, timestamp, content, 'post' AS type FROM posts
                             UNION ALL
                             SELECT id, title, author, timestamp, content, 'query' AS type FROM queries
                             ORDER BY timestamp DESC");

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $data]);
    } elseif ($method === 'POST') {
        // Delete functionality
        $input = file_get_contents('php://input');
        parse_str($input, $parsed_input);

        if (isset($parsed_input['id']) && isset($parsed_input['type'])) {
            $id = (int)$parsed_input['id'];
            $type = $parsed_input['type'] === 'post' ? 'posts' : 'queries';

            $stmt = $pdo->prepare("DELETE FROM $type WHERE id = :id");
            $stmt->execute(['id' => $id]);

            if ($stmt->rowCount() > 0) {
                echo json_encode(['status' => 'success', 'message' => 'Item deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Item not found.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
