<!DOCTYPE html>
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
        
        // Function to show the CSV upload form or SQL processing result
        function showSection(sectionId) {
            document.getElementById('uploadSection').style.display = 'none';
            document.getElementById('resultSection').style.display = 'none';
            document.getElementById(sectionId).style.display = 'block';
        }
        
        // On page load, show the upload section by default
        window.onload = function() {
            showSection('uploadSection');
        };
    </script>
</head>
<body>
    <div class="content">
        <h1>Voucher SQL Generator</h1>
        
        <div id="uploadSection">
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
                
                <p><strong>Example CSV content:</strong></p>
                <pre>Voucher Code,Voucher Amount,Description
IM12964WD,$200 WANGARATTA & DISTRICTS CA,U16 RISING STAR OCTOBER
IM12969WD,$200 WANGARATTA & DISTRICTS CA,U16 RISING STAR NOVEMBER</pre>
            </div>
            
            <form action="vouchers_process.php" method="post" enctype="multipart/form-data">
                <label for="csvFile">Upload Voucher CSV File:</label>
                <input type="file" id="csvFile" name="csvFile" accept=".csv,.xlsx,.xls" required>
                <br>
                <input type="submit" name="submit" value="Generate SQL">
            </form>
        </div>
        
        <div id="resultSection" style="display: none;">
            <!-- This section will be populated by PHP after processing -->
        </div>
    </div>
    
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>