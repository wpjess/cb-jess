<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Generator</title>
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
        .content { max-width:1000px; margin:40px auto; word-wrap: break-word; min-height:80%; position:relative;  }
    </style>
</head>
<body>
    <div class="content">
    <h2>Unlock Promo Codes</h1>

    <form method="post">
        <label for="codes">Enter Codes (comma separated):</label><br><br>
        <input type="text" id="codes" name="codes" style="width:300px;" placeholder="e.g. GIFT, 7OFF750">
        <br><br>
        <input type="submit" name="submit" value="Generate SQL">
    </form>


<?php
if (isset($_POST['submit'])) {
    // Get the input codes and split by commas
    $codes = explode(',', $_POST['codes']);
    $codes = array_map('trim', $codes); // Trim whitespace from each code

    // Filter out empty entries
    $codes = array_filter($codes, function($code) {
        return !empty($code);
    });

    if (!empty($codes)) {

        // Start the SQL query for adding 'CB-' prefix back
        echo "<h3>Add 'CB-' Prefix (Unlock Promos):</h3><pre>";
        echo "UPDATE promotions_used\nSET promotions_used_code = CASE\n";
        foreach ($codes as $code) {
            echo "    WHEN promotions_used_code = '$code' THEN 'CB-$code'\n";
        }
        echo "    ELSE promotions_used_code\nEND\n";
        echo "WHERE promotions_used_code IN ('" . implode("', '", $codes) . "');\n";
        echo "</pre>";
    } else {
        echo "<p>Please enter valid codes.</p>";
    }
        // Start the SQL query for removing 'CB-' prefix
        echo "<h3>Remove 'CB-' Prefix (Re-Lock Promos):</h3><pre>";
        echo "UPDATE promotions_used\nSET promotions_used_code = CASE\n";
        foreach ($codes as $code) {
            echo "    WHEN promotions_used_code = 'CB-$code' THEN '$code'\n";
        }
        echo "    ELSE promotions_used_code\nEND\n";
        echo "WHERE promotions_used_code IN ('CB-" . implode("', 'CB-", $codes) . "');\n";
        echo "</pre>";
}
?>
</div>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html>
