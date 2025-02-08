<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "profile");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Assuming the session ID is set after user login
$sessionId = $_SESSION["id"];

if ($_FILES["profile_image"]["error"] == UPLOAD_ERR_OK) {
    $target_dir = "uploads/"; 
    $imageFileType = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));

    // Check if the uploaded file is an image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check !== false) {
        // Check file size (limit to 5MB)
        if ($_FILES["profile_image"]["size"] <= 5000000) {
            // Allow certain file formats
            if (in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                // Resize and crop the image
                $resizedImage = resizeAndCropImage($_FILES["profile_image"]["tmp_name"], 300, 300); // Resize to 300x300 pixels

                if ($resizedImage) {
                    $newFileName = $target_dir . uniqid() . '.' . $imageFileType; 
                   
                    if (imagejpeg($resizedImage, $newFileName)) {
                        
                        $sql = "UPDATE tb_user SET image = '$newFileName' WHERE id = '$sessionId'";
                        if (mysqli_query($conn, $sql)) {
                            echo "The file " . htmlspecialchars(basename($_FILES["profile_image"]["name"])) . " has been uploaded.";
                        } else {
                            echo "Error updating record: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Sorry, there was an error saving your file.";
                    }
                    imagedestroy($resizedImage); 
                } else {
                    echo "Failed to resize and crop the image.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "Sorry, your file is too large.";
        }
    } else {
        echo "File is not an image.";
    }
} else {
    echo "Error uploading file.";
}

mysqli_close($conn);
exit();

/**
 * Resize and crop an image to a square.
 *
 * @param string $filePath Path to the image file.
 * @param int $width Desired width.
 * @param int $height Desired height.
 * @return resource|false Resized image resource or false on failure.
 */
function resizeAndCropImage($filePath, $width, $height) {
    // Load the image
    $image = imagecreatefromstring(file_get_contents($filePath));
    if (!$image) {
        return false; // Return false if image loading fails
    }

    // Get original dimensions
    $originalWidth = imagesx($image);
    $originalHeight = imagesy($image);

    // Calculate the scaling factor
    $scale = min($width / $originalWidth, $height / $originalHeight);
    $newWidth = (int)($originalWidth * $scale);
    $newHeight = (int)($originalHeight * $scale);

    // Create a new true color image
    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

    // Create a square image for cropping
    $squareImage = imagecreatetruecolor($width, $height);
    $transparentColor = imagecolorallocatealpha($squareImage, 0, 0, 0, 127);
    imagefill($squareImage, 0, 0, $transparentColor);
    imagealphablending($squareImage, false);
    imagesavealpha($squareImage, true);

    // Calculate the position to crop the center of the resized image
    $cropX = ($newWidth - $width) / 2;
    $cropY = ($newHeight - $height) / 2;

    // Copy the cropped image into the square image
        // Copy the cropped image into the square image
        imagecopyresampled($squareImage, $resizedImage, 0, 0, $cropX, $cropY, $width, $height, $width, $height);

        // Free up memory
        imagedestroy($resizedImage);
    
        return $squareImage;
    }
    