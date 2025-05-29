<html>
<head>
    <title>Search Sync</title>
     <style type="text/css">
        .content { max-width:1000px; margin:40px auto; word-wrap: break-word;}
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        body { font-family: Arial, sans-serif; font-size:16px; }

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
</head>
<body>
<div class="content">
    <h1>Search URL Results</h1>
    <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $environment = $_POST['environment'];
    $store_id = $_POST['store_id'];
    $table_name = $_POST['table_name'];
    $column_name = $_POST['column_name'];
    $value = $_POST['value'];
    $access_token = $_POST['access_token'];
    $results_scope = $_POST['results_scope'];

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

    // Check if the table is OEORDH and column is ORDNUMBER
    if ($table_name == 'OEORDH' && $column_name == 'ORDNUMBER') {
        // Ensure the value is exactly 22 characters long
        $value_length = strlen($value);
        if ($value_length < 22) {
            // Add enough '%20' to make it 22 characters long
            $value .= str_repeat('%20', 22 - $value_length);
        }
    }

    if ($table_name == 'ARCUS' && $column_name == 'IDCUST') {
    // Ensure the value is exactly 12 characters long
    $value_length = strlen($value);
    if ($value_length < 12) {
        // Add enough '%20' to make it 12 characters long
        $value .= str_repeat('%20', 12 - $value_length);
     }
    }

    if ($table_name == 'ARCSP' && $column_name == 'IDCUSTSHPT') {
    // Ensure the value is exactly 12 characters long
    $value_length = strlen($value);
    if ($value_length < 12) {
        // Add enough '%20' to make it 12 characters long
        $value .= str_repeat('%20', 12 - $value_length);
     }
    }

    if ($table_name == 'ICITEM' && $column_name == 'ITEMNO') {
    // Ensure the value is exactly 12 characters long
    $value_length = strlen($value);
    if ($value_length < 24) {
        // Add enough '%20' to make it 12 characters long
        $value .= str_repeat('%20', 24 - $value_length);
     }
    }

    if ($table_name == 'ICPRICP' && $column_name == 'ITEMNO') {
    // Ensure the value is exactly 12 characters long
    $value_length = strlen($value);
    if ($value_length < 24) {
        // Add enough '%20' to make it 12 characters long
        $value .= str_repeat('%20', 24 - $value_length);
     }
    }

    if ($table_name == 'AROBL' && $column_name == 'IDINVC') {
    // Ensure the value is exactly 12 characters long
    $value_length = strlen($value);
    if ($value_length < 22) {
        // Add enough '%20' to make it 12 characters long
        $value .= str_repeat('%20', 22 - $value_length);
     }
    }

    // Construct the URL based on results scope
    $query_params = ($results_scope === 'thousand') 
        ? "&max=1000&l=1&access_token={$access_token}"
        : "&l=1&access_token={$access_token}";

    $url = "{$base_url}/api/v/1/sync/{$store_id}/request/*/data/{$table_name}?{$column_name}={$value}{$query_params}";
    ?>
    <!-- Display the generated URL in a span with a copy functionality -->
    <h3>Generated URL:</h3>
    <span class="generated-url" id="generated-url"><?php echo htmlspecialchars($url); ?></span><br>
    <br /><br />
    <button onclick="copyToClipboard()">Copy to Clipboard</button>
    <?php
    }
    ?>

    <br /><br /><br /><br /><br />
    <a href="https://www.epochconverter.com/" target="_blank">Epoch Converter</a>

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
