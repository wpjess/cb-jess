<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curl Request Generator</title>
    <style type="text/css">
        body, html { height:100%; font-family: Arial, sans-serif; }
         body { 
            font-family: "Figtree", sans-serif; 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
            position:relative;
            height:100%;
        }
        h1, h2 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        .footer { position: relative; margin: 0 auto 40px; max-width:1000px; }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
        .content { max-width:1000px; margin:40px auto; word-wrap: break-word; min-height:80%; position:relative; }
        pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            cursor: pointer;
            white-space: pre-wrap;
        }
        .copy-notice {
            display: none;
            color: green;
            margin-top: 5px;
        }
        input[type="text"] {
            width: 100%;
            max-width: 500px;
            padding: 8px;
            margin-bottom: 10px;
        }
    </style>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-KRDNLFP9T6');
      
      // Function to copy curl command to clipboard
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
    <h2>Order API Curl Request Generator</h2>
    <form method="post">
        <label for="store_url">Enter Web Store URL:</label><br><br>
        <input type="text" id="store_url" name="store_url" placeholder="e.g. https://example.com">
        <br><br>
        <label for="xmsymphony">Enter xmsymphony Cookie Value:</label><br><br>
        <input type="text" id="xmsymphony" name="xmsymphony" placeholder="Enter cookie value here">
        <br><br>
        <label for="order_base64">Enter Order Base64 Value:</label><br><br>
        <input type="text" id="order_base64" name="order_base64" placeholder="e.g. YmY1OTk5ZTctYzQ0NC00ZGRlLWEwOTQtY2QxODNlZTQxZjFh">
        <br><br>
        <p style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; max-width: 500px; font-size: 14px;">
            <strong>Note:</strong> The Order Base64 value can be obtained from the database with this query:<br><br>
            <code>select orders_failed_accpac,to_base64(orders_failed_process_id) from orders_failed where orders_failed_process_status = 'PROCESSING' and orders_failed_created > '2023-03-02 00:00:00'</code>
        </p>
        <br>
        <input type="submit" name="submit" value="Generate Curl Request">
    </form>

<?php
if (isset($_POST['submit'])) {
    // Get the store URL and cookie value
    $storeUrl = trim($_POST['store_url']);
    $cookie = trim($_POST['xmsymphony']);
    
    // Get the order base64 value
    $orderBase64 = trim($_POST['order_base64']);
    
    // Validate inputs
    $errors = [];
    
    if (empty($storeUrl)) {
        $errors[] = "Please enter a valid web store URL.";
    }
    
    if (empty($cookie)) {
        $errors[] = "Please enter a valid xmsymphony cookie value.";
    }
    
    if (empty($orderBase64)) {
        $errors[] = "Please enter a valid Order Base64 value.";
    }
    
    if (empty($errors)) {
        // Ensure the store URL ends with /admin/morders/failed
        if (!preg_match('/\/admin\/morders\/failed$/', $storeUrl)) {
            $storeUrl = rtrim($storeUrl, '/') . '/admin/morders/failed';
        }
        
        // Get the order base64 value
        $orderBase64 = trim($_POST['order_base64']);
        if (empty($orderBase64)) {
            $orderBase64 = "YmY1OTk5ZTctYzQ0NC00ZGRlLWEwOTQtY2QxODNlZTQxZjFh"; // Default value if not provided
        }
        
        // Build the curl command
        $curlCommand = "curl '{$storeUrl}' \\\n";
        $curlCommand .= " -H 'accept: application/json, text/javascript, */*; q=0.01' \\\n";
        $curlCommand .= " -H 'accept-language: en-US,en;q=0.9,bg;q=0.8,es;q=0.7' \\\n";
        $curlCommand .= " -H 'cache-control: no-cache' \\\n";
        $curlCommand .= " -H 'content-type: application/x-www-form-urlencoded; charset=UTF-8' \\\n";
        $curlCommand .= " -H 'cookie: xmsymphony={$cookie};' \\\n";
        $curlCommand .= " -H 'x-requested-with: XMLHttpRequest' \\\n";
        $curlCommand .= " --data-raw 'resend={$orderBase64}' \\\n";
        $curlCommand .= " --compressed";
        
        echo "<h3>Generated Curl Request:</h3>";
        echo "<pre onclick=\"copyToClipboard(this)\">" . htmlspecialchars($curlCommand) . "</pre>";
        echo "<div id=\"copyNotice\" class=\"copy-notice\">Curl command copied to clipboard!</div>";
    } else {
        foreach ($errors as $error) {
            echo "<p>{$error}</p>";
        }
    }
}
?>
</div>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html>
