<?php

include ('config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$contentArr = array();
$contentQuery = "SELECT * from content_texts where page = 'home_page'";
$result = $conn->query($contentQuery);
while($contentData = $result->fetch_assoc()){
    $contentArr[] = $contentData;
}

?>
