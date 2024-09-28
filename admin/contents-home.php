<?php
include('partials/header.php');

$success_home = '';
$success_how = '';
$success_safety = '';

$success_home_type = 0;
$success_how_type = 0;
$success_safety_type = 0;

function updateContentById($page, $section, $key, $value, $id) {
    global $conn; 
    $sql_update = "UPDATE content_texts SET `page` = ?, `section` = ?, `key` = ?, `value` = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param('ssssi', $page, $section, $key, $value, $id); 
    return $stmt->execute();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['updateBanner'])) {
        updateContentById('home_page', 'banner', 'text_one', $_POST['banner_one'], 1);
        updateContentById('home_page', 'banner', 'text_two', $_POST['banner_two'], 2);
        $success_home = "Banner text updated successfully!";
        $success_home_type = 1;

    } elseif (isset($_POST['updateOrderText'])) {
        updateContentById('home_page', 'how_to_order', 'text_one', $_POST['how_to_order_one'], 3);
        updateContentById('home_page', 'how_to_order', 'text_two', $_POST['how_to_order_two'], 4);
        $success_how = "How to order text updated successfully!";
        $success_how_type = 1;

    } elseif (isset($_POST['updateSafetyText'])) {
        updateContentById('home_page', 'safety', 'header', $_POST['safety_header'], 5);
        updateContentById('home_page', 'safety', 'text_one', $_POST['safety_one'], 6);
        $success_safety = "Safety text updated successfully!";
        $success_safety_type = 1;
    }
}


$contentAdminArr = array();
$contentAdminQuery = "SELECT * from content_texts where page = 'home_page'";
$result = $conn->query($contentAdminQuery);
while($contentAdminData = $result->fetch_assoc()){
    $contentAdminArr[] = $contentAdminData;
}


?>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Update Banner Text</h6>
                    <?php if($success_home_type == 1){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $success_home; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="mb-2 col-md-12">
                                <label for="banner_one" class="form-label"><b>Banner Text One<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="banner_one" value="<?php echo $contentAdminArr[0]['value']; ?>" id="banner_one">
                            </div>

                            <div class="mb-2 col-md-12">
                                <label for="banner_two" class="form-label"><b>Banner Text Two<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="banner_two" value="<?php echo $contentAdminArr[1]['value']; ?>" id="banner_two">
                            </div>
                        </div>
                        <button style="float: right;margin-bottom:5px" type="submit" class="btn btn-primary" name="updateBanner">Update</button>
                    </form>
                </div>
            </div>
            
            <div class="col-sm-12 col-xl-12 d-none">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Update How To Order Text</h6>
                    <?php if($success_how_type == 1){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $success_how; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="mb-2 col-md-12">
                                <label for="how_to_order_one" class="form-label"><b>Text One<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="how_to_order_one" value="<?php echo $contentAdminArr[2]['value']; ?>" id="how_to_order_one">
                            </div>

                            <div class="mb-2 col-md-12">
                                <label for="how_to_order_two" class="form-label"><b>Text Two<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="how_to_order_two" value="<?php echo $contentAdminArr[3]['value']; ?>" id="how_to_order_two">
                            </div>
                        </div>
                        <button style="float: right;margin-bottom:5px" type="submit" class="btn btn-primary" name="updateOrderText">Update</button>
                    </form>
                </div>
            </div>

            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Update Safety Text</h6>
                    <?php if($success_safety_type == 1){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $success_safety; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="mb-2 col-md-12">
                                <label for="safety_header" class="form-label"><b>Heading<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="safety_header" value="<?php echo $contentAdminArr[4]['value']; ?>" id="safety_header">
                            </div>

                            <div class="mb-2 col-md-12">
                                <label for="safety_one" class="form-label"><b>Text One<span class="text-danger">*</span></b></label>
                                <textarea required class="form-control" name="safety_one" id="safety_one"><?php echo $contentAdminArr[5]['value']; ?></textarea>
                            </div>
                        </div>
                        <button style="float: right;margin-bottom:5px" type="submit" class="btn btn-primary" name="updateSafetyText">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php include('partials/footer.php'); ?>
