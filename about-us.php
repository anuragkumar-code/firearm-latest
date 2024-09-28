<?php include('partials/about_header.php');


$contentAboutArr = array();
$contentAboutQuery = "SELECT * from content_texts where page = 'about_us'";
$result = $conn->query($contentAboutQuery);
while($contentAboutData = $result->fetch_assoc()){
    $contentAboutArr[] = $contentAboutData;
}

?>

<main id="main-content" class="position-relative">
    <section class="page-title position-relative">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="about-us-section primary-bg inner-gap">
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-lg-6">
                    <div class="about-left">
                        <div class="about-left-gun">
                            <img src="assets/images/about-gun.png" class="mix-blend-darken img-fluid" alt="About Gun">
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex flex-column align-items-start gap-3 gap-md-4">
                        <h2 class="sub-title mb-0">About Us</h2>
                        <p><?php echo $contentAboutArr[0]['value']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="our-values-section inner-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="text-align: center;">
                    <h5 class="section-heading values-heading">Our Values</h5>
                </div>
                <div class="col-lg-4">
                    <div class="value-card d-flex align-items-start gap-2 mb-3 mb-xl-4">
                        <div class="flex-shrink-0">
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h6><b>Quality</b></h6>
                            <p><?php echo $contentAboutArr[1]['value']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="value-card d-flex align-items-start gap-2 mb-3 mb-xl-4">
                        <div class="flex-shrink-0">
                            <i class="fa fa-shield-alt" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h6><b>Safety</b></h6>
                            <p><?php echo $contentAboutArr[2]['value']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="value-card d-flex align-items-start gap-2">
                        <div class="flex-shrink-0">
                            <i class="fa fa-headset" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h6><b>Customer Service</b></h6>
                            <p><?php echo $contentAboutArr[3]['value']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include ('partials/auth_footer.php'); ?>
<?php include('partials/footer.php'); ?>
