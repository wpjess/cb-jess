<!DOCTYPE html>
<html>
<head>
    <title>Generate Punchout Request</title>
    <style type="text/css">
        body, html { position:relative; height:100%; font-family: Arial, sans-serif; }
        
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
        form {
            width: 500px;
            display: block;
            margin: 50px auto;
        }
        input { display:block; width:100%; padding:8px; }

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
</head>
<body>
    <div class="content">
    <form action="punchout_results.php" method="post">
        <label for="storeURL">Store URL:</label><br>
        <input type="text" id="storeURL" name="storeURL"><br>

        <label for="customerID">A/R Customer ID:</label><br>
        <input type="text" id="customerID" name="customerID"><br>

        <label for="firstName">First Name:</label><br>
        <input type="text" id="firstName" name="firstName" value="Jess"><br>

        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="lastName" value="Nunez"><br>

        <label for="siteHash">Site Hash:</label><br>
        <input type="text" id="siteHash" name="siteHash"><br>

        <label for="emailAddress">Email Address:</label><br>
        <input type="email" id="emailAddress" name="emailAddress" value="jnunez567@cb.com"><br>

        <label for="webStoreUserID">Web Store User ID:</label><br>
        <input type="text" id="webStoreUserID" name="webStoreUserID"><br><br>

        <input type="submit" value="Submit">
    </form>
    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>
</div>
</body>
</html>
