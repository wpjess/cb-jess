<?php
function process_data($data, $labels) {
    echo "<table border='1' width='100%' cellpadding='0' cellspacing='0'>";
    for ($i = 0; $i < count($labels); $i++) {
        echo "<tr><th>" . htmlspecialchars($labels[$i]) . "</th><td>" . htmlspecialchars($data[$i] ?? '') . "</td></tr>";
    }
    echo "</table>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['return_string'])) {
        $raw_data = $_POST['return_string'];

        echo "<pre>Raw Data:\n" . htmlspecialchars($raw_data) . "\n</pre>";

        // Split data using "<<" delimiter
        $splitret = explode("<<>>", $raw_data);
        foreach ($splitret as $si => $svalue) {
            // Split each part using "{*}" delimiter
            $splitex = explode("{*}", $svalue);

            // Check if there are enough parts in the splitex array
            if (count($splitex) < 2) {
                echo "Error: Insufficient data in splitex array.<br>";
                continue;
            }

            // Process "ORDER" table
            $labels = [
                'XMSTRING',
                'Company Name',
                'Accpac Username',
                'Accpac Password',
                'Online Order Number',
                'Order Date',
                'Customer Code',
                'Ship-to Code (empty = Use Billing Address)',
                'Default Warehouse',
                'PO Number',
                'Order Description',
                'Order Comments',
                'Order Reference',
                'Currency Code',
                'Type (1=Active, 2=Future, 3=Standing, 4=Quote)',
                'Quote Expiry Date',
                'Quote Number (for convert Quote to Order)',
                'Ship Via Code',
                'Ship Via Description',
                'Tracking Number',
                'Ship-to (Shipping) Details',
                'Customer (Billing) Details',
                'Salesperson Split',
                'Order Detail Lines',
                'Order Unique Id to Edit',
                'On Hold (0=No, 1=Yes)',
                'Order Terms',
                'Payment Details',
                'Pre Authorization Details',
                'Token Details',
                'Timeout (in seconds)',
                'Order Exchange Rate',
                'Order Optional Fields',
                'Expected Shipping Date',
                'Request Date',
                'Delivery Mode (X3)',
                'Create Customer',
                'Customer Defaults',
                'JSON Response Flag',
                'X3 Settings',
                'X3 Inv Elements'
            ];

            // Customer and Ship-to details should be split properly
            $customer_labels = [
                'Name', 'Address 1', 'Address 2', 'Address 3', 'Address 4', 'City', 'Zip/Postcode', 'State/Region', 'Country', 'Phone Number', 'Fax Number', 'Email Address', 'Contact Person Name', 'Contact Person Phone', 'Contact Person Fax', 'Contact Person Email'
            ];

            $shipto_labels = [
                'Ship-to Name', 'Ship-to Address 1', 'Ship-to Address 2', 'Ship-to Address 3', 'Ship-to Address 4', 'Ship-to City', 'Ship-to Zip/Postcode', 'Ship-to State/Region', 'Ship-to Country', 'Ship-to Phone Number', 'Ship-to Fax Number', 'Ship-to Email Address', 'Ship-to Contact Person Name', 'Ship-to Contact Person Phone', 'Ship-to Contact Person Fax', 'Ship-to Contact Person Email'
            ];

            // Combine the main labels with customer and ship-to details
            $order_labels = array_merge($labels, $customer_labels, $shipto_labels);

            // Display the data with appropriate labels
            process_data($splitex, $order_labels);
        }
    }
}
?>
