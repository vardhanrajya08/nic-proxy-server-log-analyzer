<?php
    // Include the database connection file
    include 'db_connection.php';

    // Query to retrieve user and count of 'tcp_denied' occurrences
    $query = "SELECT source_ip, COUNT(*) AS tcp_denied_count FROM logs WHERE action = 'TCP_DENIED/407' GROUP BY source_ip";


    // Execute the query
    $result = $conn->query($query);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Define arrays for different graph/chart types
        $barXArray = array();
        $barYArray = array();
        $pieLabels = array();
        $pieValues = array();
        $lineXArray = array();
        $lineYArray = array();
        $scatterXArray = array();
        $scatterYArray = array();

        // Fetch data row by row
        while ($row = $result->fetch_assoc()) {
            $sourceIP = $row['source_ip'];
            $count = $row['tcp_denied_count'];

            // Add data to arrays for bar graph
            $barXArray[] = $sourceIP;
            $barYArray[] = $count;

            // Add data to arrays for pie chart
            $pieLabels[] = $sourceIP;
            $pieValues[] = $count;

            // Add data to arrays for line graph
            $lineXArray[] = $sourceIP;
            $lineYArray[] = $count;

            // Add data to arrays for scatter plot
            $scatterXArray[] = $sourceIP;
            $scatterYArray[] = $count;
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "No data found.";
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Graphs</title>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
    <div id="barGraph"></div>
    <div id="pieChart"></div>
    <div id="lineGraph"></div>
    <div id="scatterPlot"></div>

    <script>
        // Create the bar graph
        var barData = [{
            x: <?php echo json_encode($barXArray); ?>,
            y: <?php echo json_encode($barYArray); ?>,
            type: 'bar'
        }];

        var barLayout = {
            title: "User TCP Denied Statistics (Bar Graph)",
            xaxis: { title: "Source IP" },
            yaxis: { title: "TCP Denied Count" }
        };

        // Display the bar graph using Plotly
        Plotly.newPlot("barGraph", barData, barLayout);


        // Create the pie chart
        var pieData = [{
            labels: <?php echo json_encode($pieLabels); ?>,
            values: <?php echo json_encode($pieValues); ?>,
            type: 'pie'
        }];

        var pieLayout = {
            title: "User TCP Denied Statistics (Pie Chart)",
        };

        // Display the pie chart using Plotly
        Plotly.newPlot("pieChart", pieData, pieLayout);

        // Create the line graph
        var lineData = [{
        x: <?php echo json_encode($lineXArray); ?>,
        y: <?php echo json_encode($lineYArray); ?>,
        type: 'line'
        }];

        var lineLayout = {
        title: "User TCP Denied Statistics (Line Graph)",
        xaxis: { title: "Source IP" },
        yaxis: { title: "TCP Denied Count" }
    };

    // Display the line graph using Plotly
    Plotly.newPlot("lineGraph", lineData, lineLayout);


    // Create the scatter plot
    var scatterData = [{
        x: <?php echo json_encode($scatterXArray); ?>,
        y: <?php echo json_encode($scatterYArray); ?>,
        mode: 'markers',
        type: 'scatter'
    }];

    var scatterLayout = {
        title: "User TCP Denied Statistics (Scatter Plot)",
        xaxis: { title: "Source IP" },
        yaxis: { title: "TCP Denied Count" }
    };

    // Display the scatter plot using Plotly
    Plotly.newPlot("scatterPlot", scatterData, scatterLayout);
</script>
</body>
</html>