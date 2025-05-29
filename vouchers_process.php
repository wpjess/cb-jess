<?php
/**
 * Voucher SQL Generator - Processing Script
 * Handles CSV file uploads and generates SQL INSERT statements
 * No external dependencies required
 */

// Start the session for flash messages
session_start();

// Set maximum execution time to handle large files
ini_set('max_execution_time', 300); // 5 minutes
ini_set('memory_limit', '256M');    // Increase memory limit

// Default values for promotion records
$defaultValues = [
    'promotions_id' => 'NULL', // Let database auto-assign ID
    'promotions_code' => '',
    'promotions_type' => 2, // Assuming a standard type
    'promotions_desc' => '',
    'promotions_percent' => 0,
    'promotions_amount' => 0,
    'promotions_after_amount' => 0,
    'promotions_expiry' => 1,
    'promotions_start' => '2025-03-13 00:00:00',
    'promotions_finish' => '2026-06-30 23:59:59',
    'promotions_usage' => 1, 
    'promotions_first_order' => 0,
    'promotions_first_order_uid' => 'NULL',
    'promotions_apply' => 0,
    'promotions_customer' => 0,
    'promotions_gbf' => 0,
    'promotions_gbf_base' => 0,
    'promotions_gbf_free' => 0,
    'promotions_freeshipping' => 0,
    'promotions_freeshipping_carrier' => 'NULL',
    'promotions_freeshipping_carrier_id' => 'NULL',
    'promotions_freeshipping_carrier_service' => 'NULL',
    'promotions_freeshipping_carrier_scope' => 'NULL',
    'promotions_freeshipping_afteramt' => 0,
    'promotions_in_conjunction' => 0,
    'promotions_batchid' => 0,
    'promotions_user_id' => 1,
    'promotions_deleted' => 0,
    'promotions_updated' => '',
    'promotions_created' => '',
    'promotions_exclude' => 0,
    'promotions_hide' => 0,
    'promotions_scope' => '["b2c"]', 
    'promotions_legacy' => 0,
    'promotions_single_use' => 1,
    'promotions_allow_multi_redemp' => 1,
    'promotions_amount_is_include_tax' => 1,
    'promotions_freeshippping_apply_allitems' => 0,
];

// Define column order for SQL INSERT statement
$orderedColumns = [
    'promotions_id', 'promotions_code', 'promotions_type', 'promotions_desc', 
    'promotions_percent', 'promotions_amount', 'promotions_after_amount', 
    'promotions_expiry', 'promotions_start', 'promotions_finish', 
    'promotions_usage', 'promotions_first_order', 'promotions_first_order_uid', 
    'promotions_apply', 'promotions_customer', 'promotions_gbf', 
    'promotions_gbf_base', 'promotions_gbf_free', 'promotions_freeshipping', 
    'promotions_freeshipping_carrier', 'promotions_freeshipping_carrier_id', 
    'promotions_freeshipping_carrier_service', 'promotions_freeshipping_carrier_scope', 
    'promotions_freeshipping_afteramt', 'promotions_in_conjunction', 
    'promotions_batchid', 'promotions_user_id', 'promotions_deleted', 
    'promotions_updated', 'promotions_created', 'promotions_exclude', 
    'promotions_hide', 'promotions_scope', 'promotions_legacy', 
    'promotions_single_use', 'promotions_allow_multi_redemp', 
    'promotions_amount_is_include_tax', 'promotions_freeshippping_apply_allitems'
];

