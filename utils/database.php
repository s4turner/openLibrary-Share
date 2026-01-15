<?php

include_once "model/user.php";

$host = "localhost";
$user = "doeb";
$password = "admin";
$dbname = "openLibShare";

// check if "mysqli" is enabled?
// phpinfo();



$dbObj = new mysqli($host, $user, $password, $dbname);

if ($dbObj->connect_error) {
    die("<strong>DB-Connection failed</strong><br>Reason: " 
            . $dbObj->connect_error);
} else {
    // nice for debugging
    echo "<pre>Connected successfully</pre>";
}

function login(string $email, string $password) {

    global $dbObj;

    $sql = "select uid, username, email, password from user where email = ?";

    echo "<pre>SQL: " . $sql . "</pre>";

    $stmt = $dbObj->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $user = new User();
    $stmt->bind_result($user->id, $user->username, $user->email, $user->password);

    
    if ($stmt->fetch()) {
        echo "<pre>got into fetch method!</pre>";
        print_r($user);

        if (password_verify($password, $user->password)) {
            //echo "<pre>Password match!</pre>";
            return $user;
        } else {
            // passwords do not match
            echo "<pre>Password do not match!</pre>";
            return null;
        }
 
    } else {
        echo "<pre>empty user fetch failed!</pre>";
        return null;
    }
}

/*
function login2(string $email, string $password)
{

    global $dbObj;

    $sql = "select uid, username, email, password from user where email = '$email'";

    echo "<pre>SQL: " . $sql . "</pre>";
    $result = $dbObj->query($sql);

    $result = $dbObj->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user = new User();
        $user->id = $row["uid"];
        $user->username = $row["username"];
        $user->email = $row["email"];
        $user->password = $row["password"];
        return $user;
    } else {
        return null;
    }
}*/