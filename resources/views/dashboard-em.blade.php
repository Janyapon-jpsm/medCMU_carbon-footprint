<?php

$host = "mysql";
$username = "root";
$password = "rootpassword";
$database = "cf";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    echo "";
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Footprint - MedCMU</title>
    <link rel="icon" href="\images\leaf-solid.svg" type="image/png">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Load jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Load Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <!-- Load Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <!-- Load jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

</head>

<style>
    body {
        font-family: 'Kanit', Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f0f0f0;
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23d3d3d3' fill-opacity='0.6'%3E%3Ccircle cx='5' cy='5' r='1.5'/%3E%3C/g%3E%3C/svg%3E");
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
    }

    .header {
        position: sticky;
        top: 0;
        background-color: #01696E;
        color: white;
        padding: 25px;
        display: flex;
        align-items: center;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .header h1 {
        display: flex;
        align-items: center;
        margin: 0;
    }

    .logo {
        max-height: 50px;
        margin-right: 20px;
    }

    .sub-header {
        background-color: #20B2AA;
        color: white;
        padding: 20px;
        text-align: center;
    }

    .footer {
        margin-top: 40px;
        padding: 10px 0;
        width: 100%;
        position: relative;
        background-color: #01696E;
        color: #D5D5D5;
        text-align: center;
    }

    .chart-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin: 20px auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 900px;
        text-align: center;
    }

    .section-title {
        text-align: center;
        color: #2c7873;
        margin-top: 40px;
        font-size: 24px;
        font-weight: bold;
    }

    .progress-bar {
        display: flex;
        height: 30px;
        background-color: #20B2AA;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .progress-bar-fill {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: width 0.5s ease-in-out;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    }

    .button-container {
        display: flex;
        gap: 200px;
        justify-content: center;
        border: none;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        font-size: 18px;
        margin: 4px 2px;

    }

    .button {
        border: none;
        border-radius: 25px;
        transition: 0.3s;
        cursor: pointer;
    }

    .button:active {
        background-color: #20B2AA;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }

    .button-reduction:hover {
        opacity: 1;
        background-color: #2c7873;
    }

    .button-emission {
        background-color: #D5D5D5;
        color: black;
        padding: 30px;
    }

    .button-reduction {
        background-color: #20B2AA;
        color: white;
        padding: 12px;
    }

    .show-carbon {
        margin: 40px auto;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.95));
        border: 2px solid #01696E;
        border-radius: 100px;
        padding: 30px 40px;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(1, 105, 110, 0.1);
        backdrop-filter: blur(5px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .show-carbon:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(1, 105, 110, 0.15);
    }

    .carbon-type {
        text-align: center;
        font-size: 1.1rem;
        color: #01696E;
        font-weight: 500;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
    }

    .carbon-value {
        margin: 15px 0;
        text-align: center;
        font-size: 2.8rem;
        font-weight: 600;
        color: #20B2AA;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .carbon-value:hover {
        transform: scale(1.02);
    }

    .carbon-unit {
        display: block;
        text-align: center;
        font-size: 1.25rem;
        color: #01696E;
        opacity: 0.9;
        margin-top: 5px;
    }

    .icon-container {
        display: flex;
        justify-content: space-around;
        margin: 40px auto;
        max-width: 900px;
        gap: 30px;
        padding: 20px;
    }

    .icon-item {
        flex: 1;
        background: white;
        padding: 30px 20px;
        border-radius: 15px;
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        min-width: 200px;
    }

    .icon-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 25px rgba(32, 178, 170, 0.2);
    }

    .icon-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #01696E, #20B2AA);
    }

    .icon-item i {
        font-size: 40px;
        color: #20B2AA;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .icon-item:hover i {
        transform: scale(1.2);
        color: #01696E;
    }

    .icon-item p {
        margin: 15px 0 0 0;
        color: #2c7873;
        font-size: 18px;
        font-weight: 500;
        position: relative;
    }

    .icon-item::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 30%;
        height: 3px;
        background: #20B2AA;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .icon-item:hover::after {
        opacity: 1;
        width: 60%;
    }

    /* Add circular background effect for icons */
    .icon-item i::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 70px;
        height: 70px;
        background: rgba(32, 178, 170, 0.1);
        border-radius: 50%;
        z-index: -1;
        transition: all 0.3s ease;
    }

    .icon-item:hover i::before {
        width: 80px;
        height: 80px;
        background: rgba(32, 178, 170, 0.15);
    }

    /* Add subtle wave animation */
    @keyframes wave {
        0% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }

        100% {
            transform: translateY(0);
        }
    }

    .icon-item:hover i {
        animation: wave 2s infinite ease-in-out;
    }

    .progress-container {
        width: 100%;
        background-color: #f4f4f4;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
    }

    .progress-bar-fill {
        color: white;
        text-align: center;
        padding: 5px 0;
        font-size: 14px;
        border-right: 2px solid white;
    }

    .progress-bar-reduction {
        background-color: #4ecdc4;
    }

    .progress-bar-emission {
        background-color: #ff6b6b;
        border-right: none;
        /* Last bar has no border */
    }

    .progress-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        color: #2c7873;
    }

    .label {
        width: 50%;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .label:first-child {
        text-align: left;
    }

    .label:last-child {
        text-align: right;
    }

    .section-title {
        text-align: center;
        color: #2c7873;
        margin-top: 40px;
        font-size: 24px;
        font-weight: bold;
    }

    .bar-container {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        margin: auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 1250px;
        width: 100%;
        text-align: center;
    }

    .monthpicker-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 2rem auto;
        position: relative;
        max-width: 300px;
    }

    #monthpicker {
        width: 100%;
        padding: 1rem 3rem;
        border: 2px solid #20B2AA;
        border-radius: 25px;
        font-size: 1.1rem;
        text-align: center;
        outline: none;
        background-color: white;
        color: #2c3e50;
        cursor: pointer;
        font-family: 'Kanit', Arial, sans-serif;
    }

    .calendar-icon {
        position: absolute;
        left: 1rem;
        color: #20B2AA;
        font-size: 1.2rem;
        pointer-events: none;
    }

    /* Basic datepicker styling */
    .ui-datepicker {
        padding: 1rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .ui-datepicker-calendar {
        display: none;
    }
</style>

<body>
    <div class="header">
        <h1>
            <img class="logo" src="\images\logo-med.png" />&nbsp;<b>Carbon Footprint</b>&nbsp;&nbsp;<i class="fas fa-leaf"></i>
        </h1>
    </div>
    <div class="sub-header">
        <h3><b>คาร์บอนฟุตพริ้นท์ คณะแพทยศาสตร์ มหาวิทยาลัยเชียงใหม่</b></h3>
        <h4>ตั้งแต่ปี 2565 - ปัจจุบัน</h4>
    </div>

    <!-- line chart -->
    <?php
    // Fetch data for emissions by year
    $sqlEmissions = "SELECT year, 
                             SUM(total_cf) AS total_emission
                      FROM emission_calculations
                      GROUP BY year
                      ORDER BY YEAR";

    $stmtEmissions = $pdo->prepare($sqlEmissions);
    $stmtEmissions->execute();

    $years = [];
    $emissions = [];
    $reductions = []; // Initialize reductions array

    while ($row = $stmtEmissions->fetch(PDO::FETCH_ASSOC)) {
        $years[] = $row['year']; // This will be the year
        $emissions[] = $row['total_emission'];
        $reductions[] = 0; // Initialize reductions to 0 for each year
    }

    // Fetch data for reductions by year
    $sqlReductions = "SELECT year, 
                             SUM(total_cf) AS total_reduction
                      FROM reduction_calculations
                      GROUP BY year
                      ORDER BY year";
    $stmtReductions = $pdo->prepare($sqlReductions);
    $stmtReductions->execute();

    while ($row = $stmtReductions->fetch(PDO::FETCH_ASSOC)) {
        // Ensure that the year exists in the years array
        $index = array_search($row['year'], $years);
        if ($index !== false) {
            // If it exists, add the reduction to the corresponding year
            $reductions[$index] += $row['total_reduction'];
        } else {
            // If it doesn't exist, add a new entry
            $years[] = $row['year'];
            $emissions[] = 0; // No emissions for this year
            $reductions[] = $row['total_reduction'];
        }
    }
    ?>
    <div class="chart-container">
        <canvas id="lineChart"></canvas>
    </div>


    <div class="container">
        <!-- show progress bar -->
        <h2 class="section-title"><i class="fas fa-balance-scale"></i> การดำเนินงานเพื่อมุ่งสู่ความเป็นกลางทางคาร์บอน</h2>
        <!-- labels -->
        <div class="progress-labels">
            <div class="label">การลดการปล่อยคาร์บอน</div>
            <div class="label">การปล่อยคาร์บอน</div>
        </div>

        <div class="progress-container">
            <?php
            // Fetch and calculate the percentages for emissions and reductions
            $sqlEmissions = "SELECT SUM(total_cf) AS total_emission FROM emission_calculations";
            $stmtEmissions = $pdo->prepare($sqlEmissions);
            $stmtEmissions->execute();
            $totalEmissions = $stmtEmissions->fetchColumn(); // Total emissions

            $sqlReductions = "SELECT SUM(total_cf) AS total_reduction FROM reduction_calculations"; // Assuming you have a table for reductions
            $stmtReductions = $pdo->prepare($sqlReductions);
            $stmtReductions->execute();
            $totalReductions = $stmtReductions->fetchColumn(); // Total reductions

            $total = $totalEmissions + $totalReductions; // Total value
            $emissionPercentage = $total ? ($totalEmissions / $total) * 100 : 0; // Calculate emission percentage
            $reductionPercentage = $total ? ($totalReductions / $total) * 100 : 0; // Calculate reduction percentage
            ?>

            <!-- Reduction Bar -->
            <div class="progress-bar-fill progress-bar-reduction" style="width: <?php echo number_format($reductionPercentage, 2); ?>%;">
                <?php echo number_format($reductionPercentage); ?>%
            </div>

            <!-- Emission Bar -->
            <div class="progress-bar-fill progress-bar-emission" style="width: <?php echo number_format($emissionPercentage, 2); ?>%;">
                <?php echo number_format($emissionPercentage); ?>%
            </div>
        </div>

        <div class="icon-container">
            <div class="icon-item">
                <i class="fas fa-tree"></i>
                <p>ปลูกต้นไม้</p>
            </div>
            <div class="icon-item">
                <i class="fas fa-solar-panel"></i>
                <p>พลังงานสะอาด</p>
            </div>
            <div class="icon-item">
                <i class="fas fa-recycle"></i>
                <p>รีไซเคิล</p>
            </div>
        </div>
        <div class="button-container">
            <button onclick="location.href='carbon-footprint-MedCMU-dashboard-em'" class="button button-emission">การปล่อยคาร์บอน (Emission)</button>
            <button onclick="location.href='carbon-footprint-MedCMU-dashboard-re'" class="button button-reduction">การลดการปล่อยคาร์บอน (Reduction)</button>
        </div>
    </div>

    <!-- show overall carbon emission -->
    <script>
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);

                // Use easing function for smoother animation
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const currentNumber = progress * (end - start) + start;

                obj.innerHTML = currentNumber.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Start the animation when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const carbonCounter = document.getElementById('carbonCounter');
            const finalValue = parseFloat(document.getElementById('finalValue').value);
            animateValue(carbonCounter, 0, finalValue, 2000); // 2000ms = 2 seconds duration
        });
    </script>
    <div class="show-carbon">
        <div class="carbon-type">รวมการปล่อยคาร์บอนทั้งหมดในคณะแพทยศาสตร์</div>
        <div class="carbon-value">
            <?php
            // Query to get the total carbon emissions
            $sql = "SELECT SUM(total_cf) AS total_emission FROM emission_calculations";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $totalEmission = $stmt->fetchColumn(); // Fetch the total emission value
            ?>
            <span id="carbonCounter">0</span> <!-- We'll animate this -->
            <input type="hidden" id="finalValue" value="<?php echo $totalEmission; ?>">
        </div>
        <span class="carbon-unit">kg CO2e</span>
    </div>

    <!-- month picker -->
    <div class="monthpicker-container">
        <span class="calendar-icon">
            <i class="fas fa-calendar-alt"></i>
        </span>
        <input id="monthpicker" type="text" placeholder="เลือกเดือนและปี" readonly>
    </div>

    <!-- bar chart -->
    <?php
    // Initialize the variable
    $totalCF = []; // Ensure this is defined before use
    $carbonType = []; // Initialize this as well

    // Get month and year from POST request
    $selectedMonth = isset($_POST['month']) ? (int)$_POST['month'] + 1 : null; // +1 because month is 0-indexed
    $selectedYear = isset($_POST['year']) ? (int)$_POST['year'] : null; // Default to current year

    try {
        if ($selectedMonth && $selectedYear) {
            // Query for specific month and year
            $sql = "SELECT et.type, SUM(ec.total_cf) AS total_carbon_footprint
                    FROM emission_calculations ec
                    JOIN emission_types et ON ec.em_id = et.em_id
                    WHERE MONTH(ec.month) = :month AND YEAR(ec.year) = :year
                    GROUP BY et.type";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':month', $selectedMonth, PDO::PARAM_INT);
            $stmt->bindParam(':year', $selectedYear, PDO::PARAM_INT);
        } else {
            // Query for overall data if no date is selected
            $sql = "SELECT et.type, SUM(ec.total_cf) AS total_carbon_footprint
                    FROM emission_calculations ec
                    JOIN emission_types et ON ec.em_id = et.em_id
                    GROUP BY et.type";

            $stmt = $pdo->prepare($sql);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $totalCF = [];
            $carbonType = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $totalCF[] = $row["total_carbon_footprint"];
                $carbonType[] = $row["type"];
            }
        } else {
            echo "No records matching your query were found.";
        }
    } catch (PDOException $e) {
        die("ERROR: Could not execute $sql. " . $e->getMessage());
    }

    // Close connection
    unset($pdo);
    ?>
    <div class="bar-container">
        <canvas id="barChart" onclick="location.href='emission-detail'"></canvas>
    </div>


    <script>
        // Line chart setup
        const lineCtx = document.getElementById('lineChart').getContext('2d');

        // Setup Block
        const years = <?php echo json_encode($years); ?>; // Use years for x-axis labels
        const emissions = <?php echo json_encode($emissions); ?>;
        const reductions = <?php echo json_encode($reductions); ?>;

        // Create datasets
        const datasets = [{
                label: 'Emissions',
                data: emissions,
                borderColor: 'rgba(255, 99, 132, 1)', // Line color for emissions
                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Optional background for fill
                borderWidth: 2, // Line thickness
                fill: false // No fill under the line
            },
            {
                label: 'Reductions',
                data: reductions,
                borderColor: 'rgba(54, 162, 235, 1)', // Line color for reductions
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Optional background for fill
                borderWidth: 2, // Line thickness
                fill: false // No fill under the line
            }
        ];

        const lineData = {
            labels: years, // X-axis labels
            datasets: datasets // Add datasets for emissions and reductions
        };

        // Config Block
        const LineConfig = {
            type: 'line',
            data: lineData, // Use lineData for the data source
            options: {
                plugins: {
                    legend: {
                        display: true, // Display the legend
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Annual Emissions and Reductions',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                responsive: true, // Make the chart responsive
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Year',
                            font: {
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            font: {
                                size: 12 // Adjust font size for better readability
                            }
                        }
                    },
                    y: {
                        beginAtZero: true, // Start Y-axis at zero
                        title: {
                            display: true,
                            text: 'Values',
                            font: {
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            font: {
                                size: 12 // Adjust font size for better readability
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)', // Light grid color for better visibility
                            lineWidth: 1 // Adjust grid line width
                        }
                    }
                }
            }
        };

        // Render Block
        const lineChart = new Chart(
            lineCtx,
            LineConfig // Use LineConfig for the chart
        );

        // Month picker initialization
        $(document).ready(function() {
            $("#monthpicker").datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));

                    // Call a function to fetch data based on the selected month and year
                    fetchData(month, year);
                }
            });
        });

        // Function to fetch data based on selected month and year
        function fetchData(month, year) {
            $.ajax({
                url: 'path/to/your/php/script.php', // Update with the correct path to your PHP script
                type: 'POST',
                data: {
                    month: month,
                    year: year
                },
                success: function(response) {
                    // Assuming response is JSON containing totalCF and carbonType
                    const data = JSON.parse(response);
                    updateChart(data.totalCF, data.carbonType); // Call function to update the chart
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        // Bar chart setup
        const barCtx = document.getElementById('barChart').getContext('2d');

        // Assuming you have similar data fetching logic for the bar chart
        const totalCF = <?php echo json_encode($totalCF); ?>; // Ensure this is defined
        const carbonType = <?php echo json_encode($carbonType); ?>; // Ensure this is defined

        // Combine the data into an array of objects for sorting
        const combinedData = carbonType.map((type, index) => ({
            type: type,
            value: totalCF[index]
        }));

        // Sort the combined data by value in descending order
        combinedData.sort((a, b) => b.value - a.value);

        // Extract the sorted carbon types and total CF values
        const sortedCarbonType = combinedData.map(item => item.type);
        const sortedTotalCF = combinedData.map(item => item.value);

        // Create gradient
        const gradient = barCtx.createLinearGradient(0, 0, 0, 400); // Adjust the height as needed
        gradient.addColorStop(0, '#2c7873'); // Color for the biggest bar
        gradient.addColorStop(1, '#20B2AA'); // Color for the smallest bar

        const barData = {
            labels: sortedCarbonType, // Use sorted carbon types
            datasets: [{
                label: 'Carbon Footprint', // Add a label for the dataset
                backgroundColor: gradient, // Use the gradient for the bars
                data: sortedTotalCF // Use sorted total CF values
            }]
        };

        // Config Block
        const barConfig = {
            type: "bar",
            data: barData,
            options: {
                plugins: {
                    legend: {
                        display: true // Set to true to display the legend
                    },
                    title: {
                        display: true,
                        text: 'Carbon Footprint by Type',
                        font: {
                            weight: 'bold'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Carbon Footprint (kg CO2e)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Format numbers with commas
                            },
                            font: {
                                size: 12 // Adjust font size for better readability
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)', // Light grid color for better visibility
                            lineWidth: 1 // Adjust grid line width
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Emission Type',
                            font: {
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            font: {
                                size: 12 // Adjust font size for better readability
                            }
                        }
                    }
                }
            }
        };

        // Render Block
        const barChart = new Chart(
            barCtx,
            barConfig // Use barConfig for the chart
        );
    </script>

    <footer class="footer">
        <p>© 2024 Janyapon Saingam. All rights reserved.</p>
        <p>This research was conducted at the Faculty of Medicine, Chiang Mai University.</p>
    </footer>
</body>


</html>