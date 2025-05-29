<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $target_dir = "wp-content/uploads/nginx/";
    $timestamp = time();  // Get current timestamp
    $originalFileName = basename($_FILES["fileToUpload"]["name"]);
    $fileBaseName = pathinfo($originalFileName, PATHINFO_FILENAME);
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);

    // Create filenames with timestamp
    $target_file = $target_dir . $fileBaseName . "_" . $timestamp . "." . $fileExtension;
    $outputFile = $target_dir . $fileBaseName . "_filtered_" . $timestamp . "." . $fileExtension;

    // Check if file is a CSV
    if (strtolower($fileExtension) != "csv") {
        echo "Sorry, only CSV files are allowed.";
        exit;
    }

    // Try to upload file
    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Sorry, there was an error uploading your file.";
        exit;
    }

    // Open the uploaded CSV for reading
    if (($input = fopen($target_file, 'r')) === false) {
        echo 'Error opening input file.';
        exit;
    }

    // Open the output file for writing
    if (($output = fopen($outputFile, 'w')) === false) {
        fclose($input);
        echo 'Error opening output file.';
        exit;
    }

    $desiredColumns = [
        'admin_ajax_action',
        'cached',
        'country_code',
        'http_referer',
        'http_user_agent',
        'request_time',
        'request_type',
        'request_url',
        'request_url_args',
        'status',
        'user_ip',
        'wp_username'
    ];

    $columnIndices = [];

    // Process the header row to capture indices of desired columns
    if (($headers = fgetcsv($input, 0, ",")) !== false) {
        foreach ($headers as $key => $header) {
            if (in_array(trim($header), $desiredColumns)) {
                $columnIndices[$key] = trim($header);
            }
        }
        // Write filtered headers to the output
        fputcsv($output, $columnIndices, ",");
    }

    // Read and filter data rows
    while (($row = fgetcsv($input, 0, ",")) !== false) {
        $filteredRow = [];
        foreach ($columnIndices as $index => $header) {
            $filteredRow[] = $row[$index];
        }
        fputcsv($output, $filteredRow, ",");
    }

    fclose($input);
    fclose($output);

    // Delete the original file after processing
    unlink($target_file);

    // Provide a link to download the filtered file
    echo "File has been filtered and original deleted successfully.<br>";
    echo "<a href='" . htmlspecialchars($outputFile) . "'>Download Filtered File</a><br>";

    // Optionally, display the contents of the filtered CSV (omit for very large files)
    echo "<h2>Filtered File Contents:</h2>";
    if (($handle = fopen($outputFile, 'r')) !== FALSE) {
        echo "<table border='1'>";
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            echo "<tr>";
            foreach ($data as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
        fclose($handle);
    }
}
?>
