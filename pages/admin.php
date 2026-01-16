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
    <title>Admin Panel</title>
</head>
<body>
<?php 
    include_once "../components/navbar.php";
?>    
<h1>Admin Page</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Permission</th>
    </tr>

    <?php 
        $users = loadAllUsers();

        foreach ($users as $u) {
            echo "<tr><td>" . $u->id . "</td>"
                . "<td>" . htmlspecialchars($u->username) . "</td>"
                . "<td>" . htmlspecialchars($u->email) . "</td>"
                . "<td>" . $u->permission . "</td>"
                . "</tr>";
        }
    ?>
</table>

<table>
    <tr>
        <th>File ID</th>
        <th>User ID</th>
        <th>Filename</th>
        <th>Permission</th>
    </tr>

    <?php 
        $files = loadAllPdfsAndTags();

        foreach ($files as $f) {
            echo "<tr><td>" . $f->id . "</td>"
                . "<td>" . $f->fk_uid . "</td>"
                . "<td>" . htmlspecialchars($f->filename) . "</td>"
                . "</tr>";
        }
    ?>
</table>

<div class="row">
    <?php 
        $dir = "../uploads/";
        $files = scandir($dir);

        print_r($files);

        foreach($files as $f) {
            if($f == "." || $f == "..") {
                continue;
            }

            echo "<div class='col-6'>";
            //echo "<div>" . $f . " =&gt; " . mime_content_type($dir . $f) . "</div>";
            echo "<iframe src=" . $dir . $f . " width='400px' height='400px' style='border:none' title='Embedded PDF Viewer'></iframe>";
            echo "</div>";
        }
    ?>
</div>

</body>
</html>