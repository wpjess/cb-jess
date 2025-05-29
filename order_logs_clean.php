<!DOCTYPE html>
<html>
<head>
    <title>Formatted JSON, SOAP, and XML Data</title>
    <style>
        body { color: #333; text-decoration: none; }
        .wrapper { max-width: 1000px; margin: 40px auto; }
        h2 {
            font-family: Arial, sans-serif;
            font-size: 18px;
        }
        pre {
            font-family: Courier, monospace;
            font-size: 11px;
            background-color: #eee;
            padding: 10px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="wrapper">
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"])) {
    $message = $_POST["message"];

    // Extract and display "Request" section
    $jsonStartPosition = strpos($message, '"request": {');
    if ($jsonStartPosition !== false) {
        $jsonStart = strpos($message, '{', $jsonStartPosition); // Find the first '{'
        $bracesCount = 0;
        for ($i = $jsonStart; $i < strlen($message); $i++) {
            if ($message[$i] === '{') {
                $bracesCount++;
            } elseif ($message[$i] === '}') {
                $bracesCount--;
                if ($bracesCount === 0) {
                    $jsonEnd = $i + 1; // End of the JSON object
                    break;
                }
            }
        }
        if (isset($jsonEnd)) {
            $requestData = substr($message, $jsonStart, $jsonEnd - $jsonStart);
            echo '<h2>Request</h2>';
            echo '<pre>' . htmlspecialchars($requestData) . '</pre>';
        } else {
            echo '<h2>Request</h2><pre>Error extracting Request data.</pre>';
        }
    } else {
        echo '<h2>Request</h2><pre>No Request data found.</pre>';
    }

        // Extract and display "Sent" SOAP section
        $sentStart = strpos($message, '"sent": "') + 9;
        $sentEnd = strpos($message, '"received": "', $sentStart) - 1;
        if ($sentStart && $sentEnd) {
            $sentData = substr($message, $sentStart, $sentEnd - $sentStart);
            // Match the entire SOAP request including the envelope and body
            if (preg_match('/<soapenv:Envelope.*?<\/soapenv:Envelope>/s', $sentData, $matches)) {
                $soapData = stripslashes($matches[0]);
                echo '<h2>Sent</h2>';
                echo '<pre>' . htmlspecialchars(formatXml($soapData)) . '</pre>';
            } else {
                echo '<h2>Sent</h2><pre>No SOAP Envelope data found.</pre>';
            }
        }

        // Extract and display "Received" XML section
        $receivedStart = strpos($message, '"received": "') + 13;
        $receivedEnd = strpos($message, '"response": {', $receivedStart) - 1;
        if ($receivedStart && $receivedEnd) {
            $xmlData = substr($message, $receivedStart, $receivedEnd - $receivedStart);
            $xmlData = stripslashes(trim($xmlData, '"'));
            echo '<h2>Received</h2>';
            echo '<pre>' . htmlspecialchars(formatXml($xmlData)) . '</pre>';
        } else {
            echo '<h2>Received</h2><pre>No Received data found.</pre>';
        }

        // Extract and display "Response" JSON section
        $responseStart = strpos($message, '"response": {');
        if ($responseStart !== false) {
            $responseJson = substr($message, $responseStart);
            echo '<h2>Response</h2>';
            echo '<pre>' . htmlspecialchars($responseJson) . '</pre>';
        } else {
            echo '<h2>Response</h2><pre>No Response data found.</pre>';
        }
    } else {
        echo '<p>Invalid request or no message was submitted.</p>';
    }

    // Function to format XML for better readability
    function formatXml($xml) {
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        return @$dom->loadXML($xml) ? $dom->saveXML() : $xml;
    }
    ?>
    </div>
</body>
</html>
