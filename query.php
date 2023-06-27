<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "logs";

// Create a connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the 'sqlQuery' key is set in $_POST
    if (isset($_POST['sqlQuery'])) {
        // Get the SQL query from the form input
        $sqlQuery = $_POST['sqlQuery'];

        // Check if the SQL query is not empty
        if (!empty($sqlQuery)) {
            // Execute the query
            $result = mysqli_query($connection, $sqlQuery);

            // Check if the query was successful
            if ($result) {
                // Check if there are rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Start table markup with CSS styles
                    echo "<style>
                            table {
                                border-collapse: collapse;
                                width: 100%;
                            }
                            th, td {
                                padding: 8px;
                                text-align: left;
                                border-bottom: 1px solid #ddd;
                            }
                            th {
                                background-color: #f2f2f2;
                            }
                          </style>";
                    echo "<table>";
                    echo "<tr>";
    
                    // Output table headers based on the column names
                    $field_info = mysqli_fetch_fields($result);
                    foreach ($field_info as $field) {
                        echo "<th>" . $field->name . "</th>";
                    }
    
                    echo "</tr>";
    
                    // Output table rows based on the query results
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . $value . "</td>";
                        }
                        echo "</tr>";
                    }

                    // Output table headers based on the column names
                    $field_info = mysqli_fetch_fields($result);
                    foreach ($field_info as $field) {
                        echo "<th>" . $field->name . "</th>";
                    }
    
                    // End table markup
                    echo "</table>";
                } else {
                    echo "No rows found.";
                }
            } else {
                echo "Error executing the query: " . mysqli_error($connection);
            }
        } else {
            echo "Please enter a valid SQL query.";
        }
    
    }
}

// Close the connection
mysqli_close($connection);
?>

<!-- HTML form to input the SQL query -->
<div style="text-align: center;">
    <h1>INPUT QUERY:</h1> <br>
    <form method="POST" action="" id="queryForm">
        <hr />
        <label for="sqlQuery">Enter SQL Query:</label><br>
        <textarea name="sqlQuery" id="sqlQuery" rows="5" cols="40"></textarea><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

<!-- JavaScript to submit form on Enter key press -->
<script>
    document.getElementById("sqlQuery").addEventListener("keydown", function(event) {
        if (event.keyCode === 13 && !event.shiftKey) {
            event.preventDefault();
            document.getElementById("queryForm").submit();
        }
    });
</script>