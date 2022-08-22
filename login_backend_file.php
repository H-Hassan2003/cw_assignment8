<?php

session_start();

if (isset($_SESSION["verified"])) {
    header("location: home.php");
}

$SQL_connection = new mysqli("localhost", "root", "", "codeweekend");

if (isset($_POST["user_login_button"])) {


    $user_Email = $_POST["user_Email"];
    $user_Password = $_POST["user_Password"];


    $validation_flag = false;

    if (strlen($user_Email) < 10) {
        $validation_flag = true;
        echo "The Email should be a valid one and at least 10 characters long! <br>";

    }

    if (strlen($user_Password) < 6) {
        $validation_flag = true;
        echo "Choose a strong password, user letters, numbers and charaters! <br>";
    }


    if (!$validation_flag) {

        $user_Password = md5($user_Password);
        
        $SQL_query = " SELECT * FROM users WHERE email = '$user_Email' AND password = '$user_Password'; ";
        $SQL_query_for_user = $SQL_connection->query($SQL_query);
        $SQL_query_for_user_returned = $SQL_query_for_user->fetch_assoc();

        if ($SQL_query_for_user_returned) {
            /// login
            $_SESSION["auth_user"] = [
                "id" => $SQL_query_for_user_returned["id"],
                "name" => $SQL_query_for_user_returned["name"],
                "email" => $SQL_query_for_user_returned["email"],
                "password" => $SQL_query_for_user_returned["id"]
            ];

            $_SESSION["verified"] = true;

            header("location: home.php");

        } else {
            echo "Invalid User Info<br>";
            echo "<a href='http://localhost/codeweekendphp5/login_file.php'>Login</a>";
            exit;
        }
    }


}

if (isset($_GET["logout"])) {
    session_destroy();
    header("location: login_file.php");
}

?>