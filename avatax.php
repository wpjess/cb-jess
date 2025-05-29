<script>
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateBtn');
    const form = document.getElementById('avataxForm');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const resultsSection = document.getElementById('results-section');
    const phpCodeElement = document.getElementById('php-code');
    
    generateBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Show loading indicator
        loadingIndicator.style.display = 'inline-block';
        
        // Create a FormData object
        const formData = new FormData(form);
        
        // Create XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'avatax_generate.php', true);
        
        xhr.onload = function() {
            // Hide loading
            loadingIndicator.style.display = 'none';
            
            // Display the results - ignore status code (avoid showing errors)
            phpCodeElement.textContent = xhr.responseText;
            resultsSection.style.display = 'block';
        };
        
        xhr.onerror = function() {
            // Hide loading
            loadingIndicator.style.display = 'none';
            
            // If there's a network error, just show whatever response we have
            // or an empty string if there's nothing
            phpCodeElement.textContent = xhr.responseText || "Network error occurred.";
            resultsSection.style.display = 'block';
        };
        
        // Send the form data
        xhr.send(formData);
    });
});
</script><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AvaTax PHP Generator</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            box-sizing: border-box;
        }
        .address-section {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .address-section h3 {
            margin-top: 0;
        }
        .line-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .btn-submit {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #45a049;
        }
        #results-section {
            display: none;
            margin-top: 20px;
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(0,0,0,.1);
            border-radius: 50%;
            border-top-color: #4CAF50;
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
            vertical-align: middle;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-KRDNLFP9T6');
      
      // Function to copy PHP to clipboard
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
    <h2>AvaTax PHP Generator</h2>
    <form id="avataxForm">
        <div class="form-group">
            <label for="company_name">Client Company Code:</label>
            <input type="text" id="company_name" name="company_name" value="DEFAULT-71142">
        </div>
        
        <div class="form-group">
            <label>Security Credentials:</label>
            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 10px;">
                <input type="text" id="security_username" name="security_username" placeholder="Username" value="2000121025" style="flex: 1; max-width: 150px;">
                <span>:</span>
                <input type="text" id="security_password" name="security_password" placeholder="Password" value="D42BE1BE533053DA" style="flex: 1; max-width: 150px;">
            </div>
            <div style="font-size: 12px; color: #666; margin-top: 5px;">
                These values will be combined as "username:password" and Base64 encoded.
            </div>
        </div>
        
        <div class="address-section">
            <h3>Ship From Address</h3>
            <div class="form-group">
                <label for="ship_from_address1">Address Line 1:</label>
                <input type="text" id="ship_from_address1" name="ship_from_address1" value="51 S Wandling Ave">
            </div>
            <div class="form-group">
                <label for="ship_from_address2">Address Line 2:</label>
                <input type="text" id="ship_from_address2" name="ship_from_address2">
            </div>
            <div class="form-group">
                <label for="ship_from_city">City:</label>
                <input type="text" id="ship_from_city" name="ship_from_city" value="Washington">
            </div>
            <div class="form-group">
                <label for="ship_from_state">State:</label>
                <input type="text" id="ship_from_state" name="ship_from_state" value="NJ">
            </div>
            <div class="form-group">
                <label for="ship_from_zip">ZIP Code:</label>
                <input type="text" id="ship_from_zip" name="ship_from_zip" value="07882">
            </div>
            <div class="form-group">
                <label for="ship_from_country">Country:</label>
                <input type="text" id="ship_from_country" name="ship_from_country" value="USA">
            </div>
        </div>
        
        <div class="address-section">
            <h3>Ship To Address</h3>
            <div class="form-group">
                <label for="ship_to_address1">Address Line 1:</label>
                <input type="text" id="ship_to_address1" name="ship_to_address1" value="512 Philip Road">
            </div>
            <div class="form-group">
                <label for="ship_to_address2">Address Line 2:</label>
                <input type="text" id="ship_to_address2" name="ship_to_address2">
            </div>
            <div class="form-group">
                <label for="ship_to_city">City:</label>
                <input type="text" id="ship_to_city" name="ship_to_city" value="Huntingdon Valley">
            </div>
            <div class="form-group">
                <label for="ship_to_state">State:</label>
                <input type="text" id="ship_to_state" name="ship_to_state" value="PA">
            </div>
            <div class="form-group">
                <label for="ship_to_zip">ZIP Code:</label>
                <input type="text" id="ship_to_zip" name="ship_to_zip" value="19006">
            </div>
            <div class="form-group">
                <label for="ship_to_country">Country:</label>
                <input type="text" id="ship_to_country" name="ship_to_country" value="USA">
            </div>
        </div>
        
        <div class="line-item">
            <h3>Line Item Details</h3>
            <div class="form-group">
                <label for="item_code">Item Code:</label>
                <input type="text" id="item_code" name="item_code" value="MSC4">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" id="quantity" name="quantity" value="1">
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" id="price" name="price" value="65.99">
            </div>
            <div class="form-group">
                <label for="tax_code">Tax Code:</label>
                <input type="text" id="tax_code" name="tax_code" value="AVATAX">
            </div>
        </div>
        
        <button type="button" id="generateBtn" class="btn-submit">Generate PHP</button>
        <span id="loadingIndicator" style="display: none;"><span class="loading"></span> Processing...</span>
    </form>

    <div id="results-section">
        <h3>Generated PHP Code:</h3>
        <pre id="php-code" onclick="copyToClipboard(this)"></pre>
        <div id="copyNotice" class="copy-notice">PHP code copied to clipboard!</div>
        <div class="instructions-box" style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-left: 4px solid #4CAF50; border-radius: 4px;">
            <strong>For Jess:</strong> Navigate to Desktop/Bash/Avalara. Save the output to avatax_run.php. Then execute that in the Terminal.
        </div>
    </div>
</div>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const generateBtn = document.getElementById('generateBtn');
    const form = document.getElementById('avataxForm');
    const loadingIndicator = document.getElementById('loadingIndicator');
    const resultsSection = document.getElementById('results-section');
    const phpCodeElement = document.getElementById('php-code');
    
    generateBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Show loading indicator
        loadingIndicator.style.display = 'inline-block';
        
        // Create a FormData object
        const formData = new FormData(form);
        
        // Create XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'avatax_generate.php', true);
        
        xhr.onload = function() {
            // Hide loading
            loadingIndicator.style.display = 'none';
            
            if (xhr.status === 200) {
                // Display the results
                phpCodeElement.textContent = xhr.responseText;
                resultsSection.style.display = 'block';
            } else {
                alert('There was an error generating the PHP code. Please try again.');
            }
        };
        
        xhr.onerror = function() {
            loadingIndicator.style.display = 'none';
            alert('There was an error generating the PHP code. Please try again.');
        };
        
        // Send the form data
        xhr.send(formData);
    });
});
</script>
</body>
</html>