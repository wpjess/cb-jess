<?php
// Get the form data
$transactionPayload = json_decode($_POST['transactionPayload'], true);
$warehouse = $_POST['warehouse'];
$salesLocation = $_POST['salesLocation'];
$shipToCode = $_POST['shipToCode'];
$orderNumber = $_POST['orderNumber'];

// Extract necessary data from the transaction payload
$billTo = $transactionPayload['messages']['request']['billTo'] ?? [];
$shipTo = $transactionPayload['messages']['request']['shipTo'] ?? [];
$orderLines = $transactionPayload['messages']['request']['orderLines'] ?? [];
$amount = $transactionPayload['messages']['request']['amount'] ?? 0;

// Prepare the createOrder JSON payload
$createOrderPayload = [
    "customerCode" => $transactionPayload['messages']['request']['customerId'] ?? null,
    "orderNumber" => $orderNumber ?? "WEB-2-0000000000",
    "orderType" => "WEB",
    "salesLocation" => $salesLocation,
    "warehouse" => $warehouse,
    "unitOfMeasureField" => "STU",
    "holdStatus" => "1",
    "orderDate" => $transactionPayload['createdOn'],
    "deliveryMode" => "CMB",
    "shipVia" => "CMB",
    "paymentTerms" => "NET30",
    "billTo" => [
        "addressTo" => $billTo['name'] ?? null,
        "addressLines" => $billTo['addressLines'] ?? [],
        "city" => $billTo['city'] ?? null,
        "state" => $billTo['state'] ?? null,
        "zip" => $billTo['postCode'] ?? null,
        "country" => $billTo['country'] ?? null
    ],
    "shipTo" => [
        "addressCode" => $shipToCode,
        "addressTo" => $shipTo['name'] ?? null,
        "addressLines" => $shipTo['addressLines'] ?? [],
        "city" => $shipTo['city'] ?? null,
        "state" => $shipTo['state'] ?? null,
        "zip" => $shipTo['postCode'] ?? null,
        "country" => $shipTo['country'] ?? null
    ],
    "customFields" => [
        [
            "screen" => "SOH0_1",
            "field" => "CUSORDREF",
            "value" => $transactionPayload['messages']['request']['orderId'] ?? null
        ]
    ],
    "invoiceElements" => [
        [
            "screen" => "SOH3_5",
            "field" => "INVDTAAMT",
            "line" => "0",
            "value" => number_format($amount / 100, 2)
        ]
    ],
    "orderLines" => array_map(function ($line) use ($warehouse) {
        return [
            "productCode" => $line['itemNo'],
            "productDescription" => $line['description'],
            "unitOfMeasure" => "CS",
            "quantity" => $line['quantity'],
            "unitConversion" => 1,
            "discountPercentage" => 0,
            "warehouse" => $warehouse
        ];
    }, $orderLines)
];

// Convert the payload to JSON and display it
echo "<pre>" . json_encode($createOrderPayload, JSON_PRETTY_PRINT) . "</pre>";
