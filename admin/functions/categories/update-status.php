<?php 
include ('../../../config/db.php');

$id=isset($_POST['id'])?$_POST['id']:'';
$status=isset($_POST['status'])?$_POST['status']:'';

if ($status == 'A') {
    $newStatus = 'I';
} else {
    $newStatus = 'A';
}

$sql = "UPDATE categories SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newStatus, $id);

if ($stmt->execute()) {
    echo '1'; 
} else {
    echo '0'; 
}

$stmt->close();
$conn->close();
?>