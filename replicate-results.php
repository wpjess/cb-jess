<!DOCTYPE html>
<html>
<head>
    <title>Table Replication Command Generator - Results</title>
    <style type="text/css">
        .content { max-width: 1000px; margin: 40px auto; word-wrap: break-word; }
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
         body { 
            font-family: "Figtree", sans-serif; 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
            position: relative;
            height: 100%;
        }        
        pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            white-space: pre-wrap;
            margin-top: 20px;
        }
        .footer { position: absolute; bottom: 0; left: 0; }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
        .content { 
            max-width: 1000px; 
            margin: 40px auto; 
            word-wrap: break-word; 
            height: 90%; 
            position: relative; 
        }
        .copy-button {
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .copy-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Table replication curl request</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve form data
            $store_url = $_POST['store_url'];
            $store_name = $_POST['store_name'];
            $table_name = $_POST['table_name'];
            $token = $_POST['token'];
            $truncate = $_POST['truncate'];
            
            // Remove http:// or https:// if present
            $store_url = preg_replace('#^https?://#', '', $store_url);
            
            // Generate curl command
            $curl_command = "curl 'https://{$store_url}/api/v/1/sync/{$store_name}/uploadData?truncate={$truncate}' \\
  -H 'accept: application/json' \\
  -H 'accept-language: en-US,en;q=0.9' \\
  -H 'authorization: Bearer {$token}' \\
  -H 'cache-control: no-cache' \\
  -H 'content-type: application/json' \\
  -H 'origin: https://storemanager.commercebuild.com' \\
  -H 'pragma: no-cache' \\
  -H 'priority: u=1, i' \\
  -H 'referer: https://storemanager.commercebuild.com/' \\
  -H 'sec-ch-ua: \"Not(A:Brand\";v=\"99\", \"Google Chrome\";v=\"133\", \"Chromium\";v=\"133\"' \\
  -H 'sec-ch-ua-mobile: ?0' \\
  -H 'sec-ch-ua-platform: \"macOS\"' \\
  -H 'sec-fetch-dest: empty' \\
  -H 'sec-fetch-mode: cors' \\
  -H 'sec-fetch-site: cross-site' \\
  -H 'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36' \\
  --data-raw '{\"tables\":[\"{$table_name}\"]}'\n";
        ?>
            <h3>Generated Curl Command:</h3>
            <pre id="curl-command"><?php echo htmlspecialchars($curl_command); ?></pre>
            <button class="copy-button" onclick="copyToClipboard()">Copy to Clipboard</button>
            
            <h3>Command Details:</h3>
            <p><strong>Store URL:</strong> <?php echo htmlspecialchars($store_url); ?></p>
            <p><strong>Store Name:</strong> <?php echo htmlspecialchars($store_name); ?></p>
            <p><strong>Table Name:</strong> <?php echo htmlspecialchars($table_name); ?></p>
            <p><strong>Truncate:</strong> <?php echo htmlspecialchars($truncate); ?></p>
        <?php
        }
        ?>


        <br /><br /><br /><br />
        <div class="footer">
            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script>
    // Function to copy the generated curl command to the clipboard
    function copyToClipboard() {
        var copyText = document.getElementById("curl-command").textContent;
        
        // Remove line breaks and backslashes for terminal-friendly format
        var singleLineCommand = copyText.replace(/\\\s*\n\s*/g, " ");
        
        // Create a temporary text area to hold the curl command
        var textArea = document.createElement("textarea");
        textArea.value = singleLineCommand;
        document.body.appendChild(textArea);

        // Select and copy the text
        textArea.select();
        textArea.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");

        // Remove the temporary text area
        document.body.removeChild(textArea);

        // Alert the user that the text has been copied
        alert("Copied to clipboard as a single line command!");
    }
    </script>
</body>
</html>