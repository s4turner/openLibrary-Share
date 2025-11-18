<?php 
    session_start();

    // Debugging Messages
    echo "<pre>GET Content: " . print_r($_GET, true) . "</pre>";
    echo "<pre>POST Content: " . print_r($_POST, true) . "</pre>";
    echo "<pre>Session Content: " . print_r($_SESSION, true) . "</pre>";

    // Login
    $loginErrMsg = "";

    if (isset($_POST["login"])) {
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";

        if ($email == "testusr@localhost.at" && $password == "admin") {
            $_SESSION["email"] = $email;
            $_SESSION["name"] = "Mr. Test User";
            $_SESSION["permission"] = "user";
        } else if($email == "admin@localhost.at" && $password == "admin") {
            $_SESSION["email"] = $email;
            $_SESSION["name"] = "Mr. Test Admin";
            $_SESSION["permission"] = "admin";
        } else {
            $loginErrMsg = "Invalid Credentials!";
        }
    }

    // close session if logout is set
    if (isset($_POST["logout"])) {
        $_SESSION = [];
    }
?>