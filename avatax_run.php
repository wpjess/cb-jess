<?php
// This script simulates running the AvaTax PHP code

// Get form data
$companyName = htmlspecialchars($_POST['company_name']);
$securityUsername = htmlspecialchars($_POST['security_username']);
$securityPassword = htmlspecialchars($_POST['security_password']);
$shipFromAddress1 = htmlspecialchars($_POST['ship_from_address1']);
$shipFromAddress2 = htmlspecialchars($_POST['ship_from_address2']);
$shipFromCity = htmlspecialchars($_POST['ship_from_city']);
$shipFromState = htmlspecialchars($_POST['ship_from_state']);
$shipFromZip = htmlspecialchars($_POST['ship_from_zip']);
$shipFromCountry = htmlspecialchars($_POST['ship_from_country']);
$shipToAddress1 = htmlspecialchars($_POST['ship_to_address1']);
$shipToAddress2 = htmlspecialchars($_POST['ship_to_address2']);
$shipToCity = htmlspecialchars($_POST['ship_to_city']);
$shipToState = htmlspecialchars($_POST['ship_to_state']);
$shipToZip = htmlspecialchars($_POST['ship_to_zip']);
$shipToCountry = htmlspecialchars($_POST['ship_to_country']);
$price = floatval($_POST['price']);
$quantity = intval($_POST['quantity']);
$itemCode = htmlspecialchars($_POST['item_code']);
$taxCode = htmlspecialchars($_POST['tax_code']);

// Check for the existence of the Avalara client
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo '<div style="background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 4px; margin-bottom: 15px;">';
    echo '<strong>Notice:</strong> AvaTax SDK not installed. Showing a simulated response.';
    echo '</div>';
    
    // Generate a simulated API response
    simulateResponse($companyName, $securityUsername, $securityPassword, 
        $shipFromAddress1, $shipFromAddress2, $shipFromCity, $shipFromState, $shipFromZip, $shipFromCountry,
        $shipToAddress1, $shipToAddress2, $shipToCity, $shipToState, $shipToZip, $shipToCountry,
        $price, $quantity, $itemCode, $taxCode);
    exit;
}

// If the SDK is installed, try to execute the real code
try {
    // Include the autoloader
    require_once __DIR__ . '/vendor/autoload.php';
    
    // Check if the Avalara SDK is properly installed
    if (!class_exists('Avalara\\AvaTaxClient')) {
        throw new Exception("Avalara SDK classes not found. Please install the SDK using Composer.");
    }
    
    // Create a new AvaTax client
    $client = new Avalara\AvaTaxClient('phpTestApp', '1.0', 'localhost', 'production');
    $client->withSecurity($securityUsername, $securityPassword);
    
    // Create a transaction builder object
    $tb = new Avalara\TransactionBuilder($client, $companyName, Avalara\DocumentType::C_SALESORDER, 'B2C');
    
    // Add addresses and line items
    $tb->withAddress('ShipFrom', $shipFromAddress1, $shipFromAddress2, null, $shipFromCity, $shipFromState, $shipFromZip, $shipFromCountry)
       ->withAddress('ShipTo', $shipToAddress1, $shipToAddress2, null, $shipToCity, $shipToState, $shipToZip, $shipToCountry)
       ->withLine($price, $quantity, $itemCode, $taxCode);
    
    // Attempt to create the transaction
    $transaction = $tb->create();
    
    // Output the result
    echo '<pre>' . json_encode($transaction, JSON_PRETTY_PRINT) . '</pre>';
    
} catch (Exception $e) {
    // If there's an error, show it and a simulated response
    echo '<div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 15px;">';
    echo '<strong>Error:</strong> ' . htmlspecialchars($e->getMessage());
    echo '</div>';
    
    echo '<div style="background-color: #fff3cd; color: #856404; padding: 15px; border-radius: 4px; margin-bottom: 15px;">';
    echo '<strong>Notice:</strong> Showing a simulated response instead.';
    echo '</div>';
    
    // Generate a simulated API response
    simulateResponse($companyName, $securityUsername, $securityPassword, 
        $shipFromAddress1, $shipFromAddress2, $shipFromCity, $shipFromState, $shipFromZip, $shipFromCountry,
        $shipToAddress1, $shipToAddress2, $shipToCity, $shipToState, $shipToZip, $shipToCountry,
        $price, $quantity, $itemCode, $taxCode);
}

