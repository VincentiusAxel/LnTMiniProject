<?php 

include 'header.php'; 
include '../class/secure.php';

?>

<div class="container-fluid">
    <h3 class="font-weight-bold text-primary mb-4 ">Edit Profile</h3>
    <div class="cardBody">

    <?php 
    if(isset($_POST['edit_btn'])){
        $id = $_POST['edit_id'];

        $query = "SELECT * FROM usersnew WHERE id='$id'";
        $query_run = mysqli_query($conn, $query);

        foreach($query_run as $row){
    ?>

        <form action="data.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="updateId" value="<?= $row['id']; ?>">
            <div class="form-group">
                <label> Photo </label>
                <input type="file" name="editPhoto" id="photo" value="<?= $row['photo']; ?>" class="form-control mb-2" >
            </div>
            <div class="form-group">
                <label> First Name </label>
                <input type="text" name="editFirstname" value="<?= $row['first_name']; ?>" class="form-control mb-2" placeholder="Enter your first name" >
                <small class="error_email" style="color: red;"></small>
            </div>
            <div class="form-group">
                <label> Last Name </label>
                <input type="text" name="editLastname" value="<?= $row['last_name']; ?>" class="form-control mb-2" placeholder="Enter your last name" >
            </div>
            <div class="form-group">
                <label> Email </label>
                <input type="email" name="editEmail" value="<?= $row['email']; ?>" class="form-control mb-2" placeholder="Enter your email" >                            </div>
            <div class="form-group">
                <label> Bio </label>
                <input type="text" name="editBio" value="<?= $row['bio']; ?>" class="form-control mb-4" placeholder="Enter your bio" >
            </div>

            <a href="index.php" class="btn btn-danger">Cancel</a>
            <button type="submit" name="edit_btn" class="btn btn-primary">Update</button>
        </form>

    <?php
        }
    }

    ?>
    </div>
</div>

<?php include 'footer.php'; ?>