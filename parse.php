<!DOCTYPE html>
<html>
<head>
    <title>LOG ANALYSER</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .loading {
            font-size: 24px;
            font-weight: bold;
        }

        .parsing-completed {
            font-size: 36px;
            text-align: center;
            margin-top: 200px;
        }
    </style>
    <script>
        // Function to stop the animation and display "Parsing completed"
        function stopAnimation() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('parsingCompleted').style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <div id="loading" class="loading">PARSING LOG ENTRIES...</div>
        <div id="parsingCompleted" class="parsing-completed" style="display: none;">PARSING COMPLETED</div>
    </div>

    <?php
    // Include the database connection file
    include 'db_connection.php';

    // Check if a file was uploaded
    if ($_FILES['logFile']['error'] === UPLOAD_ERR_OK) {
        $tmpFilePath = $_FILES['logFile']['tmp_name'];

        // Check if the uploaded file is a text file
        if ($_FILES['logFile']['type'] === 'text/plain') {
            // Read the contents of the uploaded file
            $logs = file($tmpFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            // Disable output buffering
            ob_end_flush();
            ob_implicit_flush(true);

            // Process each log entry
            foreach ($logs as $logEntry) {
                // Extract relevant information from the log entry
                $parts = preg_split('/\s+/', $logEntry);

                // Extract individual data
                $timestamp = $parts[0];
                $proxyServer = $parts[1];
                $user = $parts[7];
                $sourceIP = $parts[8];
                $action = $parts[9];
                $bytes = $parts[10];
                $method = $parts[11];
                $destination = $parts[12];
                $host = $parts[13];
                $hierarchy = $parts[14];
                $content = $parts[15];

                // Prepare the SQL statement
                $sql = "INSERT INTO logs (timestamp, proxy_server, user, source_ip, action, bytes, method, destination, host, hierarchy, content) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Prepare the statement
                $stmt = $conn->prepare($sql);

                // Check if the statement preparation was successful
                if (!$stmt) {
                    echo "Error preparing statement: " . $conn->error . "<br>";
                    exit;
                }

                // Bind the values to the prepared statement
                $stmt->bind_param("sssssssssss", $timestamp, $proxyServer, $user, $sourceIP, $action, $bytes, $method, $destination, $host, $hierarchy, $content);

                // Execute the statement
                if ($stmt->execute()) {
                    echo str_repeat(' ', 1024 * 64); // Flush output buffer
                    echo "<script>setTimeout(() => {stopAnimation();}, 2000);</script>"; // Stop animation after 2 seconds
                    echo "Query executed successfully.<br>";
                    echo str_repeat(' ', 1024 * 64); // Flush output buffer
                    echo "<script>setTimeout(() => {stopAnimation();}, 2000);</script>"; // Stop animation after 2 seconds
                } else {
                    echo "Error executing query: " . $stmt->error . "<br>";
                    break; // Stop processing log entries on error
                }
    
                // Close the statement
                $stmt->close();
            }
    
            // Close the database connection
            $conn->close();
        } else {
            echo "Invalid file format. Please upload a text file.<br>";
        }
    }
    ?>
    