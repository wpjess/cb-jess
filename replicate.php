<!DOCTYPE html>
<html>
<head>
    <title>Table Replication Command Generator</title>
    <style type="text/css">
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        body { 
            font-family: "Figtree", sans-serif; 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
            position: relative;
            height: 100%;
        }
        .row { margin-top: 10px; }
        .row label { display: inline-block; width: 120px; }
        .row input, .row textarea { padding: 5px; }
        .footer { position: absolute; bottom: 0; left: 0; }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
        .content { 
            max-width: 1000px; 
            margin: 40px auto; 
            word-wrap: break-word; 
            height: 90%; 
            position: relative; 
        }
        pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Generate Table Replication Command</h1>
        <form method="post" action="replicate-results.php">
            <div class="row">
                <label for="store_url">Store URL:</label>
                <input type="text" id="store_url" name="store_url" required><br>
            </div>

            <div class="row">
                <label for="store_name">Store Name:</label>
                <input type="text" id="store_name" name="store_name" required><br>
            </div>

            <div class="row">
                <label for="table_name">Table Name:</label>
                <input type="text" id="table_name" name="table_name" required><br>
            </div>

            <div class="row">
                <label for="token">Token:</label>
                <textarea id="token" name="token" rows="4" cols="50" required></textarea><br>
            </div>

            <div class="row">
                <label for="truncate">Truncate:</label>
                <select id="truncate" name="truncate">
                    <option value="false">false</option>
                    <option value="true">true</option>
                </select>
            </div>
            <br /><br />

            <button type="submit">Generate Curl Command</button>
        </form>
        <br /><br /><br /><br />
        <div class="footer">
            <?php include 'footer.php'; ?>
        </div>
    </div>

    <script>
    // Function to capitalize the text input
    function capitalizeInput(elementId) {
        var input = document.getElementById(elementId);
        input.addEventListener("input", function() {
            input.value = input.value.toUpperCase();
        });
    }

    // Capitalize table name
    capitalizeInput("table_name");
    </script>
</body>
</html>