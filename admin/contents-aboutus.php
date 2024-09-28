<?php
include('partials/header.php');

$success_about = '';
$success_text = '';

$success_about_type = 0;
$success_text_type = 0;

function updateContentById($page, $section, $key, $value, $id) {
    global $conn; 
    $sql_update = "UPDATE content_texts SET `page` = ?, `section` = ?, `key` = ?, `value` = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('ssssi', $page, $section, $key, $value, $id); 
    return $stmt->execute();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['updateAbout'])) {
        updateContentById('about_us', 'about us', 'text_one', $_POST['aboutus_body'], 7);
        $success_about = "About us text updated successfully!";
        $success_about_type = 1;

    } elseif (isset($_POST['UpdateText'])) {
        updateContentById('about_us', 'about us', 'quality_text', $_POST['quality_text'], 8);
        updateContentById('about_us', 'about us', 'safety_text', $_POST['safety_text'], 9);
        updateContentById('about_us', 'about us', 'customer_service_text', $_POST['customer_service_text'], 10);
        $success_text = "Text updated successfully!";
        $success_text_type = 1;
    }
}


$contentAboutArr = array();
$contentAboutQuery = "SELECT * from content_texts where page = 'about_us'";
$result = $conn->query($contentAboutQuery);
while($contentAboutData = $result->fetch_assoc()){
    $contentAboutArr[] = $contentAboutData;
}

// echo "<pre>"; print_r($contentAboutArr);exit;
?>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Update Banner Text</h6>
                    <?php if($success_about_type == 1){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $success_about; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="mb-2 col-md-12">
                                <label for="aboutus_body" class="form-label"><b>About Us Body<span class="text-danger">*</span></b></label>
                                <textarea required class="form-control" name="aboutus_body" id="aboutus_body"><?php echo $contentAboutArr[0]['value']; ?></textarea>
                            </div>
                        </div>
                        <button style="float: right;margin-bottom:5px" type="submit" class="btn btn-primary" name="updateAbout">Update</button>
                    </form>
                </div>
            </div>

            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Update "Our Values" Text</h6>
                    <?php if($success_text_type == 1){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $success_text; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="mb-2 col-md-12">
                                <label for="quality_text" class="form-label"><b>Quality Text<span class="text-danger">*</span></b></label>
                                <textarea required class="form-control" name="quality_text" id="quality_text"><?php echo $contentAboutArr[1]['value']; ?></textarea>
                            </div>
                            <div class="mb-2 col-md-12">
                                <label for="safety_text" class="form-label"><b>Safety Text<span class="text-danger">*</span></b></label>
                                <textarea required class="form-control" name="safety_text" id="safety_text"><?php echo $contentAboutArr[2]['value']; ?></textarea>
                            </div>
                            <div class="mb-2 col-md-12">
                                <label for="customer_service_text" class="form-label"><b>Customer Service<span class="text-danger">*</span></b></label>
                                <textarea required class="form-control" name="customer_service_text" id="customer_service_text"><?php echo $contentAboutArr[3]['value']; ?></textarea>
                            </div>
                        </div>
                        <button style="float: right;margin-bottom:5px" type="submit" class="btn btn-primary" name="UpdateText">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php include('partials/footer.php'); ?>
