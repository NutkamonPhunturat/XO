<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pixelify+Sans&display=swap">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel='stylesheet' href="CSS/SigninSignup.css">

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }

        h1 {
            font-size: 24px;
        }

        p {
            font-size: 20px;
            margin-bottom: 20px;
        }

        a {
            font-size: 16px;
            text-decoration: none;
        }
    </style>

    <title> XO | Game Summary </title>
</head>
<body>

    <div class="container">
        <div class='row align-items-center justify-content-center mt-5'>
            <div class='col-md-8 text-center' style='background-color: #1A1F44; border: 2px solid #4F659C; border-radius: 200px; padding: 20px'>
                <img src="ProjectDot.png" height="16px"> <br><br>
                <h1 style='font-size: 22px; color: #F6D100'> THE WINNER IS </h1> <br>

                <?php
                session_start();

                $winner = isset($_SESSION['winner']) ? $_SESSION['winner'] : null;
                $scoreX = isset($_SESSION['scoreX']) ? $_SESSION['scoreX'] : 0;
                $scoreO = isset($_SESSION['scoreO']) ? $_SESSION['scoreO'] : 0;

                if ($winner) {
                    echo "<p class='pixel' style='font-size: 42px; color: white; text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);'> TEAM $winner! </p>";
                } else {
                    echo "<p class='pixel' style='font-size: 42px; color: white; text-shadow: 0 0 10px rgba(255, 255, 255, 0.8); '> TIE! </p> <br>";
                }

                echo "<p style='font-size: 22px; color: white'> TEAM X : $scoreX TEAM O : $scoreO </p>";
                ?>

            </div>
        </div>    
    </div>

    <br>

    <div class='container'>
        <div class='row'>
            <div class='col-md-12 text-center'>
                <a href="GameAI.php" style = "font-size: 32px;" class="btn btn-primary pixel"> PLAY AGAIN </a>
                <a href="Login.php" style = "font-size: 32px;" class="btn btn-primary pixel"> LOGOUT </a>
            </div>
        </div>
    </div>

</body>

</html>
