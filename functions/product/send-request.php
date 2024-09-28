<?php 
include('../../config/db.php'); 

$quantity = $_POST['quantity'];
$message = $_POST['message'];
$customer = $_POST['customer'];
$product = $_POST['product'];

$request_id = "REQ/".time()."/".rand(100, 999);

$insertQuery = "INSERT INTO `customer_requests` (`request_id`,`user_id`, `product_id`, `quantity`,`message`) VALUES ('$request_id','$customer', '$product', '$quantity', '$message')";

if ($conn->query($insertQuery) === TRUE) {
    $result = true;
} else {
    $result = false;
}

echo $result;

$conn->close();
?>
