<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { 
            font-family: "Figtree", sans-serif; 
            padding:100px 0 100px; 
            background-image: url('/images/treebg.png');
            background-size: cover;      
            background-repeat: no-repeat; 
            background-position: center;  
            background-attachment: fixed;
        }
        #generateButton {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 80px;
            height: 80px;
            margin:60px auto 30px;
            color: white;
            font-size: 24px;
            border-radius: 50%;
            cursor: pointer;
            transition: transform 0.4s ease;
            position: relative;
            z-index:1;
        }

        #passwordDisplay {
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: 300;
            color: #333;
            font-size:90px;
            line-height:110px;
            letter-spacing:5px;
            margin:130px auto 60px;
            position:relative;
            cursor:hand;
            cursor:pointer;
            max-width: 80%;
            word-wrap: break-word;
        }

        .arrow {
            display: inline-block;
            padding: 8px;
            transform: rotate(0deg);
            transition: transform 0.4s ease;
        }
        .reload { width:160px; }

        .rotate {
            transform: rotate(50deg);
        }

        .options {
            text-align: center;
            margin-top: 20px;
        }

        .options label {
            margin: 0 10px;
            font-size: 16px;
        }
        input[type="checkbox"] {
            /* Hide the default checkbox */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: #cf592a; /* Set custom background color */
            width: 16px;
            height: 16px;
            border: 2px solid #cf592a;
            border-radius: 3px;
            cursor: pointer;
            position: relative;
            top:5px;
        }

        input[type="checkbox"]:checked::before {
            content: '✔'; /* Add checkmark */
            color: white;
            font-size: 14px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        #charCountLabel {
            font-size: 16px;
            margin-right: 10px;
        }

        #charCount {
            width: 40px;
            text-align: center;
        }
        .tooltip {
            position: absolute;
            top: -55px;
            left: 60%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            line-height:12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .tooltip.visible {
            opacity: .6;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="images/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="images/favicon.svg" />
    <link rel="shortcut icon" href="images/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png" />
    <link rel="manifest" href="images/site.webmanifest" />
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-KRDNLFP9T6');
    </script>
</head>
<body>

<div id="generateButton">
    <div class="arrow"><img src="images/arrow.png" class="reload" /></div>
</div>
<div id="passwordDisplay">Your password will appear here</div>

<div class="options">
    <label id="charCountLabel"># Characters:</label>
    <input type="number" id="charCount" value="10" min="4" max="32"><br /><br />
    <label><input type="checkbox" id="uppercase" checked> Uppercase</label>
    <label><input type="checkbox" id="numbers" checked> Numbers</label>
    <label><input type="checkbox" id="symbols" checked> Symbols</label>
</div>

<script>
    function generatePassword(length, includeUppercase, includeNumbers, includeSymbols) {
        let characters = 'abcdefghijklmnopqrstuvwxyz';
        if (includeUppercase) characters += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if (includeNumbers) characters += '0123456789';
        if (includeSymbols) characters += '!@#$%^&*()';
        
        let password = '';
        for (let i = 0; i < length; i++) {
            password += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        return password;
    }

    function updatePassword() {
        const length = parseInt($('#charCount').val()) || 10;
        const includeUppercase = $('#uppercase').is(':checked');
        const includeNumbers = $('#numbers').is(':checked');
        const includeSymbols = $('#symbols').is(':checked');

        // Generate a new password with current options
        const password = generatePassword(length, includeUppercase, includeNumbers, includeSymbols);
        $('#passwordDisplay').text(password);
    }

    $('#generateButton').click(function() {
        // Add rotating effect to the arrow
        $('.arrow').addClass('rotate');

        // Remove rotate effect after delay
        setTimeout(() => {
            $('.arrow').removeClass('rotate');
        }, 600);

        // Update the password when the button is clicked
        updatePassword();
    });

    // Click-to-copy functionality with tooltip
     $('#passwordDisplay').click(function() {
        // Copy the password text to clipboard
        const password = $(this).text();
        navigator.clipboard.writeText(password).then(() => {
            // Show "Copied!" tooltip
            const tooltip = $('<div class="tooltip">Copied!</div>');
            $('#passwordDisplay').append(tooltip);
            tooltip.addClass('visible');

            // Remove tooltip after 1.5 seconds
            setTimeout(() => {
                tooltip.remove();
            }, 1500);
        });
    });

    // Update password whenever any checkbox or character count input is changed
    $('input[type=checkbox], #charCount').on('change keyup', updatePassword);

    // Generate the initial password on page load
    $(document).ready(updatePassword);
</script>
</body>
</html>
