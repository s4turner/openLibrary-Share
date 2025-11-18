<?php
$isAdmin = ($_SESSION["permission"] ?? "") == "admin";
$isLoggedOn = isset($_SESSION["email"]);
$username = $_SESSION["name"] ?? "";
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Open Library Share</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link <?= ($page == "index.php" ? "active" : "") ?>" aria-current="page" href="../pages/home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($page == "cart.php" ? "active" : "") ?>" href="../pages/explore.php">Explore</a>
        </li>     
        <?php if ($isLoggedOn == false) { ?>
        <!-- Registration Accessed over Login Page 
        <li class="nav-item">
          <a class="nav-link <?= ($page == "../pages/registration.php" ? "active" : "") ?>" href="../pages/registration.php">Sign up</a>
        </li>
        -->
        <li class="nav-item">
          <a class="nav-link <?= ($page == "../pages/login.php" ? "active" : "") ?>" href="../pages/login.php">Login</a>
        </li>                       
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link <?= ($page == "about.php" ? "active" : "") ?>" href="about.php">About</a>
        </li>
        <?php if ($isAdmin == true) { ?>
        <li class="nav-item">
          <a class="nav-link <?= ($page == "admin.php" ? "active" : "") ?>" href="admin.php">Admin</a>
        </li>        
        <?php } ?>
        <?php if($isLoggedOn == true) { ?>
          <li class="nav-item">
            <form action="" method="post">
              <a class="nav-link <?= ($page == "../pages/upload.php" ? "active" : "") ?>" href="../pages/upload.php">Upload</a>
            </form>
          </li> 
          <li class="nav-item">
            <form action="" method="post">
              <button type="logout" class="btn btn-primary" name="logout" value="logout">Logout</button>
            </form>
          </li> 
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

<?php if ($isLoggedOn) { ?>

<?php } ?>