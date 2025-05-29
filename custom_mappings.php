<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Field Mappings</title>
    <style>
        html { height:100%; }
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

         body { 
            background:#fff;
            font-family: "Figtree", sans-serif; 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
            position:relative;
            height:100%;
        }
        .content { max-width:1000px; margin:40px auto; word-wrap: break-word; height:90%; position:relative; }
        h1 {
            text-align: center;
        }
        .row {
            margin-bottom: 15px;
        }
        .form { max-width:700px; margin: 0 auto 100px; }
        label {
            display: block;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="radio"] { max-width:30px; }
        .radio-group label { display:inline-block; width:auto; }
        .submit-btn {
            background: #B46541;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;

        }
        .submit-btn:hover {
            background: #B46541;
            opacity:.7;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            margin-bottom:80px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #B46541;
            color: white;
        }
        .footer { position: relative; bottom:40px; left:0;  }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
    </style>
</head>
<body>
<div class="content">
    <h1>Product Custom Field Mappings</h1>
    <p style="text-align:center; margin-bottom:40px;">This presently creates mappings for ICITEM.  It might need adjustments if pulling from other tables/columns
    <form method="POST" class="form">
        <div class="row">
            <label for="source_table">Source Table Name:</label>
            <input type="text" id="source_table" name="source_table" required>
        </div>

        <div class="row">
            <label for="source_column">Source Column Name:</label>
            <input type="text" id="source_column" name="source_column" required>
        </div>

        <div class="row">
            <label for="custom_field">Source Table:</label>
            <input type="text" id="custom_field" name="custom_field" required>
        </div>

        <div class="row">
            <label for="new_source_column">Source Column:</label>
            <input type="text" id="new_source_column" name="new_source_column" required>
        </div>

        <div class="row">
            <label for="row_group">Row Group Number:</label>
            <input type="number" id="row_group" name="row_group" required>
        </div>

        <button type="submit" class="submit-btn">Generate Mapping</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $source_table = htmlspecialchars($_POST["source_table"]);
        $source_column = htmlspecialchars($_POST["source_column"]);
        $custom_field = htmlspecialchars($_POST["custom_field"]);
        $new_source_column = htmlspecialchars($_POST["new_source_column"]);
        $row_group = htmlspecialchars($_POST["row_group"]);
        
        // Set default enabled value (since we removed the radio buttons)
        $enabled = "1"; // Default to enabled
    ?>
    
    <h2>Generated Custom Field Mappings</h2>
    <table>
        <thead>
            <tr>
                <th>Source Table</th>
                <th>Source Column</th>
                <th>Target Table</th>
                <th>Target Column</th>
                <th>Default Value</th>
                <th>Row Group</th>
                <th>Data Type</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $source_table; ?></td>
                <td>AUDTDATE</td>
                <td>PRODUCTS_CUSTOM_FIELD_PRODUCTS</td>
                <td>CREATED</td>
                <td></td>
                <td><?php echo $row_group; ?></td>
                <td>DATE(yyyyMMdd)</td>
            </tr>
            <tr>
                <td><?php echo $source_table; ?></td>
                <td>ITEMNO</td>
                <td>PRODUCTS_CUSTOM_FIELD_PRODUCTS</td>
                <td>ID</td>
                <td></td>
                <td><?php echo $row_group; ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo $source_table; ?></td>
                <td>AUDTDATE</td>
                <td>PRODUCTS_CUSTOM_FIELD_PRODUCTS</td>
                <td>UPDATED</td>
                <td></td>
                <td><?php echo $row_group; ?></td>
                <td>DATE(yyyyMMdd)</td>
            </tr>
            <tr>
                <td><?php echo $source_table; ?></td>
                <td>ITEMNO</td>
                <td>PRODUCTS_CUSTOM_FIELD_PRODUCTS</td>
                <td>ITEMNO</td>
                <td></td>
                <td><?php echo $row_group; ?></td>
                <td></td>
            </tr>
            <tr>
                <td><?php echo $source_table; ?></td>
                <td><?php echo $source_column; ?></td>
                <td>PRODUCTS_CUSTOM_FIELD_PRODUCTS</td>
                <td>VALUE</td>
                <td></td>
                <td><?php echo $row_group; ?></td>
                <td></td>
            </tr>
            <tr>
                <td>(BLANK)</td>
                <td>(BLANK)</td>
                <td>PRODUCTS_CUSTOM_FIELD_PRODUCTS</td>
                <td>ENABLED</td>
                <td><?php echo $enabled; ?></td>
                <td><?php echo $row_group; ?></td>
                <td></td>
            </tr>
            <tr>
                <td>(BLANK)</td>
                <td>(BLANK)</td>
                <td>PRODUCTS_CUSTOM_FIELD_PRODUCTS</td>
                <td>CUSTOM_FIELD_ID</td>
                <td><?php echo $custom_field; ?></td>
                <td><?php echo $row_group; ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <?php } ?>

    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html>