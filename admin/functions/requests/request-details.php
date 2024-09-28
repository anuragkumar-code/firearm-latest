<?php
include('../../../config/db.php');

if (isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    $query = "SELECT 
                customer_requests.quantity AS product_quantity, 
                customer_requests.message AS request_message, 
                customer_requests.request_id AS request_id, 
                customer_requests.created_at AS request_date, 
                users.name AS customer_name, 
                users.mobile AS customer_mobile, 
                users.email AS customer_email, 
                users.address_one AS customer_address_one, 
                users.address_two AS customer_address_two, 
                products.name AS product_name, 
                products.price AS product_price, 
                products.short_description AS product_short_description,
                products.long_description AS product_long_description,
                products.master_image AS product_image 
              FROM customer_requests 
              JOIN users ON customer_requests.user_id = users.id 
              JOIN products ON customer_requests.product_id = products.id 
              WHERE customer_requests.id = '$request_id'";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>
