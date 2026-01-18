<?php
    include_once "../utils/session.php";
    include_once "../utils/database.php";
    
    // Handle user actions
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'delete_user' && isset($_POST['user_id'])) {
                deleteUser(intval($_POST['user_id']));
            } elseif ($_POST['action'] === 'delete_file' && isset($_POST['filename'])) {
                $filename = htmlspecialchars($_POST['filename']);

                $fileId = getFileIdByName($filename);
                
                // Delete all tags associated with the file
                if($fileId) {
                    deleteAllTagsFromFile($fileId);
                }
                
                // Delete file from database
                deleteFileByName($filename);
                
                // Delete physical file
                $uploadDir = "../uploads/";
                $filePath = $uploadDir . $filename;
                if(file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
    }
    
    // Function to translate permission ID to label
    function getPermissionLabel($permissionId) {
        $permissions = [
            1 => 'Admin',
            2 => 'User'
        ];
        return isset($permissions[$permissionId]) ? $permissions[$permissionId] : 'Unknown';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin Panel</title>
</head>
<body>
<?php 
    include_once "../components/navbar.php";
?>    
<h1>Admin Page</h1>

<div class="container">
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Permission</th>
        <th>Actions</th>
    </tr>

    <?php 
        $users = loadAllUsers();

        foreach ($users as $u) {
            $permissionLabel = getPermissionLabel($u->permission);
            echo "<tr>";
            echo "<td>" . $u->id . "</td>";
            echo "<td>" . htmlspecialchars($u->username) . "</td>";
            echo "<td>" . htmlspecialchars($u->email) . "</td>";
            echo "<td><span class='permission-badge permission-" . $u->permission . "'>" . $permissionLabel . "</span></td>";
            echo "<td class='actions-cell'>";
            
            // Delete user form
            echo "<form method='POST' class='delete-form'>";
            echo "<input type='hidden' name='action' value='delete_user'>";
            echo "<input type='hidden' name='user_id' value='" . $u->id . "'>";
            echo "<button type='submit' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this user? This action cannot be undone.');\">Delete</button>";
            echo "</form>";
            
            echo "</td>";
            echo "</tr>";
        }
    ?>
</table>
</div>


<div class="container">
    <table>
        <tr>
            <th>Filename</th>
            <th>Tags</th>
            <th>Actions</th>
        </tr>
    
    <?php 
        $dir = "../uploads/";
        $files = scandir($dir);

        foreach($files as $f) {
            if($f == "." || $f == "..") {
                continue;
            }

            // Get all files from database to find matching file
            $dbFiles = loadAllFiles();
            $fileId = null;
            foreach($dbFiles as $dbFile) {
                if($dbFile->filename === $f) {
                    $fileId = $dbFile->id;
                    break;
                }
            }

            echo "<tr>";
            echo "<td>";
            echo "<iframe src='" . $dir . $f . "' width='100px' height='150px' style='border:none; border-radius: 4px;' title='PDF Preview'></iframe>";
            echo "<div style='margin-top: 8px;'>" . htmlspecialchars($f) . "</div>";
            echo "</td>";
            
            // Tags column
            echo "<td>";
            if($fileId) {
                $tags = loadTagsByFileWithId($fileId);
                if(!empty($tags)) {
                    $tagValues = array_map(function($tag) { return htmlspecialchars($tag['value']); }, $tags);
                    echo implode(", ", $tagValues);
                } else {
                    echo "<span class='no-tags'>No tags</span>";
                }
            } else {
                echo "<span class='no-tags'>No tags</span>";
            }
            echo "</td>";
            
            // Delete button
            echo "<td class='actions-cell'>";
            echo "<form method='POST' class='delete-form'>";
            echo "<input type='hidden' name='action' value='delete_file'>";
            echo "<input type='hidden' name='filename' value='" . htmlspecialchars($f) . "'>";
            echo "<button type='submit' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete this file? This action cannot be undone.');\">Delete</button>";
            echo "</form>";
            echo "</td>";
            
            echo "</tr>";
        }
    ?>

    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcVqwpEV7tZrpomMgA" crossorigin="anonymous"></script>
</body>
</html>