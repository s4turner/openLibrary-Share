<?php
    include_once "../utils/session.php";
    //include_once "../utils/database.php";
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
?>
   <div class="container">
        <h1>Login</h1>

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
                    <button type="submit" class="btn btn-primary" name="login" value="login">Login</button>
                </div>
            </div>
        </form>

        <div class="mb-3 row">
            <label for="signup-Link">No Account yet? Create Free Account</label>
            <a class="nav-link" href="registration.php">Signup</a>
        </div>

    <?php 
        }
        if(!empty($loginErrMsg)) {
            echo "<div class='alert alert-danger'>$loginErrMsg</div>";
        }
    ?>
   </div>
</body>
</html>