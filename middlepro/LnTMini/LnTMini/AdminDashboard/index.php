<?php 
include 'header.php'; 
include '../class/secure.php';

?>

        <!-- Modal -->
        <div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="data.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label> Photo </label>
                                <input type="file" name="photo" id="photo" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label> First Name </label>
                                <input type="text" name="firstname" class="form-control" placeholder="Enter your first name" required>
                                <small class="error_email" style="color: red;"></small>
                            </div>
                            <div class="form-group">
                                <label> Last Name </label>
                                <input type="text" name="lastname" class="form-control" placeholder="Enter your last name" required>
                            </div>
                            <div class="form-group">
                                <label> Email </label>
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>                            </div>
                            <div class="form-group">
                                <label> Bio </label>
                                <input type="text" name="bio" class="form-control" placeholder="Enter your bio">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="save" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start">
            <button type="button" name="add-btn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#adduser">
                Add New Profile
            </button>
        </div>
    <?php 

    if(isset($_SESSION["success"]) && $_SESSION["success"] != '') {
        echo '<div class="alert alert-success">' . $_SESSION["success"] . '</div>';
        unset($_SESSION["success"]);
    }

    if(isset($_SESSION["error"]) && $_SESSION["error"] != '') {
        echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
        unset($_SESSION["error"]);
    }


    ?>
        
        <!--Table-->

    <?php
    $query = "SELECT * FROM usersnew";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        ?>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Photo</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Bio</th>
                <th scope="col">Action</th>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <?php
                while($row = mysqli_fetch_assoc($query_run)) {
            ?>
                <tr>
                    <td> <?= $row['id']; ?> </td>
                    <td><?='<img src="../images/'.$row['photo'].'" width="50px" height="50px" alt="pfp">'; ?></td>
                    <td> <?= $row['first_name'] . ' ' . $row['last_name']; ?> </td>
                    <td> <?= $row['email']; ?> </td>
                    <td> <?= $row['bio']; ?> </td>
                    <td>
                        <form action="view.php" method="POST">
                            <input type="hidden" name="edit_id" value="<?= $row['id']; ?>">
                            <button type="submit" name="view_btn" class="btn btn-primary">View</button>
                        </form>
                    </td>
                    <td>
                        <form action="edit.php" method="POST">
                            <input type="hidden" name="edit_id" value="<?= $row['id']; ?>">
                            <button type="submit" name="edit_btn" class="btn btn-secondary">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="data.php" method="POST">
                            <input type="hidden" name="delete_id" value="<?= $row['id']; ?>">
                            <button type="submit" name="delete_btn" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
                
                }
            ?>
            </tbody>
        </table>
    <?php
            
    }else{
        echo "No Record Found";
    }
    ?>

<?php include 'footer.php'; ?>