// Initialize results
$resultHtml = '';
$sqlQuery = '';
$errors = [];
$processedCount = 0;
$tableName = 'promotions';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    $uploadedFile = $_FILES['csvFile'];
    
    // Check for upload errors
    if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'File upload error: ' . getUploadErrorMessage($uploadedFile['error']);
    } else {
        $filePath = $uploadedFile['tmp_name'];
        $fileName = $uploadedFile['name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Only accept CSV files with this script
        if ($fileExt !== 'csv') {
            $errors[] = 'Only CSV files are supported. Please save your Excel file as CSV (.csv) and try again.';
        } else {
            // Process the CSV file
            try {
                // Open the file
                $fileHandle = fopen($filePath, 'r');
                if ($fileHandle === false) {
                    throw new Exception('Unable to open the uploaded file.');
                }
                
                // Read the header row to identify columns
                $headerRow = fgetcsv($fileHandle);
                if ($headerRow === false) {
                    throw new Exception('CSV file appears to be empty.');
                }
                
                // Find the column indexes
                $codeColIndex = -1;
                $amountColIndex = -1;
                $descColIndex = -1;
                
                foreach ($headerRow as $index => $header) {
                    $header = trim($header);
                    if (preg_match('/voucher\s*code/i', $header)) {
                        $codeColIndex = $index;
                    } elseif (preg_match('/voucher\s*amount/i', $header)) {
                        $amountColIndex = $index;
                    } elseif (preg_match('/description/i', $header)) {
                        $descColIndex = $index;
                    }
                }
                
                // If required columns not found, report error
                if ($codeColIndex === -1 || $amountColIndex === -1) {
                    throw new Exception('Required columns "Voucher Code" and "Voucher Amount" not found in the header row.');
                }
                
                // Start building the SQL values
                $insertValues = [];
                $rowNumber = 1; // Start after header
                
                // Process each row
                while (($row = fgetcsv($fileHandle)) !== false) {
                    $rowNumber++;
                    
                    // Skip empty rows
                    if (empty($row[$codeColIndex]) || empty($row[$amountColIndex])) {
                        continue;
                    }
                    
                    $promoCode = trim($row[$codeColIndex]);
                    $amountAndLocation = trim($row[$amountColIndex]);
                    $description = ($descColIndex !== -1 && isset($row[$descColIndex])) ? 
                        trim($row[$descColIndex]) : '';
                    
                    // Validate the promo code format
                    if (!preg_match('/^IM\d+[A-Z]+$/', $promoCode)) {
                        $errors[] = "Row {$rowNumber}: Code '{$promoCode}' does not match expected format (IM####XXX).";
                        continue;
                    }
                    
                    // Extract amount from the second column
                    if (!preg_match('/\$(\d+)/', $amountAndLocation, $amountMatch)) {
                        $errors[] = "Row {$rowNumber}: Could not extract amount from '{$amountAndLocation}' for code {$promoCode}.";
                        continue;
                    }
                    
                    $amount = (float)$amountMatch[1];
                    
                    // Extract location/merchant info
                    $location = trim(preg_replace('/\$\d+\s*/', '', $amountAndLocation));
                    
                    // Combine description parts
                    $fullDescription = $location;
                    if (!empty($description)) {
                        $fullDescription .= " - " . $description;
                    }
                    
                    // Format description according to required format
                    $formattedDesc = "|P|{$promoCode}|P||A|{$amount}|A| - \${$amount} {$fullDescription}";
                    
                    // Get the values for this row
                    $rowValues = generateInsertValues($promoCode, $formattedDesc, $amount);
                    $insertValues[] = "(" . implode(', ', $rowValues) . ")";
                    $processedCount++;
                }
                
                // Close the file
                fclose($fileHandle);
                
                // Generate the SQL query if we have values
                if (!empty($insertValues)) {
                    $sqlQuery = "-- SQL Insert statements for promotions table\n";
                    $sqlQuery .= "-- Generated on " . date('Y-m-d H:i:s') . "\n\n";
                    $sqlQuery .= "INSERT INTO {$tableName} (" . implode(', ', $orderedColumns) . ") VALUES\n";
                    $sqlQuery .= implode(",\n", $insertValues) . ";\n";
                } else {
                    $errors[] = "No valid voucher records found in the file.";
                }
                
            } catch (Exception $e) {
                $errors[] = 'Error processing file: ' . $e->getMessage();
            }
        }
    }
}

/**
 * Generate the values for a SQL INSERT row for a promotion
 * 
 * @param string $code Promotion code
 * @param string $description Formatted promotion description
 * @param float $amount Promotion amount
 * @return array Array of values to be inserted
 */
function generateInsertValues($code, $description, $amount) {
    global $defaultValues, $orderedColumns;
    
    // Create a copy of default values and update with specific values
    $values = $defaultValues;
    $values['promotions_id'] = 'NULL';  // Let database auto-assign ID
    $values['promotions_code'] = $code;
    $values['promotions_desc'] = $description;
    $values['promotions_amount'] = $amount;
    $values['promotions_after_amount'] = $amount;
    $values['promotions_updated'] = date('Y-m-d H:i:s');
    $values['promotions_created'] = date('Y-m-d H:i:s');
    
    // Format each value for SQL in correct order
    $valuesList = [];
    foreach ($orderedColumns as $column) {
        $value = $values[$column];
        
        // Handle special case for promotions_scope which needs to be properly escaped as JSON
        if ($column === 'promotions_scope') {
            $valuesList[] = "'" . json_encode(json_decode($value)) . "'";
        } else if ($value === 'NULL') {
            $valuesList[] = 'NULL';
        } else if (is_string($value) && $value !== 'NULL') {
            $valuesList[] = "'" . addslashes($value) . "'";
        } else {
            $valuesList[] = $value;
        }
    }
    
    return $valuesList;
}

/**
 * Get a human-readable message for file upload errors
 */
