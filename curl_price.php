<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate cURL command for item price</title>
    <style type="text/css">
        body, html { position: relative; height:100%; font-family: Arial, sans-serif; }
        
         body { 
            font-family: "Figtree", sans-serif; 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
            position:relative;
            height:100%;
        }
        .wrapper { max-width:1000px; margin:40px auto; height:90%; position:relative; }
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        textarea { min-height:800px; width:100%; border: 1px solid #555;}
        .footer { position: absolute; bottom:0; left:0; }
        .footer a {     
            font-size: 12px;
            text-decoration: underline;
            color: #000;
            letter-spacing: .5px;
            display: inline-block;
            margin-right: 25px; 
        } 
        .content { max-width:1000px; margin:40px auto; word-wrap: break-word; height:90%; position:relative; }
    </style>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-KRDNLFP9T6');
    </script>
</head>
<body>
    <div class="wrapper">
    <h1>Generate Command</h1>
    <form action="curl_price_done.php" method="post">
        <label for="domainName">Domain Name:</label>
        <input type="text" id="domainName" name="domainName" required><br><br>

        <label for="virtualItemCode">Virtual Item Code:</label>
        <input type="text" id="virtualItemCode" name="virtualItemCode" required><br><br>

        <label for="itemNumber">Item Number:</label>
        <input type="text" id="itemNumber" name="itemNumber" required><br><br>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br><br>

        <label for="unitOfMeasure">Unit of Measure:</label>
        <input type="text" id="unitOfMeasure" name="unitOfMeasure" required><br><br>

        <label>Is Configurator Item:</label>
        <input type="radio" id="yes" name="isConfiguratorItem" value="1" required>
        <label for="yes">Yes</label>
        <input type="radio" id="no" name="isConfiguratorItem" value="0" required>
        <label for="no">No</label><br><br>

        <button type="submit">Generate cURL Command</button>
    </form>
    <br /><br /><br /><br />
    <a href="https://commercebuild.slack.com/archives/C018XMW7H0D/p1715349870869949" target="_blank">Slack -></a>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html>
