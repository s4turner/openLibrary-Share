<?php
    include_once "../utils/session.php";
    include_once "../utils/database.php";
    
    // Handle tag operations
    $selectedFileId = null;
    $selectedFile = null;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'add_tag' && isset($_POST['file_id']) && isset($_POST['tag_value'])) {
                addTagToFile(intval($_POST['file_id']), htmlspecialchars($_POST['tag_value']));
            } elseif ($_POST['action'] === 'delete_tag' && isset($_POST['file_id']) && isset($_POST['tag_id'])) {
                deleteTagFromFile(intval($_POST['tag_id']));
            } elseif ($_POST['action'] === 'delete_file' && isset($_POST['file_id']) && isset($_POST['filename'])) {
                $filename = htmlspecialchars($_POST['filename']);
                
                deleteAllTagsFromFile(intval($_POST['file_id']));
                deleteFileByName($filename);
                // Delete the physical file
                $uploadDir = "../uploads/";
                $filePath = $uploadDir . $filename;
                if(file_exists($filePath)) {
                    unlink($filePath);
                }
                $selectedFileId = null;
                $selectedFile = null;
            }
        }
    }
    
    // Get selected file from query parameter
    if (isset($_GET['file_id'])) {
        $selectedFileId = intval($_GET['file_id']);
        $userFiles = loadUploadsByUser($_SESSION["uid"]);
        foreach ($userFiles as $f) {
            if ($f->id === $selectedFileId) {
                $selectedFile = $f;
                break;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/fileView.css">
    <title>File View</title>
</head>
<body>
<?php 
    include_once "../components/navbar.php";
?>    
<div class="container-fluid">
    <h1>My Files</h1>
    
    <div class="file-view-container">
        <!-- File List -->
        <div class="file-list-section">
            <h3>Your Files</h3>
            <div class="files-grid">
                <?php 
                    $dir = "../uploads/";
                    $files = loadUploadsByUser($_SESSION["uid"]);

                    foreach ($files as $f) {
                        $isSelected = ($selectedFileId === $f->id) ? 'selected' : '';
                        echo "<div class='file-card $isSelected'>";
                        echo "<iframe src='" . $dir . $f->filename . "' width='100%' height='200px' style='border:none; border-radius: 8px; pointer-events: none;' title='PDF Preview'></iframe>";
                        echo "<a href='fileView.php?file_id=" . $f->id . "' class='file-link'>";
                        echo "<div class='file-name'>" . htmlspecialchars($f->filename) . "</div>";
                        echo "</a>";
                        echo "</div>";
                    }
                ?>
            </div>
        </div>

        <!-- Detailed View -->
        <div class="file-details-section">
            <?php if ($selectedFile): ?>
                <div class="details-header">
                    <div class="header-top">
                        <div class="header-info">
                            <h2><?php echo htmlspecialchars($selectedFile->filename); ?></h2>
                            <p class="file-id">File ID: <?php echo $selectedFile->id; ?></p>
                        </div>
                        <form method="POST" class="delete-file-form">
                            <input type="hidden" name="action" value="delete_file">
                            <input type="hidden" name="file_id" value="<?php echo $selectedFile->id; ?>">
                            <input type="hidden" name="filename" value="<?php echo htmlspecialchars($selectedFile->filename); ?>">
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this file? This action cannot be undone.');">Delete File</button>
                        </form>
                    </div>
                </div>

                <!-- PDF Viewer -->
                <div class="pdf-viewer-container">
                    <iframe src="<?php echo $dir . $selectedFile->filename; ?>" 
                            width="100%" 
                            height="600px" 
                            style='border: 1px solid #ddd; border-radius: 8px;' 
                            title='PDF Viewer'></iframe>
                </div>

                <!-- Tags Management -->
                <div class="tags-management-section">
                    <h3>Tags</h3>
                    
                    <!-- Add Tag Form -->
                    <form method="POST" class="add-tag-form">
                        <input type="hidden" name="action" value="add_tag">
                        <input type="hidden" name="file_id" value="<?php echo $selectedFile->id; ?>">
                        <div class="input-group">
                            <input type="text" 
                                   name="tag_value" 
                                   class="form-control" 
                                   placeholder="Enter new tag..." 
                                   required>
                            <button type="submit" class="btn btn-primary">Add Tag</button>
                        </div>
                    </form>

                    <!-- Tags List -->
                    <div class="tags-list">
                        <?php 
                            $tags = loadTagsByFileWithId($selectedFile->id);
                            if (empty($tags)) {
                                echo "<p class='no-tags'>No tags yet. Add one above!</p>";
                            } else {
                                foreach ($tags as $tag) {
                                    echo "<div class='tag-item'>";
                                    echo "<span class='tag-value'>" . htmlspecialchars($tag['value']) . "</span>";
                                    echo "<form method='POST' class='delete-tag-form'>";
                                    echo "<input type='hidden' name='action' value='delete_tag'>";
                                    echo "<input type='hidden' name='file_id' value='" . $selectedFile->id . "'>";
                                    echo "<input type='hidden' name='tag_id' value='" . $tag['tid'] . "'>";
                                    echo "<button type='submit' class='btn btn-sm btn-danger'>Delete</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            }
                        ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="no-selection">
                    <p>Select a file from the list to view details and manage tags</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcVqwpEV7tZrpomMgA" crossorigin="anonymous"></script>
</body>
</html>