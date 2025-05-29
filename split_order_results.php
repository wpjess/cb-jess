<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parsed Data</title>
    <style type="text/css">
        table { font-size:12px; font-family:arial, sans-serif; border-top: 1px solid #000; }
        tr { border:0; }
        td { border-left:1px solid #000; padding:3px 5px; border-bottom:1px solid #000; }
    </style>
</head>
<body>

<?php
// Your parameter string
$params = 'cmd /C C:\\Programs\\XM\\SymphonyClient\\XMOrder.exe "C89XVfUt82c5toChPhpehHHGF9jl8-98asjerAHDF" "TREDAT" "ADMIN" "LOMAAV45" "TCA0008365" "20240326" "WEBADMIN" "" "1" "TESTING WEBSTORE CC" "" "DO NOT SHIP - TESTING WEBSTORE QUOTE TO ORDER ON WEBSTORE VIA CC" "" "USD" "1" "" "QT03496" "UPSG" "" "" "WEBSTORE ADMINISTRATORS{*}1212 N Miller Dr{*}Robert\'s Address for Testing CC Processing{*}{*}{*}Claremore{*}74017{*}OK{*}US{*}{*}{*}{*}{*}{*}{*}robert@trece.com{*}<<>>" "WEBSTORE ADMINISTRATORS{*}1212 N Miller Dr{*}Robert\'s Address for Testing CC Processing{*}{*}{*}Claremore{*}74017{*}OK{*}US{*}{*}{*}{*}{*}{*}{*}robert@trece.com{*}b2b<<>>" "GLIPM{*}100{*}{*}0{*}{*}0{*}{*}0{*}{*}0<<>>" "1{*}MS/00-9999-01{*}{*}1{*}EA{*}DEFAUL{*}0{*}{*}0{*}1.000000{*}1{*}{*}{*}0.000000{*}{*}{*}{*}{*}{*}{*}0{*}{*}{*}{*}{*}1<<>>" "" "" "C0CARD" "" "" "" "10" "" "WEBID{*}rdavies@commercebuild.com<<>>" "20240321" "" "" "" "" "" "" "" "" ""';

// Split the parameter string into an array
$paramsArray = explode('" "', $params);

// Remove the first and last elements (cmd and empty string)
array_shift($paramsArray);
array_pop($paramsArray);

// Start building the HTML table
$html = '<table width="100%" cellpadding="0" cellspacing="0">
            <tbody>';

// Loop through each parameter value and insert it into the table
foreach ($paramsArray as $index => $value) {
    $html .= '<tr>
                <td>' . $index . '</td>';

    // Handle special cases for formatting
    if ($index == 0) {
        $html .= '<td width="14%" style="font-size:9px;">Installation Directory</td>';
    } elseif ($index == 1) {
        $html .= '<td style="font-size:9px;">Argument Count (Starts at 0)</td>';
    } elseif ($index == 20 || $index == 21) {
        // Insert the ship-to details here
        $html .= '<td style="font-size:9px;">Ship-to (Shipping) Details</td>
                  <td style="font-size:9px;">'; // Open table cell for ship-to details
        // Extract ship-to details from the array
        $shipToDetails = $paramsArray[$index];

        // Split ship-to details into key-value pairs
        $shipToPairs = explode('{*}', $shipToDetails);

        // Prepare HTML for ship-to details
        $html .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:none;border-bottom:none;"><tbody>';
        foreach ($shipToPairs as $shipToIndex => $shipToValue) {
            $html .= '<tr>
                        <td width="1%">' . $shipToIndex . '</td>
                        <td width="14%" style="font-size:9px;">' . ($shipToIndex === 0 ? 'Ship-to/Shipping Name' : 'Address ' . $shipToIndex) . '</td>
                        <td width="85%" style="font-size:9px;">' . htmlentities($shipToValue) . '</td>
                    </tr>
                    <tr>
                        <td colspan="3" height="1" bgcolor="#000000"></td>
                    </tr>';
        }
        $html .= '</tbody></table>'; // Close the ship-to details table
        $html .= '</td>'; // Close table cell for ship-to details
    } elseif ($index == 22 || $index == 23) {
        $html .= '<td style="font-size:9px;">Customer (Billing) Details</td>';
    } elseif ($index == 32) {
        $html .= '<td style="font-size:9px;">Order Optional Fields</td>';
    } elseif ($index == 33) {
        $html .= '<td style="font-size:9px;">Expected Shipping Date</td>';
    } else {
        $html .= '<td style="font-size:9px;"></td>';
    }

    $html .= '<td style="font-size:9px;">' . htmlentities($value) . '</td>
            </tr>
            <tr>
                <td colspan="3" height="1" bgcolor="#000000"></td>
            </tr>';
}

// Close the table
$html .= '</tbody>
        </table>';

// Output the HTML table
echo $html;
?>


</body>
</html>
