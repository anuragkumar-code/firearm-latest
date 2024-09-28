<?php 
include ('../../../config/db.php');

if (isset($_POST['updateProduct'])) {

    $product_id = $_POST['product_id'];
    $category_id = $_POST['productCategory'];
    $type_of_component = $_POST['typeOfProduct'];
    $inventory_number = $_POST['inventoryNumber'];
    $manufacturer = $_POST['productManufacturer'];
    $model = $_POST['productModel'];
    $caliber = $_POST['productCaliber'];
    $price = $_POST['productPrice'];
    $short_description = $_POST['productShortDesc'];
    $long_description = $_POST['productLongDesc'];

    $updateProductQuery = "UPDATE `products` SET `category_id` = ?, `manufacturer` = ?, `type_of_component` = ?, `inventory_number` = ?, `model` = ?, `caliber` = ?, `price` = ?, `short_description` = ?, `long_description` = ? WHERE `id` = ?";

    if ($stmt = $conn->prepare($updateProductQuery)) {
        $stmt->bind_param('sssssssssi', $category_id, $manufacturer, $type_of_component, $inventory_number, $model, $caliber, $price, $short_description, $long_description, $product_id);

        if ($stmt->execute()) {
            header('Location: ../../products.php');
            exit();
        } else {
            echo "Error updating product: " . $stmt->error . "<br>";
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
