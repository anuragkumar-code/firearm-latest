<?php
session_start();

if (isset($_POST['age_confirmed'])) {
    $_SESSION['age_confirmed'] = $_POST['age_confirmed'];
    echo json_encode(['status' => 'success']);
} 
?>