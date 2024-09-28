<?php 
include('config/db.php');

session_start();

$current_page = basename($_SERVER['PHP_SELF']);

if (!isset($_SESSION['customer_id'])) {
    header('location:index.php');
    exit(); 
}  

$adminQuery = "SELECT * from users where type = 'A'";
$result = $conn->query($adminQuery);
$adminData = $result->fetch_assoc();

$mobile = formatMobileNumber($adminData['mobile']);

function formatMobileNumber($mobile) {
    $formatted = substr_replace($mobile, ' ', 3, 0);
    $formatted = substr_replace($formatted, ' ', 7, 0);

    return $formatted;
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
    <link rel="stylesheet" href="assets/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css" type="text/css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <link rel="stylesheet" href="assets/css/responsive.css" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <style>
        .col-6{
            margin-right: 5px!important;
        }

        .logoSpan {
            font-family: 'Reddit Sans Condensed', sans-serif; 
            font-size: 28px;
            color: black; 
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
    </style>
    <div
        class="loader-wrapper position-fixed inset-0 justify-content-center align-items-center z-[9999] h-screen w-full bg-white">
        <div class="loader"></div>
    </div>
    <div class="header-top header-top-light position-relative">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <a class="navbar-brand p-0 d-none d-xl-block" href="index.php">
                        <!-- <img src="assets/images/logo-black.png" alt="logo"> -->
                        <span class="logoSpan">Bullfrog Gun Clearance</span>
                    </a>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-4">
                    <?php if (isset($_SESSION['customer_id'])){ ?>
                        <span style="color: black;">
                            <img src="assets/images/user.svg" alt="">
                            <a style="color: black;" href="javascript:void(0)">Welcome, <?php echo $_SESSION['customer_name']; ?></a>
                            
                            <a style="color: black;border-radius:40px" class="btn btn-info" href="functions/auth/logout.php">Logout</a>
                        </span>
                    <?php }else{ ?>
                        <span style="color: black;">
                            <img src="assets/images/user.svg" alt="">
                            <a style="color: black;" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#loginPopUp">Log In </a>
                            / 
                            <a style="color: black;" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#registerPopUp">Register</a>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <header class="header-light">
        <nav class="navbar navbar-expand-xl">
            <div class="container">
                <a class="navbar-brand p-0 m-0 d-xl-none" href="index.php">
                    <span class="logoSpan">Bullfrog Gun Clearance</span>
                </a>
                <div class="collapse navbar-collapse" id="navbar-right">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="product.php">Product Items</a>
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