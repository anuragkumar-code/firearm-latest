<?php
include('../../../config/db.php');

if (isset($_POST['uploadMasterImage'])) {
    $product_id = $_POST['product_id'];
    $encode_id = base64_encode($product_id);

    if (isset($_FILES['masterImage']) && $_FILES['masterImage']['error'] === 0) {
        $file = $_FILES['masterImage'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];

        $uploadDirectory = '../../product_images/';
        
        $newFileName = time() . '_' . rand(100, 999) . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
        $fileDestination = $uploadDirectory . $newFileName;

        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $updateQuery = "UPDATE products SET master_image = ? WHERE id = ?";
            if ($stmt = $conn->prepare($updateQuery)) {
                $stmt->bind_param('si', $newFileName, $product_id);
                if ($stmt->execute()) {
                    header('Location: ../../upload-images.php?product='.$encode_id);
                    exit();
                } else {
                    echo "Error updating master image: " . $stmt->error . "<br>";
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error . "<br>";
            }
        } else {
            echo "Error moving uploaded file.<br>";
        }
    } else {
        echo "No file uploaded or there was an error uploading the file.<br>";
    }

    $conn->close();
} else {
    echo "Form not submitted properly or missing data.<br>";
}
?>
