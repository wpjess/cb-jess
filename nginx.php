<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV File</title>
</head>
<body>
    <h1>Upload CSV File to Filter</h1>
    <form action="nginx_filtered.php" method="post" enctype="multipart/form-data">
        Select CSV File:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>
</body>
</html>
