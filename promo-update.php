<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Insert Generator</title>
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
        h1 {
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
        }
        .copy-notice {
            display: none;
            color: green;
            margin-top: 5px;
        }
        textarea {
            width: 100%;
            max-width: 500px;
            height: 200px;
        }
    </style>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-KRDNLFP9T6');
      
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
    <h2>Add Items To Promo Code</h2>
    <form method="post">
        <label for="promo_ids">Enter Promotion IDs (comma separated):</label><br><br>
        <input type="text" id="promo_ids" name="promo_ids" style="width:300px;" placeholder="e.g. 14761, 15534, 16248">
        <br><br>
        <label for="item_codes">Enter Item Codes (one per line):</label><br><br>
        <textarea id="item_codes" name="item_codes" placeholder="Enter item codes here, one per line"></textarea>
        <br><br>
        <input type="submit" name="submit" value="Generate SQL">
    </form>

<?php
if (isset($_POST['submit'])) {
    // Get the promotion IDs and split by commas
    $promoIds = explode(',', $_POST['promo_ids']);
    $promoIds = array_map('trim', $promoIds); // Trim whitespace from each ID
    
    // Get the item codes (one per line)
    $itemCodes = explode("\n", $_POST['item_codes']);
    $itemCodes = array_map('trim', $itemCodes); // Trim whitespace from each code
    
    // Filter out empty entries
    $promoIds = array_filter($promoIds, function($id) {
        return !empty($id);
    });
    
    $itemCodes = array_filter($itemCodes, function($code) {
        return !empty($code);
    });
    
    if (!empty($promoIds) && !empty($itemCodes)) {
        // Start the SQL query
        $query = "INSERT IGNORE INTO promotions_rel (promotions_rel_pid, promotions_rel_itemno) VALUES ";
        
        foreach ($promoIds as $promoId) {
            foreach ($itemCodes as $itemCode) {
                $escapedItemCode = str_replace('"', '\"', strtoupper($itemCode));
                $query .= "(" . $promoId . ", \"" . $escapedItemCode . "\"), ";
            }
        }
        
        $query = rtrim($query, ', '); // Remove the trailing comma and space
        $query .= ";"; // Add a semicolon to end the query
        
        echo "<h3>Generated SQL Insert Query:</h3>";
        echo "<pre onclick=\"copyToClipboard(this)\">" . htmlspecialchars($query) . "</pre>";
        echo "<div id=\"copyNotice\" class=\"copy-notice\">SQL copied to clipboard!</div>";
    } else {
        if (empty($promoIds)) {
            echo "<p>Please enter valid promotion IDs.</p>";
        }
        if (empty($itemCodes)) {
            echo "<p>Please enter valid item codes.</p>";
        }
    }
}
?>

<br /><br /><br /><p style="font-family:courier, sans-serif; color:#555; font-size:12px; letter-spacing:1px;"><strong>GET % PROMOS</strong><br />
SELECT promotions_id<br />
FROM promotions<br />
WHERE promotions_deleted = 0<br />
AND (promotions_finish IS NULL OR promotions_finish != '0000-00-00')<br />
AND (promotions_finish IS NULL OR promotions_finish >= CURDATE())<br />
AND promotions_percent != 0.00;</p>
</div>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
<script async data-id="101475519" src="//static.getclicky.com/js"></script>
</body>
</html>