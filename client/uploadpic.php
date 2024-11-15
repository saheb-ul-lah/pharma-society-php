<?php
include('includes/db_connect.php'); // Ensure this file has proper connection details

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
        $fileName = $_FILES['profile_pic']['name'];
        $fileSize = $_FILES['profile_pic']['size'];
        $fileType = $_FILES['profile_pic']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Specify the allowed file extensions
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Set the new file name and path
            $newFileName = uniqid() . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            // Move the file to the uploads directory
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update the database with the new profile picture path
                $stmt = $conn->prepare("UPDATE alumni_registration SET profile_picture = ? WHERE email = ?");
                $stmt->bind_param("ss", $newFileName, $user_email); // Assuming $user_email is available
                if ($stmt->execute()) {
                    echo "Profile picture uploaded successfully.";
                } else {
                    echo "Error updating profile picture in database.";
                }
                $stmt->close();
            } else {
                echo "There was an error moving the uploaded file.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(", ", $allowedfileExtensions);
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>