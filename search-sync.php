<html>
<head>
    <title>Search Sync</title>
    <style type="text/css">
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        body { font-family: Arial, sans-serif; }
        
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
        .row { margin-top:10px; }
        .row label { display:inline-block; width:120px; }
        .row input, .row textarea { padding:5px; }
        .footer { position: absolute; bottom:0; left:0; }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
        .content { max-width:1000px; margin:40px auto; word-wrap: break-word; height:90%; position:relative; }
    </style>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-KRDNLFP9T6');
    </script>
</head>
<body>
    <div class="content">
    <h1>Generate a sync search URL</h1>
    <form method="post" action="search-sync-results.php">
    <label>
        <input type="radio" name="environment" value="PROD US" required> PROD US
    </label>
    <label>
        <input type="radio" name="environment" value="PROD EU"> PROD EU
    </label>
    <label>
        <input type="radio" name="environment" value="PROD AU"> PROD AU
    </label>
    <label>
        <input type="radio" name="environment" value="STAGING"> STAGING
    </label><br><br />

    <div class="row">
    <label for="store_id">Store ID:</label>
    <input type="text" id="store_id" name="store_id" required><br>
    </div>

    <div class="row">
    <label for="table_name">Table Name:</label>
    <input type="text" id="table_name" name="table_name" required><br>
    </div>

    <div class="row">
    <label for="column_name">Column Name:</label>
    <input type="text" id="column_name" name="column_name" required><br>
    </div>

    <div class="row">
    <label for="value">Value:</label>
    <input type="text" id="value" name="value" required><br>
    </div>
    <div class="row">
    <label for="access_token">Access Token:</label>
    <textarea id="access_token" name="access_token" rows="4" cols="50"></textarea><br>
    </div>

    <div class="row">
    <label>Results Scope:</label>
    <label>
        <input type="radio" name="results_scope" value="recent" required> Recent
    </label>
    <label>
        <input type="radio" name="results_scope" value="thousand">Wayback
    </label>
    </div>
    <br /><br />

    <button type="submit">Generate URL</button>
</form>

    <p style="font-size:14px; color:#888; margin-top:60px;">Necessary spaces are added to <em>ORDNUMBER, IDCUST, ITEMNO, IDINVC</em> in the search query results.</p>

    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>

<script>
// Function to capitalize the text input
function capitalizeInput(elementId) {
    var input = document.getElementById(elementId);
    input.addEventListener("input", function() {
        input.value = input.value.toUpperCase();
    });
}

// Capitalize inputs for Table Name and Column Name
capitalizeInput("table_name");
capitalizeInput("column_name");

// Function to copy the generated URL to the clipboard
function copyToClipboard() {
    var copyText = document.getElementById("generated-url").innerText;

    // Create a temporary text area to hold the URL text
    var textArea = document.createElement("textarea");
    textArea.value = copyText;
    document.body.appendChild(textArea);

    // Select and copy the text
    textArea.select();
    textArea.setSelectionRange(0, 99999); // For mobile devices
    document.execCommand("copy");

    // Remove the temporary text area
    document.body.removeChild(textArea);

    // Alert the user that the text has been copied
    alert("Copied to clipboard: " + copyText);
}
</script>
<script async data-id="101475519" src="//static.getclicky.com/js"></script>
</body>
</html>