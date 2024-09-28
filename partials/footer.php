<?php 
$adminQuery = "SELECT * from users where id='1'";
$result = $conn->query($adminQuery);
$adminData = $result->fetch_assoc();

function ensureUrlScheme($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "https://" . $url;
    }
    return $url;
}

?>

<footer>
    <div class="container">
        <div class="footer-top">
            <div class="row gy-4 justify-content-between">
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 footer-about">
                    <a href="index.php" class="footer-brand mb-4 d-block">
                        <span class="logoSpan" style="color: white;">Bullfrog Gun Clearance</span>

                    </a>
                    <p class="mb-3 mb-xl-4"><?php echo $contentArr[1]['value']; ?></p>
                </div>
                
                <div class="col-sm-6 col-lg-4 col-xl-3 footer-link-wrapper">
                    <h3>CONTACT INFO</h3>
                    <p class="mb-3 mb-md-4"><span>SMS:</span> <?php echo $mobile; ?> <b>(TEXT ONLY)</b></p>
                    <a class="btn btn-primary" style="color:white;font-size:smaller" href="admin/index.php"><i class="fa fa-sign-in"></i> Admin</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript Libraries -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/swiper-bundle.min.js"></script>
<script src="assets/js/custom.js"></script>
<script>
    // swiper
    const swiperBanner = new Swiper('.testimonial-swiper', { 
        slidesPerView: 1,
        loop: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
</body>

</html>