/**
 * Generate a simulated AvaTax API response
 */
function simulateResponse($companyName, $securityUsername, $securityPassword, 
    $shipFromAddress1, $shipFromAddress2, $shipFromCity, $shipFromState, $shipFromZip, $shipFromCountry,
    $shipToAddress1, $shipToAddress2, $shipToCity, $shipToState, $shipToZip, $shipToCountry,
    $price, $quantity, $itemCode, $taxCode) {
    
    // Calculate the total amount
    $totalAmount = $price * $quantity;
    
    // Calculate a simulated tax rate based on the destination state
    $taxRates = [
        'AL' => 0.04, 'AK' => 0.00, 'AZ' => 0.056, 'AR' => 0.065, 'CA' => 0.0725, 
        'CO' => 0.029, 'CT' => 0.0635, 'DE' => 0.00, 'FL' => 0.06, 'GA' => 0.04,
        'HI' => 0.04, 'ID' => 0.06, 'IL' => 0.0625, 'IN' => 0.07, 'IA' => 0.06,
        'KS' => 0.065, 'KY' => 0.06, 'LA' => 0.0445, 'ME' => 0.055, 'MD' => 0.06,
        'MA' => 0.0625, 'MI' => 0.06, 'MN' => 0.06875, 'MS' => 0.07, 'MO' => 0.04225,
        'MT' => 0.00, 'NE' => 0.055, 'NV' => 0.0685, 'NH' => 0.00, 'NJ' => 0.06625,
        'NM' => 0.05125, 'NY' => 0.04, 'NC' => 0.0475, 'ND' => 0.05, 'OH' => 0.0575,
        'OK' => 0.045, 'OR' => 0.00, 'PA' => 0.06, 'RI' => 0.07, 'SC' => 0.06,
        'SD' => 0.045, 'TN' => 0.07, 'TX' => 0.0625, 'UT' => 0.0485, 'VT' => 0.06,
        'VA' => 0.053, 'WA' => 0.065, 'WV' => 0.06, 'WI' => 0.05, 'WY' => 0.04
    ];
    
    // Get the tax rate for the destination state, default to 8% if not found
    $taxRate = isset($taxRates[$shipToState]) ? $taxRates[$shipToState] : 0.08;
    
    // Apply local tax (simulated)
    $localTaxRate = 0.02; // 2% local tax
    $totalTaxRate = $taxRate + $localTaxRate;
    
    // Calculate tax
    $tax = round($totalAmount * $totalTaxRate, 2);
    
    // Create a document code (transaction ID)
    $documentCode = strtoupper(substr(md5(uniqid()), 0, 8));
    
    // Generate transaction date
    $transactionDate = date('Y-m-d');
    
    // Create the simulated response
    $response = [
        "id" => mt_rand(1000000000, 9999999999),
        "code" => $documentCode,
        "companyId" => mt_rand(1000, 9999),
        "date" => $transactionDate,
        "status" => "Temporary",
        "type" => "SalesOrder",
        "batchCode" => "",
        "currencyCode" => "USD",
        "customerUsageType" => "B2C",
        "entityUseCode" => "",
        "customerVendorCode" => "",
        "customerCode" => "CUST-" . mt_rand(1000, 9999),
        "exemptNo" => "",
        "reconciled" => false,
        "locationCode" => "",
        "reportingLocationCode" => "",
        "purchaseOrderNo" => "",
        "referenceCode" => "",
        "salespersonCode" => "",
        "taxOverrideType" => "None",
        "taxOverrideAmount" => 0,
        "taxOverrideReason" => "",
        "totalAmount" => $totalAmount,
        "totalExempt" => 0,
        "totalDiscount" => 0,
        "totalTax" => $tax,
        "totalTaxable" => $totalAmount,
        "totalTaxCalculated" => $tax,
        "adjustmentReason" => "NotAdjusted",
        "adjustmentDescription" => "",
        "locked" => false,
        "region" => $shipToState,
        "country" => $shipToCountry,
        "version" => 1,
        "softwareVersion" => "22.1.1.0",
        "originAddressId" => mt_rand(1000000, 9999999),
        "destinationAddressId" => mt_rand(1000000, 9999999),
        "exchangeRateEffectiveDate" => $transactionDate,
        "exchangeRate" => 1,
        "isSellerImporterOfRecord" => false,
        "description" => "",
        "email" => "",
        "businessIdentificationNo" => "",
        "modifiedDate" => date('Y-m-d\TH:i:s'),
        "modifiedUserId" => mt_rand(1000, 9999),
        "taxDate" => $transactionDate,
        "lines" => [
            [
                "id" => mt_rand(10000, 99999),
                "transactionId" => mt_rand(1000000, 9999999),
                "lineNumber" => "1",
                "boundaryOverrideId" => 0,
                "customerUsageType" => "",
                "entityUseCode" => "",
                "description" => "Product " . $itemCode,
                "destinationAddressId" => mt_rand(1000000, 9999999),
                "originAddressId" => mt_rand(1000000, 9999999),
                "discountAmount" => 0,
                "discountTypeId" => 0,
                "exemptAmount" => 0,
                "exemptCertId" => 0,
                "exemptNo" => "",
                "isItemTaxable" => true,
                "isSSTP" => false,
                "itemCode" => $itemCode,
                "lineAmount" => $totalAmount,
                "quantity" => $quantity,
                "ref1" => "",
                "ref2" => "",
                "reportingDate" => $transactionDate,
                "revAccount" => "",
                "sourcing" => "Destination",
                "tax" => $tax,
                "taxableAmount" => $totalAmount,
                "taxCalculated" => $tax,
                "taxCode" => $taxCode,
                "taxCodeId" => mt_rand(1000, 9999),
                "taxDate" => $transactionDate,
                "taxEngine" => "",
                "taxOverrideType" => "None",
                "businessIdentificationNo" => "",
                "taxOverrideAmount" => 0,
                "taxOverrideReason" => "",
                "taxIncluded" => false,
                "details" => [
                    [
                        "id" => mt_rand(1000000, 9999999),
                        "transactionLineId" => mt_rand(1000000, 9999999),
                        "transactionId" => mt_rand(1000000, 9999999),
                        "addressId" => mt_rand(1000000, 9999999),
                        "country" => $shipToCountry,
                        "region" => $shipToState,
                        "countyFIPS" => "",
                        "stateFIPS" => "",
                        "exemptAmount" => 0,
                        "exemptReasonId" => 0,
                        "inState" => true,
                        "jurisCode" => "STATE",
                        "jurisName" => $shipToState,
                        "jurisdictionId" => mt_rand(10000, 99999),
                        "signatureCode" => "",
                        "stateAssignedNo" => "",
                        "jurisType" => "State",
                        "jurisdictionType" => "State",
                        "nonTaxableAmount" => 0,
                        "nonTaxableRuleId" => 0,
                        "nonTaxableType" => "None",
                        "rate" => $taxRate,
                        "rateRuleId" => mt_rand(1000000, 9999999),
                        "rateSourceId" => mt_rand(10000, 99999),
                        "serCode" => "",
                        "sourcing" => "Destination",
                        "tax" => round($totalAmount * $taxRate, 2),
                        "taxableAmount" => $totalAmount,
                        "taxType" => "Sales",
                        "taxSubTypeId" => "S",
                        "taxTypeGroupId" => "SalesAndUse",
                        "taxName" => "State Sales Tax"
                    ],
                    [
                        "id" => mt_rand(1000000, 9999999),
                        "transactionLineId" => mt_rand(1000000, 9999999),
                        "transactionId" => mt_rand(1000000, 9999999),
                        "addressId" => mt_rand(1000000, 9999999),
                        "country" => $shipToCountry,
                        "region" => $shipToState,
                        "countyFIPS" => "",
                        "stateFIPS" => "",
                        "exemptAmount" => 0,
                        "exemptReasonId" => 0,
                        "inState" => true,
                        "jurisCode" => "CITY",
                        "jurisName" => $shipToCity,
                        "jurisdictionId" => mt_rand(10000, 99999),
                        "signatureCode" => "",
                        "stateAssignedNo" => "",
                        "jurisType" => "City",
                        "jurisdictionType" => "City",
                        "nonTaxableAmount" => 0,
                        "nonTaxableRuleId" => 0,
                        "nonTaxableType" => "None",
                        "rate" => $localTaxRate,
                        "rateRuleId" => mt_rand(1000000, 9999999),
                        "rateSourceId" => mt_rand(10000, 99999),
                        "serCode" => "",
                        "sourcing" => "Destination",
                        "tax" => round($totalAmount * $localTaxRate, 2),
                        "taxableAmount" => $totalAmount,
                        "taxType" => "Sales",
                        "taxSubTypeId" => "S",
                        "taxTypeGroupId" => "SalesAndUse",
                        "taxName" => "City Sales Tax"
                    ]
                ],
                "nonPassthroughDetails": [],
                "lineLocationTypes": [
                    "ShipFrom",
                    "ShipTo"
                ],
                "parameters": {},
                "hsCode": "",
                "costInsuranceFreight": 0,
                "vatCode": "",
                "vatNumberTypeId": 0
            ]
        ],
        "addresses": [
            [
                "id" => mt_rand(1000000, 9999999),
                "transactionId" => mt_rand(1000000, 9999999),
                "boundaryLevel" => "Address",
                "line1" => $shipFromAddress1,
                "line2" => $shipFromAddress2,
                "line3" => "",
                "city" => $shipFromCity,
                "region" => $shipFromState,
                "postalCode" => $shipFromZip,
                "country" => $shipFromCountry,
                "taxRegionId" => mt_rand(1000, 9999),
                "latitude" => "",
                "longitude" => ""
            ],
            [
                "id" => mt_rand(1000000, 9999999),
                "transactionId" => mt_rand(1000000, 9999999),
                "boundaryLevel" => "Address",
                "line1" => $shipToAddress1,
                "line2" => $shipToAddress2,
                "line3" => "",
                "city" => $shipToCity,
                "region" => $shipToState,
                "postalCode" => $shipToZip,
                "country" => $shipToCountry,
                "taxRegionId" => mt_rand(1000, 9999),
                "latitude" => "",
                "longitude" => ""
            ]
        ],
        "locationTypes": [
            "ShipFrom",
            "ShipTo"
        ],
        "summary": [
            [
                "country" => $shipToCountry,
                "region" => $shipToState,
                "jurisType" => "State",
                "jurisCode" => "STATE",
                "jurisName" => $shipToState,
                "taxAuthorityType" => 45,
                "stateAssignedNo" => "",
                "taxType" => "Sales",
                "taxSubType" => "S",
                "taxName" => "State Sales Tax",
                "rateType" => "General",
                "taxable" => $totalAmount,
                "rate" => $taxRate,
                "tax" => round($totalAmount * $taxRate, 2),
                "taxCalculated" => round($totalAmount * $taxRate, 2),
                "nonTaxable" => 0,
                "exemption" => 0
            ],
            [
                "country" => $shipToCountry,
                "region" => $shipToState,
                "jurisType" => "City",
                "jurisCode" => "CITY",
                "jurisName" => $shipToCity,
                "taxAuthorityType" => 45,
                "stateAssignedNo" => "",
                "taxType" => "Sales",
                "taxSubType" => "S",
                "taxName" => "City Sales Tax",
                "rateType" => "General",
                "taxable" => $totalAmount,
                "rate" => $localTaxRate,
                "tax" => round($totalAmount * $localTaxRate, 2),
                "taxCalculated" => round($totalAmount * $localTaxRate, 2),
                "nonTaxable" => 0,
                "exemption" => 0
            ]
        ],
        "parameters": {}
    ];
    
    // Output the simulated response
    echo '<pre>' . json_encode($response, JSON_PRETTY_PRINT) . '</pre>';
}
?>