<!DOCTYPE html>
<html>
<head>
    <title>Data Processing</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#dataForm").on("submit", function(event){
                event.preventDefault();
                $.ajax({
                    url: 'process_data.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $("#result").html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Error: " + textStatus + " - " + errorThrown);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <form id="dataForm">
        <label for="data">Enter Data:</label>
        <textarea id="data" name="return_string" rows="10" cols="50"></textarea><br>
        <input type="submit" value="Submit">
    </form>
    <div id="result"></div>
</body>
</html>
