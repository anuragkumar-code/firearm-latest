<?php 
session_start();
include('config/db.php'); 

$adminQuery = "SELECT * from users where type = 'A'";
$result = $conn->query($adminQuery);
$adminData = $result->fetch_assoc();

$mobile = formatMobileNumber($adminData['mobile']);

function formatMobileNumber($mobile) {
    $formatted = substr_replace($mobile, ' ', 3, 0);
    $formatted = substr_replace($formatted, ' ', 7, 0);

    return $formatted;
}


$contentArr = array();
$contentQuery = "SELECT * from content_texts where page = 'home_page'";
$result = $conn->query($contentQuery);
while($contentData = $result->fetch_assoc()){
    $contentArr[] = $contentData;
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Bull Frog Clearance</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/responsive.css" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Reddit+Sans+Condensed:wght@200..900&display=swap" rel="stylesheet">
</head>

<body>
    <style>
        .col-6{
            margin-right: 5px!important;
        }
        .logoSpan {
            font-family: 'Reddit Sans Condensed', sans-serif; 
            font-size: 28px;
            color: white; 
            text-transform: uppercase;
            letter-spacing: 2px; 
            font-weight: 900; 
        }

        @media (max-width: 767px) { 
            .logoSpan {
                font-size: 18px; 
                letter-spacing: 1px;
            }
        }

        .news {
            padding: 0 0;
            display: flex;
            align-items: center;
        }

        .news .col-md-6:first-child {
            flex: 1;
            height: 100%;
            padding: 0; 
        }

        .news img {
            width: 100%;
            height: 100%; 
            object-fit: cover; 
        }

        .how-order {
            padding: 2rem 0;
        }

        .how-order-left img {
            max-width: 100%;
            height: auto;
        }

        .sub-title {
            font-size: 1.5rem;
            color: #333;
        }

        .highlight-text {
            color: #00e0ff; 
            margin-bottom: 1rem;
        }

        .how-it-works-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .how-it-works-list li {
            position: relative;
            padding-left: 2.5rem;
            margin-bottom: 1rem;
            font-size: 1rem;
            line-height: 1.5;
        }



        .primary-btn {
            background-color: #007bff; 
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        .primary-btn i {
            margin-left: 0.5rem;
        }

    </style>
    
    <div class="loader-wrapper position-fixed inset-0 justify-content-center align-items-center z-[9999] h-screen w-full bg-white">
        <div class="loader"></div>
    </div>
    <div class="header-top">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-1 gap-sm-3">
                </div>
                <div>
                    <a class="navbar-brand p-0 d-none d-xl-block" href="index.html">
                        <span class="logoSpan">Bullfrog Gun Clearance</span>
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-4">
                    <?php if (isset($_SESSION['customer_id'])){ ?>
                        <span style="color: white;">
                            <img src="assets/images/user.svg" alt="">
                            <a style="color: white;" href="javascript:void(0)">Welcome, <?php echo $_SESSION['customer_name']; ?></a>
                            
                            <a style="color: white;border-radius:40px" class="btn btn-info" href="functions/auth/logout.php">Logout</a>
                        </span>
                    <?php }else{ ?>
                        <span style="color: white;">
                            <img src="assets/images/user.svg" alt="">
                            <a style="color: white;" href="javascript:void(0)" onclick="showLoginForm()">Log In </a>
                            / 
                            <a style="color: white;" href="javascript:void(0)" onclick="showRegisterForm()">Register</a>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <header>
        <nav class="navbar navbar-expand-xl">
            <div class="container">
                <a class="navbar-brand p-0 m-0 d-xl-none" href="index.php">
                    <!-- <img src="assets/images/logo.png" alt="logo"> -->
                    <span class="logoSpan">Bullfrog Gun Clearance</span>
                </a>
                <div class="collapse navbar-collapse" id="navbar-right">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0);" class="nav-link" onclick="handleShopClick('shop');">Product Items</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="about-us.php">about us</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center gap-2 gap-sm-3">
                    <div class="d-flex align-items-center gap-2" title="Text messsages only">
                        <div class="icon">
                             <i style="color:white" class="fa fa-message"></i>
                        </div>
                        <div class="d-none d-xl-block">
                            <h5><?php echo $mobile; ?> <b>(Text Only)</b></h5>
                        </div>
                    </div>
                    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbar-right" aria-controls="navbar-right" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="toggle-menu-icon"><span></span><span></span><span></span><span></span></span>
                    </button>
                </div>
            </div>
        </nav>
    </header>
    <main id="main-content" class="position-relative">
        <section class="banner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="banner-left">
                            <h6>Welcome to <span>Bullfrog Gun Clearance</span></h6>
                            <h2><?php echo $contentArr[0]['value']; ?></h2>
                            <p><?php echo $contentArr[1]['value']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="how-order primary-bg inner-gap">
            <div class="container">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-6">
                        <div class="how-order-left">
                            <img src="assets/images/gun-lg-1.png" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex flex-column gap-3 gap-md-4">
                            <h2 class="sub-title mb-0 highlight-text">HOW IT WORKS</h2>
                            <ol class="how-it-works-list">
                                <li>
                                    <span><i style="color:black" class="fa-solid fa-user-plus"></i></span> <b>Create an Account:</b> Sign up to get started.
                                </li>
                                <li>
                                    <span><i style="color:black" class="fa-solid fa-check-circle"></i></span> <b>Get Approved:</b> We'll review your account for approval.
                                </li>
                                <li>
                                    <span><i style="color:black" class="fa-solid fa-search"></i></span> <b>Browse Products:</b> Explore our available product items.
                                </li>
                                <li>
                                    <span><i style="color:black" class="fa-solid fa-comment-dots"></i></span> <b>Express Interest:</b> Send an SMS with the details of the product you’re interested in.
                                </li>
                                <li>
                                    <span><i style="color:black" class="fa-solid fa-phone"></i></span> <b>Connect with Us:</b> Our team will contact you to discuss the next steps.
                                </li>
                            </ol>
                            <div class="d-flex align-items-center gap-3 gap-lg-4 d-none">
                                <h3>$775.00</h3>
                                <a href="#" class="primary-btn">BUY NOW <i class="fa-solid fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="new-arrival inner-gap">
            <div class="container">
                <div class="row justify-content-center m-0">
                    <div class="col-sm-6 col-lg-4 col-xl-3 bg-white border-right card-1">
                        <div class="new-arrival-card">
                            <div>
                                <i style="color:#9266ff" class="fa-solid fa-star fa-3x"></i>
                            </div>
                            <div class="arrival-content">
                                <h3>TOP QUALITY</h3>
                                <p class="d-none">Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3 bg-white border-right card-2">
                        <div class="new-arrival-card">
                            <div>
                                <i style="color:#ff9d66" class="fa-solid fa-tag fa-3x"></i>
                            </div>
                            <div class="arrival-content">
                                <h3>COMPETITIVE PRICE</h3>
                                <p class="d-none">Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3 bg-white border-right card-3">
                        <div class="new-arrival-card">
                            <div>
                                <i style="color:#2c96ff" class="fa-solid fa-shield-alt fa-3x"></i>
                            </div>
                            <div class="arrival-content">
                                <h3>SAFETY</h3>
                                <p class="d-none">Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4 col-xl-3 bg-white">
                        <div class="new-arrival-card">
                            <div>
                                <i style="color:#ffb743" class="fa-solid fa-briefcase fa-3x"></i>
                            </div>
                            <div class="arrival-content">
                                <h3>PROFESSIONALISM</h3>
                                <p class="d-none">Lorem ipsum dolor sit amet</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="news inner-gap">
            <div class="container-fluid">
                <div class="row no-gutters align-items-center" style="height: 100%;">
                    <div class="col-md-6" style="height: 100%;">
                        <img src="assets/images/safety.jpg" alt="Safety Commitment" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <div class="title-group text-center">
                            <h2 class="sub-title"><?php echo $contentArr[4]['value']; ?></h2>
                            <p><?php echo $contentArr[5]['value']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>        
    </main>


<?php include ('partials/auth_footer.php'); ?>
<?php include ('partials/footer.php'); ?>