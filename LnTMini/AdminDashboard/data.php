<?php

include '../class/secure.php';

if(isset($_POST['save'])) {
    $photo = $_FILES["photo"]['name'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    $query = "SELECT * FROM usersnew WHERE email = '$email'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run->num_rows > 0) {
        $_SESSION["error"] = "Email already exists.";
        header("Location: index.php");
        exit;
    }

    $allowed_extensions = array('png', 'jpg', 'jpeg');
    $file_extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        $_SESSION["error"] = "File must be PNG, JPG, or JPEG.";
        header("Location: index.php");
        exit;
    }

    if(file_exists("../images/" . $_FILES["photo"]["name"])) {

        $file = $_FILES["photo"]["name"];
        $_SESSION["error"] = "File already exists. '.$file.'";
        header("Location: index.php");

    }else {
        $query = "INSERT INTO usersnew (photo, first_name, last_name, email, bio) VALUES ('$photo', '$first_name', '$last_name', '$email', '$bio')";
        $query_run = mysqli_query($conn, $query);

        if($query_run) {

            move_uploaded_file($_FILES["photo"]["tmp_name"], "../images/" . $_FILES["photo"]["name"]);
            $_SESSION["success"] = "Profile Added";
            header("Location: index.php");
            
        }else {
            $_SESSION["error"] = "Profile Not Added";
            header("Location: index.php");
        }
    }
    
}

if(isset($_POST['edit_btn'])) {
    $edit_id = $_POST['updateId'];
    $edit_photo = $_FILES['editPhoto']['name'];
    $edit_firstname = $_POST['editFirstname'];
    $edit_lastname = $_POST['editLastname'];
    $edit_email = $_POST['editEmail'];
    $edit_bio = $_POST['editBio'];

    $data_query = "SELECT * FROM usersnew WHERE id='$edit_id'";
    $data_query_run = mysqli_query($conn, $data_query);

    foreach($data_query_run as $user_row) {

        if($edit_photo == NULL) {

            $photo_data = $user_row['photo'];

        }else {
            if($photo_path = "../images/" . $user_row['photo']) {

                unlink($photo_path);
                $photo_data = $edit_photo;
            }
            
        }
    }

    $query = "UPDATE usersnew SET photo='$photo_data', first_name='$edit_firstname', last_name='$edit_lastname', email='$edit_email', bio='$edit_bio' WHERE id='$edit_id'";
    $query_run = mysqli_query($conn, $query);


    if($query_run) {

        if($edit_photo == NULL) {

            $_SESSION["success"] = "Profile Updated with Existing Photo";
            header("Location: index.php");

        }else {

            move_uploaded_file($_FILES["editPhoto"]["tmp_name"], "../images/" . $_FILES["editPhoto"]["name"]);
            $_SESSION["success"] = "Profile Updated";
            header("Location: index.php");

        }


    }else {

        $_SESSION["error"] = "Profile Not Updated";
        header("Location: index.php");
    }
}


if(isset($_POST['delete_btn'])) {

    $delete_id = $_POST['delete_id'];    
    $query = "SELECT photo FROM usersnew WHERE id='$delete_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {

        $row = mysqli_fetch_assoc($query_run);
        $photo_path = "../images/" . $row['photo'];

        if (file_exists($photo_path)) {
            unlink($photo_path);
        }
    }

    $query = "DELETE FROM usersnew WHERE id='$delete_id'";
    $query_run = mysqli_query($conn, $query);    

    if($query_run) {
        
        $query = "SET @i = 0";
        mysqli_query($conn, $query);

        
        $query = "UPDATE usersnew SET id = (@i := @i + 1) ORDER BY id";
        mysqli_query($conn, $query);

        
        $query = "ALTER TABLE usersnew AUTO_INCREMENT = 1";
        mysqli_query($conn, $query);

        $_SESSION["success"] = "Profile Deleted";
        header("Location: index.php");

    }else {

        $_SESSION["error"] = "Profile Not Deleted";
        header("Location: index.php");  
    }
}

if(isset($_POST['view_btn'])) {
    $view_id = $_POST['edit_id'];

    $query = "SELECT * FROM usersnew WHERE id='$view_id'";
    $query_run = mysqli_query($conn, $query);

    foreach($query_run as $row){
        // Tampilkan data profil pengguna
        $photo = $row['photo'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $bio = $row['bio'];
    }
}


?>