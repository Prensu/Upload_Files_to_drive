<!DOCTYPE html>
<html lang="en-us">
<head>
    <title>Upload File to Google Drive using PHP by CodexWorld</title>
    <meta charset="utf-8">

    <!-- Bootstrap library -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Stylesheet file -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>UPLOAD FILE TO GOOGLE DRIVE</h1>

    <div class="wrapper">
        <div class="col-md-12">
            <form method="post" action="upload.php" class="form" enctype="multipart/form-data">
                <div class="form-group">
                    <label>File</label>
                    <input type="file" name="file" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="form-control btn-primary" name="submit" value="Upload"/>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
