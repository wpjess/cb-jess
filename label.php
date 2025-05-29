<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Label Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            color: #333;
            text-align: center;
        }
        
        .form-container {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            min-height: 100px;
            margin-bottom: 15px;
        }
        
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        #printPage {
            display: none;
        }
        
        .shipping-label {
            width: 8.5in;
            height: 5.5in; /* Half of a letter page */
            margin: 0 auto;
            page-break-after: always;
            box-sizing: border-box;
            position: relative;
            background-image: url('images/label-bg.jpg'); /* Replace with your actual background image URL */
            background-repeat: no-repeat;
            background-size: contain;
            background-position: center;
        }
        
        .to-address {
            position: absolute;
            top: 2.7in; /* Adjusted for larger label size */
            left: 3.5in; /* Adjust based on your template */
            width: 3.5in;
            height: 2in;
        }
        
        .address-content {
            white-space: pre-line;
            font-size: 18px;
            line-height: 1.3;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }
            
            #printPage, #printPage * {
                visibility: visible;
            }
            
            #printPage {
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            
            .shipping-label {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
        
        .back-button {
            background-color: #555;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container" id="formPage">
        <h1>Shipping Label Generator</h1>
        
        <div>
            <label for="toAddress">To Address:</label>
            <textarea id="toAddress" placeholder="Recipient Name&#10;Recipient Company&#10;123 Their Street&#10;Their City, State ZIP"></textarea>
        </div>
        
        <div>
            <button onclick="generateLabel()">Generate Label</button>
        </div>
    </div>
    
    <div id="printPage">
        <div class="shipping-label" id="labelContainer">
            <div class="to-address">
                <div class="address-content" id="labelToAddress"></div>
            </div>
        </div>
        <div style="margin-top: 15px; text-align: center;">
            <button onclick="window.print()" style="background-color: #2196F3; margin-right: 10px;">Print Label</button>
            <button onclick="backToForm()" class="back-button">Back to Form</button>
        </div>
    </div>
    
    <script>
        function generateLabel() {
            // Get recipient address
            const toAddress = document.getElementById('toAddress').value;
            
            // Update label with recipient address
            document.getElementById('labelToAddress').textContent = toAddress;
            
            // Hide form and show print page
            document.getElementById('formPage').style.display = 'none';
            document.getElementById('printPage').style.display = 'block';
            
            // No longer automatically opening print dialog
        }
        
        function backToForm() {
            document.getElementById('printPage').style.display = 'none';
            document.getElementById('formPage').style.display = 'block';
        }
    </script>
</body>
</html>