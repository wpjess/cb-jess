<!DOCTYPE html>
<html>
<head>
    <title></title>
    <style type="text/css">
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
        .wrapper { max-width:1000px; margin:40px auto 0; position:relative; height:95%; }
        h1 {
            font-family: Arial, sans-serif;
            font-size: 28px;
        }
        textarea { min-height:600px; width:100%; border: 1px solid #555;}
        .footer { position: absolute; bottom:-140px; left:0; }
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
    <div class="wrapper">
    <h1>Clean up the logs</h1>
    <form action="order_logs_clean.php" method="post">
        <textarea name="message" id="message" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Submit">
    </form>

    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html> 
