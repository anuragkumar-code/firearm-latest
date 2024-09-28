<?php
include('../../../config/db.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM customer_requests WHERE id = ?";
    if ($stmt = $conn->prepare($deleteQuery)) {
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute()) {
            echo '1'; 
        } else {
            echo 'Error deleting request: ' . $stmt->error; 
        }

        $stmt->close();
    } else {
        echo 'Error preparing statement: ' . $conn->error; 
    }
} else {
    echo 'Invalid request. Please provide a valid request ID.';
}

$conn->close();
?>
