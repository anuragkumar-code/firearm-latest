<?php include('partials/header.php'); ?>

<?php 
$get_id = base64_decode($_GET['product']);

$query = "SELECT * from products where id = '$get_id'";
$result = $conn->query($query);
$fetch = $result->fetch_assoc();

$imageQuery = "SELECT * FROM products_images WHERE product_id = '$get_id'";
$imageResult = $conn->query($imageQuery);
$existingImages = [];
while ($imageRow = $imageResult->fetch_assoc()) {
    $existingImages[] = $imageRow;
}

?>
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Add New Product</h6>
                <form action="functions/product/edit-product.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-2 col-md-4">
                            <label for="productCategory" class="form-label"><b>Category <span class="text-danger">*</span></b></label>
                            <select class="form-select mb-3" name="productCategory" id="productCategory" required>
                                <option label="Select category"></option>
                                <?php 
                                    $query = "SELECT * from categories where status = 'A'";
                                    $result = $conn->query($query);
                                    while($row = $result->fetch_assoc()){ ?>
                                        <option <?php if($fetch['category_id'] == $row['id']){ echo "selected"; } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 col-md-4">
                                <label for="typeOfProduct" class="form-label"><b>Select Product Condition <span class="text-danger">*</span></b></label>
                                <select class="form-select mb-3" name="typeOfProduct" id="typeOfProduct" required>
                                    <option label="Select condition"></option>
                                    <option <?php if($fetch['type_of_component'] == 'New'){ echo "selected"; } ?> value="New">New</option>
                                    <option <?php if($fetch['type_of_component'] == 'Used'){ echo "selected"; } ?> value="Used">Used</option>
                                </select>
                            </div>
                            <div class="mb-2 col-md-4"> 
                                <label for="inventoryNumber" class="form-label"><b>Inventory No. <span class="text-danger">*</span></b></label>
                                <div class="input-group">
                                    <input required type="text" class="form-control" name="inventoryNumber" id="inventoryNumber" placeholder="Enter inventory number" value="<?php echo $fetch['inventory_number']; ?>">
                                </div>
                            </div>
                        <div class="mb-2 col-md-4">
                            <label for="productManufacturer" class="form-label"><b>Manufacturer <span class="text-danger">*</span></b></label>
                            <input required type="text" class="form-control" name="productManufacturer" placeholder="Enter manufacturer name" id="productManufacturer" value="<?php echo $fetch['manufacturer']; ?>">
                        </div>
                        
                        <div class="mb-2 col-md-4">
                            <label for="productModel" class="form-label"><b>Enter Make and Model <span class="text-danger">*</span></b></label>
                            <input required type="text" class="form-control" name="productModel" placeholder="Enter make and model" id="productModel" value="<?php echo $fetch['model']; ?>">
                        </div>
                        <div class="mb-2 col-md-4">
                            <label for="productCaliber" class="form-label"><b>Enter Caliber <span class="text-danger">*</span></b></label>
                            <input required type="text" class="form-control" name="productCaliber" placeholder="Enter name of caliber" id="productCaliber" value="<?php echo $fetch['caliber']; ?>">
                        </div>
                        <div class="mb-2 col-md-4">
                            <label for="productPrice" class="form-label"><b>Price <span class="text-danger">*</span></b></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input required type="text" class="form-control" name="productPrice" id="productPrice" placeholder="Enter price" value="<?php echo $fetch['price']; ?>">
                            </div>
                        </div>
                        
                        <div class="mb-2 col-md-4">
                            <label for="productShortDesc" class="form-label"><b>Short Description <span class="text-danger">*</span></b></label>
                            <input required type="text" class="form-control" name="productShortDesc" id="productShortDesc" value="<?php echo $fetch['short_description']; ?>">
                        </div>
                        <div class="mb-2 col-md-8">
                            <label for="productLongDesc" class="form-label"><b>Long Description <span class="text-danger">*</span></b></label>
                            <textarea class="form-control" name="productLongDesc" id="productLongDesc"><?php echo $fetch['long_description']; ?></textarea>
                        </div>
                        <input type="hidden" value="<?php echo $fetch['id']; ?>" name="product_id">
                    </div>
                    <button type="submit" class="btn btn-primary" name="updateProduct">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include('partials/footer.php'); ?>
