<html>
<head>
    <title>Sync URL Generator</title>
    <style type="text/css">
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        body { font-family: Arial, sans-serif; font-size:16px; }
        
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
        .generated-url {
            font-family: monospace;
            word-wrap: break-word;
            cursor: pointer;
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
    <h1>View all recent sync logs for a store</h1>
    <form method="POST">
        <input type="radio" id="prod_us" name="environment" value="PROD US" required>
        <label for="prod_us">PROD US</label>
        <input type="radio" id="prod_eu" name="environment" value="PROD EU">
        <label for="prod_eu">PROD EU</label>
        <input type="radio" id="prod_au" name="environment" value="PROD AU">
        <label for="prod_au">PROD AU</label>
        <input type="radio" id="staging" name="environment" value="STAGING">
        <label for="staging">STAGING</label><br><br>

        <div class="row">
        <label for="store_id">Store ID:</label>
        <input type="text" id="store_id" name="store_id" required><br>
        </div>

        <div class="row">
        <label for="access_token">Access Token:</label>
        <textarea id="access_token" name="access_token" rows="4" required></textarea><br><br>
        </div>

        <div class="row">
        <label>Results Type:</label>
        <input type="radio" id="short_results" name="results_type" value="short" required>
        <label for="short_results">Short Results</label>
        <input type="radio" id="long_results" name="results_type" value="long">
        <label for="long_results">Long Results</label><br><br>
        </div>

        <br /><br />
        <input type="submit" value="Generate URL">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve form data
        $environment = $_POST['environment'];
        $store_id = $_POST['store_id'];
        $access_token = $_POST['access_token'];
        $results_type = $_POST['results_type'];

        // Set base URL based on environment selection
        switch ($environment) {
            case 'PROD US':
                $base_url = 'https://platform.mysagestore.com';
                break;
            case 'PROD EU':
                $base_url = 'https://platform-d03d5231-b2f67feb.k8s.euw1.mysagestore.com';
                break;
            case 'PROD AU':
                $base_url = 'https://platform-5c84bc36-c66ee2d8.k8s.ause1.mysagestore.com';
                break;
            case 'STAGING':
                $base_url = 'https://platform.staging-mysagestore.com';
                break;
            default:
                $base_url = '';
                break;
        }

        // Construct the URL based on results type
        $query_params = ($results_type === 'long') 
            ? "request?n=1000&q=all&l=1&access_token={$access_token}"
            : "request?q=all&l=1&access_token={$access_token}";

        $url = "{$base_url}/api/v/1/sync/{$store_id}/{$query_params}";

    ?>
    <!-- Display the generated URL in a span with a copy functionality -->
    <h3>Generated URL:</h3>
    <span class="generated-url" id="generated-url"><?php echo htmlspecialchars($url); ?></span><br>
    
    <br /><br />
    <button onclick="copyToClipboard()">Copy to Clipboard</button>
    <?php
    }
    ?>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>

<script>
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
</body>
</html>
