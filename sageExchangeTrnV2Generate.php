<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_data = $_POST['json_data'];
    $data = json_decode($input_data, true);

    if ($data) {
        // Extract the first name and last name from ccName for sageExchangeTrnV2
        $nameParts = explode(" ", $data["preAuthData"]["ccName"], 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : $firstName;

        // First JSON Payload (sageExchangeTrnV2)
        $first_json = [
            "customerCode" => $data["customerCode"],
            "amount" => round($data["preAuthData"]["preAuthAmount"], 1),
            "vanRef" => $data["preAuthData"]["responseCode"],
            "txnId" => $data["preAuthData"]["preAuthCode"],
            "txnType" => "02",
            "txnDate" => date("Y-m-d\TH:i:s\Z", strtotime($data["orderDate"])),
            "ccName" => $data["preAuthData"]["ccName"],
            "address" => [
                "city" => $data["billingDetails"]["city"],
                "state" => $data["billingDetails"]["state"],
                "zip" => $data["billingDetails"]["zip"],
                "country" => $data["billingDetails"]["country"],
                "addressLines" => [
                    $data["billingDetails"]["address1"],
                    $data["billingDetails"]["address2"],
                    ""
                ]
            ],
            "email" => $data["billingDetails"]["email"],
            "cardType" => "4",  // Assuming Visa is type 4; adapt this based on cardType
            "ccL4D" => substr($data["preAuthData"]["ccNumber"], -4),
            "ccExpiry" => $data["preAuthData"]["ccExpiry"],
            "ccMask" => $data["preAuthData"]["ccNumber"],
            "respCode" => $data["preAuthData"]["preAuthReference"],
            "respMsg" => $data["preAuthData"]["responseMessage"],
            "vcrType" => 2,
            "nickname" => "1LMQO3MOXV4VBFP",  // Example value
            "statusFlag" => 3,
            "processCode" => "SAGEPAYA",
            "currencyCode" => "USD",
            "warehouseCode" => $data["warehouse"],
            "paymentProcessor" => 1,
            "isOneTime" => false,
            "vaultId" => $data["preAuthData"]["preAuthCode"],
            "isUseBillToAddress" => true,
            "firstName" => $firstName,
            "lastName" => $lastName,
            "ref" => $data["preAuthData"]["documentNumber"],
            "documentNumber" => $data["preAuthData"]["documentNumber"],
            "dutyAmount" => 0,
            "nationalTax" => 0
        ];

        // Second JSON Payload (createOrder)
        $second_json = [
            "customerCode" => $data["customerCode"],
            "orderNumber" => $data["orderNumber"],
            "orderType" => "WEB",
            "salesLocation" => $data["salesLocation"],
            "warehouse" => $data["warehouse"],
            "unitOfMeasureField" => "STU",
            "taxRule" => $data["taxRule"],
            "holdStatus" => "1",
            "orderDate" => $data["orderDate"],
            "deliveryMode" => $data["deliveryMode"],
            "shipVia" => $data["shipVia"],
            "paymentTerms" => $data["paymentTerms"],
            "billTo" => [
                "addressTo" => $data["billingDetails"]["name"],
                "addressLines" => [
                    $data["billingDetails"]["address1"],
                    $data["billingDetails"]["address2"],
                    " ",
                    " "
                ],
                "city" => $data["billingDetails"]["city"],
                "state" => $data["billingDetails"]["state"],
                "zip" => $data["billingDetails"]["zip"],
                "country" => $data["billingDetails"]["country"]
            ],
            "shipTo" => [
                "addressTo" => $data["shipToDetails"]["name"],
                "addressLines" => [
                    $data["shipToDetails"]["address1"],
                    $data["shipToDetails"]["address2"],
                    " ",
                    " "
                ],
                "city" => $data["shipToDetails"]["city"],
                "state" => $data["shipToDetails"]["state"],
                "zip" => $data["shipToDetails"]["zip"],
                "country" => $data["shipToDetails"]["country"]
            ],
            "customFields" => array_map(function ($field) {
                return [
                    "screen" => $field["id1"],  // Map id1 to screen
                    "field" => $field["id2"],   // Map id2 to field
                    "value" => $field["value"]
                ];
            }, $data["customFields"]),

            "orderLines" => array_map(function ($line) use ($data) {
                return [
                    "productCode" => $line["itemCode"],
                    "productDescription" => $line["itemDesc"],
                    "unitOfMeasure" => $line["uom"],
                    "quantity" => $line["qty"],
                    "unitConversion" => 1,
                    "discountPercentage" => 0,  // Ensure discountPercentage is included
                    "warehouse" => $line["warehouse"],
                    "taxRule" => $data["taxRule"],
                    "taxCodes" => [$line["taxCode1"]]
                ];
            }, $data["orderLines"])
        ];

        // Display the two JSON payloads
        echo "<h1>createOrder:</h1>";
        echo '<pre>' . json_encode($second_json, JSON_PRETTY_PRINT) . '</pre>';

        echo "<h1>sageExchangeTrnV2:</h1>";
        echo '<pre>' . json_encode($first_json, JSON_PRETTY_PRINT) . '</pre>';
        
    } else {
        echo "Invalid JSON input!";
    }
}
?>
