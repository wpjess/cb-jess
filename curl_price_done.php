<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $domainName = htmlspecialchars($_POST['domainName']);
    $virtualItemCode = htmlspecialchars($_POST['virtualItemCode']);
    $itemNumber = htmlspecialchars($_POST['itemNumber']);
    $quantity = intval($_POST['quantity']);
    $unitOfMeasure = htmlspecialchars($_POST['unitOfMeasure']);
    $isConfiguratorItem = intval($_POST['isConfiguratorItem']);

    // Construct the cURL command
    $curlCommand = "curl '{$domainName}/ajax/variants/variantDetails' \\\n"
                 . "  -H 'content-type: application/x-www-form-urlencoded; charset=UTF-8' \\\n"
                 . "  -H 'x-requested-with: XMLHttpRequest' \\\n"
                 . "  --data-raw 'virtaulItemCode={$virtualItemCode}&itemnos%5B%5D={$itemNumber}&quantity={$quantity}&unit_of_measure={$unitOfMeasure}::1&isConfiguratorItem={$isConfiguratorItem}'";

    // Output the cURL command or redirect to another page
    echo "<pre>$curlCommand</pre>";
    // Uncomment to redirect instead of displaying the command
    // header("Location: anotherPage.php");
}
?>
