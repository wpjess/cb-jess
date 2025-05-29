<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>createOrder and sageExchangeTrnV2 generator</title>
</head>
<body>
    <h1>Enter JSON Data</h1>
    <pre>select logs_order_argument from logs_order where logs_order_accpac = 'WSO000001280'</pre>
    <form action="sageExchangeTrnV2Generate.php" method="post">
        <label for="json_data">Enter JSON Data:</label><br><br>
        <textarea id="json_data" name="json_data" rows="20" cols="100"></textarea><br><br>
        <input type="submit" value="Generate JSON Payloads">
    </form>
</body>
</html>
