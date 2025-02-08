<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "profile");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['usernm']; 
    $pass = $_POST['passwrd']; 
    $pass = trim($pass);
    $hashedPassword = md5($pass);
   
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE email = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
       
        if ($hashedPassword === $row['password']) {
            echo "Password is correct!";
            $_SESSION['user'] = $user; 
            header("Location: http://localhost/MIDDLEPRO/LnTMini/LnTMini/AdminDashboard/index.php");
            exit();
        } else {
            echo "Invalid password.".$hashedPassword;
        }
    } else {
        echo "No email found.";
    }
    $stmt->close(); 
}
$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login">
        <h1>USER LOGIN</h1>
        <form action="" method="post"> 
            <div class="loginbar">
                <input type="email" id="username" name="usernm" placeholder="Email" required>
            </div>
            <div class="loginbar">
                <input type="password" id="password" name="passwrd" placeholder="Password" required>
            </div>
            <input type="submit" value="Login" class="btn">
        </form> 
    </div>
</body>
</html>