<?php 
include ('../../../config/db.php');

if(isset($_POST['addProduct'])){

    $category_id = $_POST['productCategory'];
    $type_of_component = $_POST['typeOfProduct'];
    $inventory_number = $_POST['inventoryNumber'];
    $manufacturer = $_POST['productManufacturer']; 
    $model = $_POST['productModel'];
    $caliber = $_POST['productCaliber'];
    $price = $_POST['productPrice'];
    $short_description = $_POST['productShortDesc'];
    $long_description = $_POST['productLongDesc'];

    $insertProductQuery = "INSERT INTO `products` (`category_id`, `type_of_component`, `inventory_number`,`manufacturer`, `model`, `caliber`, `price`, `short_description`, `long_description`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($insertProductQuery)) {
        $stmt->bind_param('sssssssss', $category_id, $type_of_component, $inventory_number, $manufacturer, $model, $caliber, $price, $short_description, $long_description);

        if ($stmt->execute()) {
            $last_id = base64_encode($conn->insert_id);
            header('Location: ../../upload-images.php?product='.$last_id);
            exit();
        } else {
            echo "Error inserting product: " . $stmt->error . "<br>";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error . "<br>";
    }

} else {
    echo "Form not submitted properly or missing data.<br>";
}

$conn->close(); 
?>
