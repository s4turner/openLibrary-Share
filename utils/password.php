<?php 

$password = "admin";
echo "Plain Password: " . $password . "\n";

$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed Password: " . $hash . "\n";

// very outdated way (do not use in production)
$md5Hash = md5($password);
echo "MD5 Hashed Password: " . $md5Hash . "\n";

//$2y$10$xh6Ic86FbJIpEqitZem/jOXBg8mJgpB6oKWTx8LcXe3vdmJPWD98C

if (password_verify("admin", $hash)) {
    echo "Password is valid!\n";
} else {
    echo "Invalid password.\n";
}





