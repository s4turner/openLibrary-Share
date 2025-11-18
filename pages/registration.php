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
    $firstname = $_POST["firstname"] ?? "";
    $surname = $_POST["surname"] ?? "";
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";

    if(isset($_POST["signup"])) {
        $errors = [];
        if (empty($firstname)) {
            $errors[] = "<strong>Warning: Firstname is empty!!</strong>";
        }
        if (empty($surname)) {
            $errors[] = "<strong>Warning: Surname is empty!!</strong>";
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
            $signUpOk = true;
        }
    }

?>
   <div class="container">
        <h1>Signup</h1>

        <?php if($signUpOk) { ?>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <p>Welcome to Open Library Share <?= $firstname . " " . $surname ?>.</p>
                </div>
            </div>
        <?php } else { ?>
        <form action="" method="post">
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <label for="firstname" class="col-sm-2 col-form-label">Firstname</label>
                    <input type="firstname" class="form-control" id="firstname" name="firstname">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <label for="surname" class="col-sm-2 col-form-label">Surname</label>
                    <input type="surname" class="form-control" id="surname" name="surname">
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
</body>
</html>