<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
</head>
<body>
    <h1>Create Order</h1>
    <form action="create_order.php" method="post">
        <label for="transactionPayload">Transaction Payload (JSON):</label><br>
        <textarea id="transactionPayload" name="transactionPayload" rows="10" cols="50"></textarea><br><br>

        <label for="warehouse">Warehouse:</label>
        <input type="text" id="warehouse" name="warehouse"><br><br>

        <label for="salesLocation">Sales Location:</label>
        <input type="text" id="salesLocation" name="salesLocation"><br><br>

        <label for="shipToCode">Ship-to Code:</label>
        <input type="text" id="shipToCode" name="shipToCode"><br><br>

        <label for="orderNumber">Order Number: (example: WEB-2-0000001611)</label>
        <input type="text" id="orderNumber" name="orderNumber"><br><br>

        <input type="submit" value="Create Order">
    </form>
</body>
</html>
