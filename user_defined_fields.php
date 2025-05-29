<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Defined Fields</title>
    <style>
        html { height: 100%; }
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #fff;
            font-family: "Figtree", sans-serif;
            background-image: url('/images/treebg.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            height: 100%;
        }
        .content { max-width: 1000px; margin: 40px auto; word-wrap: break-word; height: 90%; position: relative; }
        h1 {
            text-align: center;
        }
        .row {
            margin-bottom: 15px;
        }
        .form { max-width: 700px; margin: 0 auto 100px; }
        label {
            display: block;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
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
            opacity: .7;
        }
        .output-container {
            background: #f8f8f8;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            font-family: monospace;
            cursor: pointer;
            user-select: all;
            margin-bottom:80px;
        }
        .footer {
            position: relative;
            bottom: 40px;
            left: 0;
        }
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
    <h1>User Defined Fields</h1>
    <p style="text-align:center; margin-bottom:40px;">Enter details below to generate the User Defined Fields mapping.</p>

    <form method="POST" class="form">
        <div class="row">
            <label for="source_table">Source Table:</label>
            <input type="text" id="source_table" name="source_table" required>
        </div>

        <div class="row">
            <label for="source_column">Source Column:</label>
            <input type="text" id="source_column" name="source_column" required>
        </div>

        <div class="row">
            <label for="grid_name">Grid Name to Map To:</label>
            <input type="text" id="grid_name" name="grid_name" required>
        </div>

        <div class="row">
            <label for="row_group">Row Group:</label>
            <input type="number" id="row_group" name="row_group" required>
        </div>

        <button type="submit" class="submit-btn">Generate Mapping</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $source_table = htmlspecialchars($_POST["source_table"]);
        $source_column = htmlspecialchars($_POST["source_column"]);
        $grid_name = htmlspecialchars($_POST["grid_name"]);
        $row_group = htmlspecialchars($_POST["row_group"]);

        // Generate the output lines
        $output = [
            "array(\"$source_table\",\"ROWID\",\"USER_DEFINED_FIELDS\",\"ROW_ID\",\"\",\"$row_group\",\"\")",
            "array(\"$source_table\",\"\",\"USER_DEFINED_FIELDS\",\"WEB_TABLE\",\"$grid_name\",\"$row_group\",\"\")",
            "array(\"$source_table\",\"\",\"USER_DEFINED_FIELDS\",\"FIELD\",\"$source_column\",\"$row_group\",\"\")",
            "array(\"$source_table\",\"$source_column\",\"USER_DEFINED_FIELDS\",\"VALUE\",\"\",\"$row_group\",\"\")"
        ];
    ?>

    <h2>Generated Mapping</h2>
    <div class="output-container" id="output-text" onclick="copyToClipboard()">
        <?php 
        $count = count($output);
        for ($i = 0; $i < $count; $i++) {
            // Add a comma to each line except the last one
            if ($i < $count - 1) {
                echo htmlspecialchars($output[$i] . ",") . "<br>";
            } else {
                echo htmlspecialchars($output[$i]) . "<br>";
            }
        }
        ?>
    </div>

    <script>
        function copyToClipboard() {
            var text = document.getElementById("output-text").innerText;
            navigator.clipboard.writeText(text).then(function() {
                alert("Copied to clipboard!");
            }).catch(function(err) {
                console.error("Error copying text: ", err);
            });
        }
    </script>

    <?php } ?>

    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html>