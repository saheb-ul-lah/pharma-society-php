<?php
// Database connection parameters
$host = 'localhost'; // Change to your database host
$dbname = 'pharmaceutical_society'; // Change to your database name
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the delete ID from the request
    $deleteId = $_POST['delete_id'];

    // Prepare and execute the delete statement
    $stmt = $pdo->prepare("DELETE FROM student_registration WHERE id = :id");
    $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);
    $stmt->execute();

    echo 'Student deleted successfully.';

} catch (PDOException $e) {
    echo 'Database Error: ' . $e->getMessage();
}
?>