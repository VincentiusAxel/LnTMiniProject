<?php 

include 'header.php'; 
include '../class/secure.php';

?>

<div class="container-fluid">
    <h3 class="font-weight-bold text-primary mb-6 ">View Profile</h3>
    <div class="cardBody">
        <?php 
        if(isset($_POST['view_btn'])){
            $id = $_POST['edit_id'];

            $query = "SELECT * FROM usersnew WHERE id='$id'";
            $query_run = mysqli_query($conn, $query);

            foreach($query_run as $row){
        ?>

        <div class="view-wrapper">
            <div class="image mb-4">
                <?='<img src="../images/'.$row['photo'].'" width="300px" height="300px" alt="pfp">'; ?>
            </div>
            <div class="data">
                <h5>FULL NAME: <?= $row['first_name'] . ' ' . $row['last_name']; ?></h5>
                <h5 >EMAIL: <?= $row['email']; ?></h5>
                <h5 >BIO: <?= $row['bio']; ?></h5>
            </div>
        </div>

        <a href="index.php" class="btn btn-secondary">Back</a>

        <?php
            }
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>