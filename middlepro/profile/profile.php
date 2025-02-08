<?php
session_start(); 

$conn = mysqli_connect("localhost", "root", "", "profile");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$_SESSION["id"] = "A001"; 
$sessionId = $_SESSION["id"];


$sql = "SELECT * FROM tb_user WHERE id = '$sessionId'"; 
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);
$image = isset($user["image"]) ? $user["image"] : "pp.png"; 

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="hed">
        <nav class="navbar">
            <div class="option">
                <h2>PROFILE</h2>
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="#">PROFILE</a></li>
                </ul>
            </div>
        </nav>

        <div class="profilepic">
    <img src="<?php echo htmlspecialchars($image); ?>" class="pp">
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="profile_image" accept="image/*">
        <input type="submit" value="Upload Image">
    </form>
</div>
    </div>

    <div class="inside">
        <h1 style="text-align: center;"><?php  echo htmlspecialchars(($user["first_name"] ?? "Unknown") . " " . ($user["last_name"] ?? "User"));  ?></h1>
        <h3 style="text-align: center;"><?php echo htmlspecialchars($user["email"] ?? "No Email"); ?></h3>
        <h4 style="text-align: center;">"<?php echo htmlspecialchars($user["bio"] ?? "No bio available."); ?>"</h4>
        <h4 style="text-align: center;">ID: <?php echo htmlspecialchars($sessionId); ?></h4>
        <form action="http://localhost/middlepro/login/login.php">
            <input type="submit" value="logout" class="btn">
        </form>
    </div>
    
</body>
</html>
