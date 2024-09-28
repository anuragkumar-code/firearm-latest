<?php 
include('partials/header.php'); 

$get_id = base64_decode($_GET['id']);

$imageArr = array();
$relatedArr = array();

$productQuery = "SELECT * from products where id='$get_id'";
$result = $conn->query($productQuery);
$productData = $result->fetch_assoc();

$categoryFetch = $productData['category_id'];
$relatedProducts = "SELECT * from products where category_id = '$categoryFetch' AND status = 'A' AND id != '$get_id' LIMIT 4";
$resultRelatedProducts = $conn->query($relatedProducts);
while($relatedData = $resultRelatedProducts->fetch_assoc()){
    $relatedArr[] = $relatedData;
}

$productImageQuery = "SELECT * from products_images where status = 'A' AND product_id='$get_id'";
$resultImage = $conn->query($productImageQuery);
while($productImageData = $resultImage->fetch_assoc()){
    $imageArr[] = $productImageData['image'];
}
// echo "<pre>"; print_r($imageArr);exit;

?>
<style>
.gallery-thumbs {
    max-height: 500px; 
    overflow-y: hidden; 
    overflow-x: hidden; 
    padding-right: 10px; 
    transition: overflow-y 0.3s ease; 
}

.gallery-thumbs:hover {
    overflow-y: auto; 
}

.gallery-thumbs::-webkit-scrollbar {
    width: 5px; 
    background: transparent; 
}

.gallery-thumbs::-webkit-scrollbar-thumb {
    background-color: #888; 
    border-radius: 10px;
}

.gallery-thumbs:hover::-webkit-scrollbar-thumb {
    background-color: #555; 
}

.gallery-thumbs {
    scrollbar-width: none; 
}

.gallery-thumbs:hover {
    scrollbar-width: thin; 
}

.fixed-flag {
    position: fixed;
    bottom: 20px;
    right: 20px; 
    background-color: #007bff;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    font-size: 1rem;
    z-index: 1000; 
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.fixed-flag:hover {
    background-color: #0056b3;
}




</style>
    <main id="main-content" class="position-relative">
        <section class="page-title position-relative">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">PRODUCT DETAILS</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="inner-gap pb-0 mb-5">
            <div class="container">
                <div class="row gy-3">
                    <div class="col-lg-6">
                        <div class="row gy-3">
                            <div class="col-sm-3 order-1 order-sm-0">
                                <div class="swiper gallery-thumbs">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <!--<img src="admin/product_images/<?php //echo $productData['master_image']; ?>" class="mix-blend-darken" alt="">-->
                                            <img src="admin/product_images/<?php echo !empty($productData['master_image']) ? $productData['master_image'] : 'error.png'; ?>" class="mix-blend-darken" alt="">
                                        </div>
                                        <?php foreach ($imageArr as $key => $value) { ?>
                                            <div class="swiper-slide">
                                                <img src="admin/product_images/<?php echo $value; ?>" class="mix-blend-darken" alt="">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9 order-0">
                                <div class="swiper gallery-slider">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="admin/product_images/<?php echo !empty($productData['master_image']) ? $productData['master_image'] : 'error.png'; ?>" class="mix-blend-darken" alt="">
                                            <!--<img src="admin/product_images/<?php echo $productData['master_image']; ?>" class="mix-blend-darken" alt="">-->
                                        </div>
                                        <?php foreach ($imageArr as $key => $value) { ?>
                                            <div class="swiper-slide">
                                                <img src="admin/product_images/<?php echo $value; ?>" class="mix-blend-darken" alt="">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex flex-column align-items-start gap-3">
                            
                            <h2 class="product-title"><?php echo $productData['manufacturer']; ?></h2>
                            <h5 class="order-id"><b>Inventory No. : </b><?php echo $productData['inventory_number']; ?></h5>
                            <h5 class="order-id"><?php echo $productData['short_description']; ?></h5>
                            <p><?php echo $productData['long_description']; ?></p>
                            <div class="row mt-3">
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-cogs fa-2x me-3"></i>
                                        <div>
                                            <h5><b>Model</b></h5>
                                            <p class="mb-0"><?php echo $productData['model']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-bullseye fa-2x me-3"></i>
                                        <div>
                                            <h5><b>Caliber</b></h5>
                                            <p class="mb-0"><?php echo $productData['caliber']; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-box fa-2x me-3"></i>
                                        <div>
                                            <h5><b>Product Condition</b></h5>
                                            <p class="mb-0"><?php echo $productData['type_of_component']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <h2 class="product-price"><span>$<?php echo $productData['price']; ?></span></h2>
                            <div class="d-flex gap-3">
                                <a href="javascript:void(0)" class="primary-btn"><i class="fa fa-message"></i><?php echo $mobile; ?> (Text Only)</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <?php if(count($relatedArr) > 0){?>
        <section class="product mt-5 mb-4">
            <div class="container">
                <div class="title-group text-center">
                    <h2 class="sub-title">RELATED PRODUCTS</h2>
                </div>
                <div class="product-action-wrapper d-flex flex-column flex-sm-row align-items-center gap-3 gap-xl-5">
                    <ul class="product-nav d-flex align-items-center flex-shrink-0">
                        <li><a href="#" class="product-link active">LATEST</a></li>
                    </ul>
                    <div class="border-top w-100">
                    </div>
                    
                </div>
                <div class="row justify-content-center gy-3">
                    <?php foreach ($relatedArr as $key => $valueCat) { 

                            // $currentDate = new DateTime();
                            // $createdDate = new DateTime($valueCat['created_at']);
                            // $interval = $currentDate->diff($createdDate);
                            // $daysDifference = $interval->days;
                            // $isNew = $daysDifference <= 10;

                        ?>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <a href="product-details.php?id=<?php echo base64_encode($valueCat['id']); ?>">
                                <div class="product-card">
                                <?php //if ($isNew) { ?>
                                    <!--<span class="product-badge">new</span>-->
                                <?php //} ?>
                                    <div class="product-img">
                                        <img src="admin/product_images/<?php echo !empty($valueCat['master_image']) ? $valueCat['master_image'] : 'error.png'; ?>" alt="">
                                        <!--<img src="admin/product_images/<?php //echo $valueCat['master_image']; ?>" alt="">-->
                                    </div>
                                    <div class="product-content d-flex justify-content-between align-items-center mb-4">
                                        <h6><?php echo $valueCat['manufacturer']; ?></h6>
                                        <h4>$ <?php echo $valueCat['price'] ?></h4>
                                    </div>
                                    <div class="view-product-button mt-1">View Product</div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <?php } ?>

        <div class="fixed-flag">
            <strong>For questions or online inquiries, text 662 393 7740</strong>
        </div>
    </main>
    

<?php include('partials/footer.php'); ?>