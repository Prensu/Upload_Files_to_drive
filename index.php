<?php
if (!session_id()) {
    session_start();
}
include_once 'config.php';

$status = $statusMsg = '';
if (!empty($_SESSION['status_response'])) {
    $status_response = $_SESSION['status_response'];
    $status = $status_response['status'];
    $statusMsg = $status_response['status_msg'];
    unset($_SESSION['status_response']);
}
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <title>Upload File to Google Drive</title>
    <meta charset="utf-8">

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">
    <h1>Upload File to Google Drive</h1>

    <div class="wrapper">

        <!-- Status message -->
        <?php if (!empty($statusMsg)) { ?>
            <div class="alert alert-<?php echo $status; ?>">
                <?php echo $statusMsg; ?>
            </div>
        <?php } ?>

        <form method="post" action="upload.php" enctype="multipart/form-data">

            <div class="upload-box">
                <label class="upload-label">
                    <span class="upload-icon">📁</span>
                    <span class="upload-text" id="fileText">
                        Choose a file to upload
                    </span>
                    <input
                        type="file"
                        name="file"
                        id="fileInput"
                        required
                        onchange="showFileName(this)"
                    >
                </label>
            </div>

            <!-- Selected file name -->
            <div class="file-name" id="fileName"></div>

            <button type="submit" name="submit" class="upload-btn">
                <span class="btn-icon">⬆</span> Upload to Google Drive
            </button>

        </form>

    </div>
</div>

<!-- Minimal JS -->
<script>
function showFileName(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileName').innerText =
            "Selected file: " + input.files[0].name;

        document.getElementById('fileText').innerText =
            "File selected successfully";
    }
}
</script>

</body>
</html>
