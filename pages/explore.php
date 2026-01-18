<?php 
include_once '../utils/session.php'; 
include_once '../utils/database.php'; 
$page = 'explore.php'; 
$allFiles = loadAllFiles(); // Fetches all shared files
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore - Open Library Share</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .file-card { transition: transform 0.2s; }
        .file-card:hover { transform: scale(1.05); }
        .pdf-preview { height: 200px; border: none; }
    </style>
</head>
<body>
    <?php include_once '../components/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Explore Shared Files</h1>
        <p class="lead">Discover PDFs uploaded by the community.</p>
        
        <div class="row">
            <?php if (empty($allFiles)): ?>
                <div class="col-12">
                    <p class="text-muted">No files available yet. <a href="upload.php">Be the first to upload!</a></p>
                </div>
            <?php else: ?>
                <?php foreach ($allFiles as $file): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card file-card shadow-sm">
                            <iframe src="../uploads/<?php echo htmlspecialchars($file->filename); ?>" class="pdf-preview w-100 rounded-top"></iframe>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($file->filename); ?></h5>
                                <p class="card-text">Uploaded by user ID: <?php echo $file->fk_uid; ?></p>
                                <a href="fileView.php?fileid=<?php echo $file->id; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
