<?php
// Retrieve form data
$storeURL = $_POST['storeURL'];
$customerID = $_POST['customerID'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$siteHash = $_POST['siteHash'];
$emailAddress = $_POST['emailAddress'];
$webStoreUserID = $_POST['webStoreUserID'];

// Construct the Return URL
$returnURL = $storeURL . '/' . $customerID . '/fhBSahehGa22';

// Construct the Sample Params
$sampleParams = [
    "header" => new stdClass(),
    "type" => "setuprequest",
    "operation" => "create",
    "body" => [
        "data" => [
            "User" => $webStoreUserID,
            "UserEmail" => $emailAddress,
            "UserPrintableName" => $firstName . ' ' . $lastName,
            "UserFirstName" => $firstName,
            "UserLastName" => $lastName
        ],
        "contact" => [
            "data" => [],
            "email" => $emailAddress,
            "name" => $firstName . ' ' . $lastName,
            "unique" => $webStoreUserID
        ],
        "shipping" => new stdClass(),
        "items" => []
    ],
    "custom" => [
        "CustomerCode" => $customerID,
        "SiteHash" => $siteHash
    ]
];

// Convert the Sample Params to JSON
$jsonSampleParams = json_encode($sampleParams, JSON_PRETTY_PRINT);

// Web Store Domain is the same as Store URL
$webStoreDomain = $storeURL;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Punchout Request Results</title>
    <script>
        function copyToClipboard(text) {
            // Create a temporary textarea element
            var textarea = document.createElement("textarea");
            textarea.value = text;

            // Set its style to be unobtrusive
            textarea.setAttribute('readonly', '');
            textarea.style.position = 'absolute';
            textarea.style.left = '-9999px';
            
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            document.body.removeChild(textarea);

            // Provide feedback to user (optional)
            alert("Copied to clipboard!");
        }
    </script>
    <style type="text/css">
        pre { background:#eee; padding:10px; }
        span { background:#eee; padding:4px; }
    </style>
</head>
<body>
<div style="width:900px; margin: 50px auto;">
<h2>Output:</h2>

<p><strong>Return URL:</strong> <span id="returnUrl"><?php echo $returnURL; ?></span>
<button onclick="copyToClipboard(document.getElementById('returnUrl').textContent)">Copy</button></p>

<p><strong>Sample Params:</strong><pre id="sampleParams"><?php echo $jsonSampleParams; ?></pre>
<button onclick="copyToClipboard(document.getElementById('sampleParams').textContent)">Copy</button></p>

<p><strong>Web Store Domain:</strong> <span id="webStoreDomain"><?php echo $webStoreDomain; ?></span>
<button onclick="copyToClipboard(document.getElementById('webStoreDomain').textContent)">Copy</button></p>

<p>Test the Punchout request here: <a href="https://support.commercebuild.com/article/how-to-use-punchout/" target="_blank">https://support.commercebuild.com/article/how-to-use-punchout/</a></p>
</div>
</body>
</html>
