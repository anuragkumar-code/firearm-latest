<?php
include('../../../config/db.php');

if (isset($_POST['uploadChildImage'])) {
    $product_id = $_POST['child_product_id'];
    $uploadDirectory = '../../product_images/';
 
    if (isset($_FILES['childImages']) && !empty($_FILES['childImages']['name'][0])) {
        $files = $_FILES['childImages'];
        $fileCount = count($files['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = $files['name'][$i];
            $fileTmpName = $files['tmp_name'][$i];
            $fileError = $files['error'][$i];
            $fileSize = $files['size'][$i];
            
            $newFileName = time() . '_' . rand(100, 999) . '_' . $fileName;
            $fileDestination = $uploadDirectory . $newFileName;

            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                
                $insertQuery = "INSERT INTO products_images (product_id, image) VALUES (?, ?)";
                if ($stmt = $conn->prepare($insertQuery)) {
                    $stmt->bind_param('is', $product_id, $newFileName);
                    if (!$stmt->execute()) {
                        echo "Error inserting image into database: " . $stmt->error . "<br>";
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $conn->error . "<br>";
                }
            } else {
                echo "Error moving uploaded file: " . $fileName . "<br>";
            }
        }
        // echo "success";
        header('Location: ../../upload-images.php?product=' . base64_encode($product_id));
        exit();
    } else {
        echo "No files were uploaded or there was an error uploading the files.<br>";
    }

    $conn->close();
} else {
    echo "Form not submitted properly or missing data.<br>";
}
?>
