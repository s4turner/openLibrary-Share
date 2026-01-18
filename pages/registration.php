<?php
    include_once "../utils/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>

<?php 
    include_once "../components/navbar.php";

    $signUpOk = false;

    // setting values for name, email, password
    $username = $_POST["username"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if(isset($_POST["signup"])) {
        $errors = [];
        if (empty($username)) {
            $errors[] = "<strong>Warning: username is empty!!</strong>";
        }     
        if (empty($email)) {
            $errors[] = "<strong>Warning: Email is empty!!</strong>";
        }        
        if (strlen($password) < 6) {
            $errors[] = "<strong>Warning: Password less than 6 chars!!</strong>";
        }

        if(!empty($errors)) {
            foreach($errors as $err) {
                echo "<p>" . $err . "</p>";
            }
        } else {
            registration($username, $email, $password);
            $signUpOk = true;
        }
    }

?>
   <div class="container">
        <h1>Signup</h1>

        <?php if($signUpOk) { ?>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <p>Welcome to Open Library Share <?= $username ?>.</p>
                </div>
            </div>
        <?php } else { ?>
        <form action="" method="post">
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <label for="username" class="col-sm-2 col-form-label">username</label>
                    <input type="username" class="form-control" id="username" name="username">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" name="signup" value="signup">Signup</button>
                </div>
            </div>
        </form>
        <?php } ?>

    <?php 
        //if(!empty($loginErrMsg))
    ?>
   </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcVqwpEV7tZrpomMgA" crossorigin="anonymous"></script>
</body>
</html>