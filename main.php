<!DOCTYPE html>
<html>
<head>
    <title>LOG ANALYSER</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
        }

        .container {
            height: 100vh;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .container form {
            margin-top: 20px;
            text-align: center;
        }

        .container form input[type="file"] {
            display: none;
        }

        .container form .custom-file-upload {
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #4caf50;
            color: #fff;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .container form .custom-file-upload:hover {
            background-color: #45a049;
        }

        .container form input[type="submit"] {
            margin-top: 10px;
            padding: 10px 20px;
            cursor: pointer;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .container form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>LOG ANALYSER</h1>
        <form method="POST" action="parse.php" enctype="multipart/form-data">
            <label for="logFile" class="custom-file-upload">
                Choose File
                <input type="file" name="logFile" id="logFile" required>
            </label>
            <span id="fileNameLabel"></span>
            <input type="submit" value="PARSE">
        </form>
        <hr/>
        <form method="post" action="clear.php">
            <input type="submit" name="run_query2" value="EMPTY LOGS">
        </form>
        <hr/>
        <form method="post" action="TCP_DENIED_graph_source.php">
            <input type="submit" name="run_query2" value="TCP_DENIED/407 GRAPH FROM SOURCE">
        </form>
        <br>
        <form method="post" action="TCP_DENIED_graph_destination.php">
            <input type="submit" name="run_query2" value="TCP_DENIED/407 GRAPH TO DESTINATION">
        </form>
        <hr/>
        <form method="post" action="query.php">
            <input type="submit" name="run_query2" value="QUERY RUNNER">
        </form>
        <hr/>
        <footer>
            <p><i>RAJYA VARDHAN</i></p>
        </footer>
    </div>

    <script>
        const fileInput = document.getElementById('logFile');
        const fileNameLabel = document.getElementById('fileNameLabel');

        fileInput.addEventListener('change', function() {
            const fileName = this.value.split('\\').pop();
            fileNameLabel.textContent = fileName;
            localStorage.setItem('selectedFileName', fileName);
        });

        // Retrieve and display the file name when the page loads
        window.addEventListener('load', function() {
            const selectedFileName = localStorage.getItem('selectedFileName');
            if (selectedFileName) {
                fileNameLabel.textContent = selectedFileName;
            }
        });
    </script>
</body>
</html>









    <!-- <form method="POST" action="php.php" enctype="multipart/form-data">
        <input type="file" name="logFile" required>
        <br>
        <label for="timestamp">Timestamp:</label>
        <input type="datetime-local" id="timestamp" name="timestamp" required>
        <br>
        <input type="submit" value="Upload">
    </form> -->