function getUploadErrorMessage($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_INI_SIZE:
            return "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
        case UPLOAD_ERR_FORM_SIZE:
            return "The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.";
        case UPLOAD_ERR_PARTIAL:
            return "The uploaded file was only partially uploaded.";
        case UPLOAD_ERR_NO_FILE:
            return "No file was uploaded.";
        case UPLOAD_ERR_NO_TMP_DIR:
            return "Missing a temporary folder.";
        case UPLOAD_ERR_CANT_WRITE:
            return "Failed to write file to disk.";
        case UPLOAD_ERR_EXTENSION:
            return "A PHP extension stopped the file upload.";
        default:
            return "Unknown upload error.";
    }
}

// Prepare HTML for the page
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher SQL Generator</title>
    <style type="text/css">
        body, html { 
            height: 100%; 
            font-family: "Figtree", Arial, sans-serif; 
            margin: 0;
            padding: 0;
        }
        body { 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
            position: relative;
            height: 100%;
        }
        h1, h2 {
            font-family: Arial, sans-serif;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .content { 
            max-width: 1000px; 
            margin: 40px auto; 
            word-wrap: break-word; 
            min-height: 80%; 
            position: relative;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .footer { 
            position: relative; 
            margin: 0 auto 40px; 
            max-width: 1000px; 
            text-align: center;
        }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
        pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            cursor: pointer;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 400px;
            overflow-y: auto;
        }
        .copy-notice {
            display: none;
            color: green;
            margin-top: 5px;
            font-weight: bold;
        }
        form {
            margin-bottom: 30px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="file"], input[type="submit"] {
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .csv-format {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #4CAF50;
        }
        .csv-format h3 {
            margin-top: 0;
        }
        .csv-format-notes {
            margin-top: 15px;
            background-color: #f0f7f0;
            padding: 12px;
            border-radius: 5px;
        }
        .csv-format-notes h4 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        .csv-format-notes ul {
            margin-top: 0;
            padding-left: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .note-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
    <script>
        // Function to copy SQL to clipboard
        function copyToClipboard(element) {
            var text = element.textContent;
            navigator.clipboard.writeText(text).then(function() {
                var notice = document.getElementById('copyNotice');
                notice.style.display = 'block';
                setTimeout(function() {
                    notice.style.display = 'none';
                }, 2000);
            });
        }
    </script>
</head>
<body>
    <div class="content">
        <h1>Voucher SQL Generator</h1>
        
        <?php if (!empty($sqlQuery)): ?>
            <!-- Results Section -->
            <h2>SQL Generator Results</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="error-message">The following errors occurred:</div>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <div class="success-message">Successfully processed <?php echo $processedCount; ?> voucher records.</div>
            
            <h3>Generated SQL Insert Query:</h3>
            <pre onclick="copyToClipboard(this)"><?php echo htmlspecialchars($sqlQuery); ?></pre>
            <div id="copyNotice" class="copy-notice">SQL copied to clipboard!</div>
            
            <p><a href="<?php echo $_SERVER['PHP_SELF']; ?>">← Process another file</a></p>
            
        <?php else: ?>
            <!-- Upload Section -->
            <?php if (!empty($errors)): ?>
                <div class="error-message">The following errors occurred:</div>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            
            <div class="note-box">
                <strong>Note:</strong> This tool only processes CSV files. If you have an Excel file, please save it as CSV (.csv) before uploading.
            </div>
            
            <div class="csv-format">
                <h3>Required CSV Format</h3>
                <p>Your CSV file should have the following structure:</p>
                <table>
                    <thead>
                        <tr>
                            <th>Voucher Code</th>
                            <th>Voucher Amount</th>
                            <th>Description (Optional)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>IM12964WD</td>
                            <td>$200 WANGARATTA & DISTRICTS CA</td>
                            <td>U16 RISING STAR OCTOBER</td>
                        </tr>
                        <tr>
                            <td>IM12969WD</td>
                            <td>$200 WANGARATTA & DISTRICTS CA</td>
                            <td>U16 RISING STAR NOVEMBER</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="csv-format-notes">
                    <h4>Column Details:</h4>
                    <ul>
                        <li><strong>Voucher Code:</strong> Must start with "IM" followed by numbers and uppercase letters (e.g., IM12964WD)</li>
                        <li><strong>Voucher Amount:</strong> Dollar amount with $ sign followed by merchant/location name (e.g., $200 WANGARATTA & DISTRICTS CA)</li>
                        <li><strong>Description:</strong> Optional additional description (e.g., U16 RISING STAR OCTOBER)</li>
                    </ul>
                </div>
            </div>
            
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <label for="csvFile">Upload Voucher CSV File:</label>
                <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
                <br>
                <input type="submit" name="submit" value="Generate SQL">
            </form>
        <?php endif; ?>
    </div>
    
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>