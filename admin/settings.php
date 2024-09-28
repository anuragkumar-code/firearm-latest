<?php 
include('partials/header.php');

$error = '';
$error_type = 0;

$success_type = 0;
$success = '';

if (isset($_POST['updatePassword'])) {

    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $userId = 1;

    $fetchPasswordQuery = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($fetchPasswordQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $currentDbPassword = $user['password'];

        if (md5($currentPassword) !== $currentDbPassword) {
            $error_type = 1;
            $error = "Old password is incorrect.";
        } elseif ($newPassword !== $confirmPassword) {
            $error_type = 1;
            $error = "New password and confirmation do not match.";
        } else {

            $encryptedPassword = md5($newPassword);

            $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("si", $encryptedPassword, $userId);
            if ($updateStmt->execute()) {
                $error_type = 2;
                $error = "Password updated succesfully.";
            }else{
                $error_type = 1;
                $error = "Something went wrong !";
            }
            

        }
    } 

    echo "<script>if ( window.history.replaceState ) {  window.history.replaceState( null, null, window.location.href ); }</script>";

}

if (isset($_POST['updateAddress'])) {
    $info_email = $_POST['info_email'];
    $mobile = $_POST['mobile'];
    $addressOne = $_POST['addressOne'];
    $addressTwo = $_POST['addressTwo'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pincode = $_POST['pincode'];

    $updateAddress = "UPDATE `users` SET `info_email`= ? ,`mobile`= ?  WHERE id = '1'";

    $stmt = $conn->prepare($updateAddress);
    $stmt->bind_param("ss",$info_email,$mobile);
    $stmt->execute();

    $success_type = 1;
    $success = 'Details updated successfully.';

    echo "<script>if ( window.history.replaceState ) {  window.history.replaceState( null, null, window.location.href ); }</script>";

    
}


$adminQuery = "SELECT * from users where type = 'A'";
$result = $conn->query($adminQuery);
$adminData = $result->fetch_assoc();

?>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Update Contact</h6>
                    <?php if($success_type == 1){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <form action="" method="post" class="mb-4">
                        <div class="row">
                        <div class="mb-2 col-md-4">
                                <label for="info_email" class="form-label"><b>Info Email<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="info_email" value="<?php echo $adminData['info_email']; ?>" id="info_email">
                            </div>
                            <div class="mb-2 col-md-4">
                                <label for="mobile" class="form-label"><b>Mobile<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="mobile" value="<?php echo $adminData['mobile']; ?>" id="mobile">
                            </div>
                        </div>
                        <button style="float: right;margin-bottom:5px" type="submit" class="btn btn-primary" name="updateAddress">Update</button>
                    </form>
                </div>
            </div>

            <div class="col-sm-12 col-xl-12">
                <div class="rounded h-100 p-4" style="background:#FFDBD3">
                    <h6 class="mb-4">Change Password</h6>
                    <?php if($error_type == 1){ ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <?php if($error_type == 2){ ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i><?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="mb-2 col-md-4">
                                <label for="currentPassword" class="form-label"><b>Old Password<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="currentPassword" id="currentPassword">
                            </div>
                            <div class="mb-2 col-md-4">
                                <label for="newPassword" class="form-label"><b>New Password<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="newPassword" id="newPassword">
                            </div>
                            <div class="mb-2 col-md-4">
                                <label for="confirmPassword" class="form-label"><b>Confirm Password<span class="text-danger">*</span></b></label>
                                <input required type="text" class="form-control" name="confirmPassword" id="confirmPassword">
                            </div>
                            
                        </div>
                        <button style="float: right;margin-bottom:5px" type="submit" class="btn btn-primary" name="updatePassword">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php include('partials/footer.php'); ?>
