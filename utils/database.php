<?php

// model includes
include_once "../model/user.php";
include_once "../model/file.php";

// Database connection
$host = "localhost";
$user = "doeb";
$password = "admin";
$dbname = "openLibShare";

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

    $sql = "select uid, username, email, password, fk_pid from user where email = ?";

    //echo "<pre>SQL: " . $sql . "</pre>";

    $stmt = $dbObj->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $user = new User();
    $stmt->bind_result($user->id, $user->username, $user->email, $user->password, $user->permission);

    
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

// registration
function registration(string $username, string $email, string $password) {
    global $dbObj;
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $dbObj->prepare("insert into user (username, email, password) values (?,?,?)");
    $stmt->bind_param("sss", $username, $email, $hash);
    $success = $stmt->execute();

    if (!$success) {
        error_log("Execute failed: " . $stmt->error);
    }

    $stmt->close();
}

// pdf upload
function uploadPdf(string $filename) {
    global $dbObj;

    $stmt = $dbObj->prepare("insert into file (fk_uid, filename) values (?,?)");

    $stmt->bind_param("is", $_SESSION["uid"], $filename);
    $success = $stmt->execute();
    
    if(!$success) {
        error_log("Execute failed: " . $stmt->error);
    }

    $stmt->close();
}

// Load Data out of DB

function loadAllFiles() {
    global $dbObj;

    $result = $dbObj->query("select * from file");

    while(($f = $result->fetch_assoc()) != null) {
        $file = new File();
        $file->id = intval($f['fid']);
        $file->fk_uid = intval($f['fk_uid']);
        $file->filename = $f['filename'];
        $files[] = $file;
    }
}

function loadAllUsers() {
    global $dbObj;

    $result = $dbObj->query("select * from user order by username");

    $users = [];
    while (($u = $result->fetch_assoc()) != null) {
        $user = new User();
        $user->id = intval($u["uid"]);
        $user->username = $u["username"];
        $user->email = $u["email"];
        $user->permission = $u["fk_pid"];
        $users[] = $user;
    }

    return $users;
}

