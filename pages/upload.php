<?php
    include_once "../utils/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <title>Upload</title>
</head>
<body>
    <?php 
    include_once "../components/navbar.php";

    $uploadOk = 1;

    if(isset($_POST["btnUpload"])) {
        
        if($_FILES["pdf"]["error"] != UPLOAD_ERR_OK) {
            // upload error
            echo "<p>Error uploading file. Error code: " . $_FILES["pdf"]["error"] . "</p>";
        } else {
            // no error occured
            $filename = "../uploads/" . uniqid("pdf_");
            $tmpName = $_FILES["pdf"]["tmp_name"];

            /*$fileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            echo "<p>" . $fileType . "</p>";
            if($fileType != "pdf" && $fileType != "epub") {
                echo "<p>Only Pdf or Epub files are allowed!</p>";
                $uploadOk = 0;
            }*/

            //if($uploadOk == 1) {
                if(move_uploaded_file($tmpName, $filename) == false) {
                    echo "<p>Error moving uploaded file!</p>";
                } else {
                    echo "<p>File uploaded successfully: " . $filename . "</p>";
                }
            //}
        }
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Upload</h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
              
        
        <form enctype="multipart/form-data" method="post" action="upload.php">
            <input type="file" name="pdf" accept="file/pdf">
            <input type="text" name="comment">
            <input type="submit" name="btnUpload" value="Upload">
        </form>

            </div>
        </div>

        <div class="row">
            <div class="col">
                <h2>PDF Preview</h2>
            </div>
        </div>

        <?php 
            $dir = "../uploads/";
            $files = scandir($dir);

            //echo "<pre>" . print_r($files, true) . "</pre>";

            foreach($files as $file) {

                if($file == "." || $file == "..") {
                    continue;
                }

                echo "<div class='col-md'>";
                echo "<iframe src=" . $dir . $file . " width='400px' height='400px' style='border:none' title='Embedded PDF Viewer'";
                echo "</div>";
            }
        ?>
    </div>

    <div class="col-md">
        <iframe src="../uploads/pdf_691cd1a711bca" width="400px" height="400px" frameborder="0"></iframe>
    </div>
    <div class="col-md">
        <iframe src="../uploads/pdf_691cd15d76884" width="400px" height="400px" frameborder="0"></iframe>
    </div>
</body>
</html>