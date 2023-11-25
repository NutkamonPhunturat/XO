<!DOCTYPE html>
<html>

<head>
    <title> XO | Mode Selection </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pixelify+Sans&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel='stylesheet' href="CSS/SigninSignup.css">
</head>

<body>

    <div class="container">

        <div class='row align-items-center justify-content-center mt-5'>
            <div class='col-md-12 text-center' style='background-color: #1A1F44; border: 2px solid #4F659C; border-radius: 100px; padding: 20px'>
                <img src="ProjectDot.png" height = 16px> <br><br>
                <p class='icontxt'> Do you want to play the game in Online or Offline (AI) ? </p> <br>
            </div>
        </div>

    </div>

    <br>

    <div class='container'>
        <div class='row'>
            <div class='col-md-12 text-center'>
                <a href="ReadyAI.php" style = "font-size: 32px;" class = "btn btn-danger pixel"> OFFLINE </a>
                <a href="ReadyPlayer.php" style = "font-size: 32px;" class = "btn btn-success pixel"> ONLINE </a>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

</body>

</html>


<?php
session_start();

include 'conn.php';

$sql = 'SELECT uName, uPwd FROM userInfo';
$result = mysqli_query($conn, $sql);

if (!$result) {
    $error = 'Error retrieving users: ' . mysqli_error($conn);
    // handle error
} elseif (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $_SESSION['username'] = $username;

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['uName'] == $username && $row['uPwd'] == $password) {
            header('Location: Home.php');
            exit();
        }
    }
    echo 'Username or password is incorrect.';
}
?>

