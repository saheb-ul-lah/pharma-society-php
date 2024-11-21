<?php
session_name("administrative"); 
session_start();
header('Content-Type: application/json');
require_once 'db_config.php'; // Adjust this to your database configuration file.

$method = $_SERVER['REQUEST_METHOD'];

try {
    // Establish MySQLi connection
    $mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);

    if ($mysqli->connect_error) {
        throw new Exception("Connection failed: " . $mysqli->connect_error);
    }

    if ($method === 'GET') {
        // Fetch posts and queries
        $query = "
            SELECT id, title, author, timestamp, content, is_validated, 'post' AS type FROM posts
            UNION ALL
            SELECT id, title, author, timestamp, content, is_validated, 'query' AS type FROM queries
            ORDER BY timestamp DESC";
        $result = $mysqli->query($query);

        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to fetch data.']);
        }
    } elseif ($method === 'POST') {
        // Get the raw input data
        $input = file_get_contents('php://input');
        parse_str($input, $parsed_input);

        if (isset($parsed_input['id'], $parsed_input['type'], $parsed_input['action'])) {
            $id = (int)$parsed_input['id'];
            $type = $parsed_input['type'] === 'post' ? 'posts' : 'queries';

            if ($parsed_input['action'] === 'toggle_validate') {
                // Fetch the current validation status
                $stmt = $mysqli->prepare("SELECT is_validated FROM $type WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($currentStatus);
                $stmt->fetch();
                $stmt->close();

                // Toggle the validation status
                $newStatus = $currentStatus == 1 ? 0 : 1;

                $stmt = $mysqli->prepare("UPDATE $type SET is_validated = ? WHERE id = ?");
                $stmt->bind_param("ii", $newStatus, $id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo json_encode(['status' => 'success', 'message' => 'Validation status updated.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No rows updated.']);
                }
                $stmt->close();
            } elseif ($parsed_input['action'] === 'delete') {
                // Delete the record
                $stmt = $mysqli->prepare("DELETE FROM $type WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No rows deleted.']);
                }
                $stmt->close();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid parameters.']);
        }
    } else {
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    }

    $mysqli->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
