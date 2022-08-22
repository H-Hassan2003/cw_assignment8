<?php

session_start();

if (isset($_SESSION["verified"])) {
    header("location: home.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <style>

        html, body {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            background-image: url("http://localhost/codeweekendphp5/background_images/groceries.jpg");
            background-size: cover;
            background-position: center;
            max-width: 100vw;
            height: 100vh;

        }

        input, button {
            margin-top: 1em;
            background-color: pink;
            padding: 0.5em 1.5em;
            border-radius: 5px;
            border: red 0.5px solid;
            color: darkmagenta;
            font-weight: 600;
            text-align: center;

        }

        label, button {
            color: darkblue;
            font-weight: 600;

        }

        button:hover,
        button:focus {
            cursor: pointer;
            background-color: gray;
            color: white;
            border: none;
        }



    </style>

</head>
<body>
    <main class="container">
        <form action="http://localhost/codeweekendphp5/login_backend_file.php" method="POST">

            <label for="user_Email">Email</label>
            <input type="email" name="user_Email", id="user_Email" required autofocus autocomplete="on">
            <br>

            <label for="user_Password">Password</label>
            <input type="password" name="user_Password", id="user_Password" required>
            <br>

            <button type="submit" name="user_login_button">Login</button>

        </form>
    </main>
</body>
</html>