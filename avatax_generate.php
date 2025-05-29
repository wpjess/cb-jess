<?php
// Get form data
$companyName = htmlspecialchars($_POST['company_name']);

// Get security credentials and Base64 encode them
$securityUsername = htmlspecialchars($_POST['security_username']);
$securityPassword = htmlspecialchars($_POST['security_password']);
$securityCredentials = $securityUsername . ':' . $securityPassword;
$encodedCredentials = base64_encode($securityCredentials);

// Ship From address
$shipFromAddress1 = htmlspecialchars($_POST['ship_from_address1']);
$shipFromAddress2 = htmlspecialchars($_POST['ship_from_address2']);
$shipFromCity = htmlspecialchars($_POST['ship_from_city']);
$shipFromState = htmlspecialchars($_POST['ship_from_state']);
$shipFromZip = htmlspecialchars($_POST['ship_from_zip']);
$shipFromCountry = htmlspecialchars($_POST['ship_from_country']);

// Ship To address
$shipToAddress1 = htmlspecialchars($_POST['ship_to_address1']);
$shipToAddress2 = htmlspecialchars($_POST['ship_to_address2']);
$shipToCity = htmlspecialchars($_POST['ship_to_city']);
$shipToState = htmlspecialchars($_POST['ship_to_state']);
$shipToZip = htmlspecialchars($_POST['ship_to_zip']);
$shipToCountry = htmlspecialchars($_POST['ship_to_country']);

// Line item details
$price = htmlspecialchars($_POST['price']);
$quantity = htmlspecialchars($_POST['quantity']);
$itemCode = htmlspecialchars($_POST['item_code']);
$taxCode = htmlspecialchars($_POST['tax_code']);

// Create the PHP code
$phpCode = "<?php\n";
$phpCode .= "// Suppress deprecation warnings\n";
$phpCode .= "error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);\n\n";
$phpCode .= "// Include the AvaTaxClient library\n\n";
$phpCode .= "require __DIR__ . '/vendor/autoload.php';\n\n";
$phpCode .= "use Avalara\\AvaTaxClient;\n";
$phpCode .= "// Create a new client\n\n";
$phpCode .= "\$client = new Avalara\\AvaTaxClient('phpTestApp', '1.0', 'localhost', 'production');\n\n";
$phpCode .= "// Base64 encoded credentials: '{$encodedCredentials}' (from {$securityUsername}:{$securityPassword})\n";
$phpCode .= "\$client->withSecurity('{$securityUsername}', '{$securityPassword}');\n";
$phpCode .= "// Now, let's create a more complex transaction!\n\n";
$phpCode .= "\$tb = new Avalara\\TransactionBuilder(\$client, \"{$companyName}\", Avalara\\DocumentType::C_SALESORDER, 'B2C');\n\n";
$phpCode .= "\$tb->withAddress('ShipFrom', '{$shipFromAddress1}', '{$shipFromAddress2}', null, '{$shipFromCity}', '{$shipFromState}', '{$shipFromZip}', '{$shipFromCountry}')\n\n";
$phpCode .= "->withAddress('ShipTo', '{$shipToAddress1}', '{$shipToAddress2}', null, '{$shipToCity}', '{$shipToState}', '{$shipToZip}', '{$shipToCountry}')\n\n";
$phpCode .= "->withLine({$price}, {$quantity}, '{$itemCode}', \"{$taxCode}\")\n\n";
$phpCode .= "->withLineAddress(Avalara\\TransactionAddressType::C_SHIPFROM, '{$shipFromAddress1}', '{$shipFromAddress2}', null, '{$shipFromCity}', '{$shipFromState}', '{$shipFromZip}', '{$shipFromCountry}')\n\n";
$phpCode .= "->withLineAddress(Avalara\\TransactionAddressType::C_SHIPTO, '{$shipToAddress1}', '{$shipToAddress2}', null, '{$shipToCity}', '{$shipToState}', '{$shipToZip}', '{$shipToCountry}');\n";
$phpCode .= "// Create the transaction\n\n";
$phpCode .= "\$transaction = \$tb->create();\n";
$phpCode .= "echo json_encode(\$transaction, JSON_PRETTY_PRINT);";

// Return the generated PHP code without HTML encoding
header('Content-Type: text/plain'); // Set the content type to plain text
echo $phpCode;
?>