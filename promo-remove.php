<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Delete Generator</title>
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
        .warning {
            color: #c00;
            font-weight: bold;
            margin: 15px 0;
            padding: 10px;
            border: 1px solid #c00;
            background-color: #fff8f8;
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
    <h2>Remove Items From Promo Code</h2>
    <div class="warning">
        ⚠️ Warning: DELETE operations cannot be undone. Always create a backup first.
    </div>
    <form method="post">
        <label for="promo_ids">Enter Promotion IDs (comma separated):</label><br><br>
        <input type="text" id="promo_ids" name="promo_ids" style="width:300px;" placeholder="e.g. 14761, 15000, 15965">
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
        // Generate a SELECT query for backup first
        $selectQuery = "-- Generate a backup first\nSELECT * FROM promotions_rel WHERE promotions_rel_pid IN (" . implode(", ", $promoIds) . ");";
        
        // Start the DELETE query
        $deleteQuery = "DELETE FROM promotions_rel WHERE ";
        
        $conditions = [];
        foreach ($promoIds as $promoId) {
            foreach ($itemCodes as $itemCode) {
                $escapedItemCode = str_replace('"', '\"', strtoupper($itemCode));
                // Build the condition for each promotion
                $conditions[] = "(promotions_rel_pid = " . $promoId . " AND promotions_rel_itemno = \"" . $escapedItemCode . "\")";
            }
        }
        
        // Join all conditions with 'OR' to build the final WHERE clause
        $deleteQuery .= implode("\n    OR ", $conditions);
        $deleteQuery .= ";"; // End the query with a semicolon
        
        echo "<h3>SQL Backup Query:</h3>";
        echo "<pre onclick=\"copyToClipboard(this)\">" . htmlspecialchars($selectQuery) . "</pre>";
        
        echo "<h3>SQL Delete Query:</h3>";
        echo "<pre onclick=\"copyToClipboard(this)\">" . htmlspecialchars($deleteQuery) . "</pre>";
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
</div>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html>
