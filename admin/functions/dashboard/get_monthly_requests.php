<?php
include('../../../config/db.php');

$query = "SELECT MONTHNAME(created_at) as month, COUNT(id) as total_requests 
          FROM customer_requests 
          WHERE YEAR(created_at) = YEAR(CURRENT_DATE())
          GROUP BY MONTH(created_at) 
          ORDER BY MONTH(created_at)";

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>
