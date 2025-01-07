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
            border: 2px solid #01696E;
            border-radius: 100px;
            padding: 20px;
            max-width: 25%;
            text-align: center;

        }

        .carbon-type {
            text-align: center;
            font-size: 15px;
            color: #01696E;
        }

        .carbon-value {
            margin-top: 10px;
            text-align: center;
            font-size: 36px;
            color: #20B2AA;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .carbon-unit {
            text-align: center;
            font-size: 20px;
            color: #01696E;
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

        .icon-item:hover i {
            animation: wave 2s infinite ease-in-out;
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
            max-width: 1200px;
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
</head>

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
    <div class="chart-container">
        <canvas id="carbonChart"></canvas>
    </div>

    <!-- show progress bar -->
    <div class="container">
        <h2 class="section-title"><i class="fas fa-balance-scale"></i> การดำเนินงานเพื่อมุ่งสู่ความเป็นกลางทางคาร์บอน</h2>
        <!-- labels -->
        <div class="progress-labels">
            <div class="label">การลดการปล่อยก๊าซเรือนกระจก</div>
            <div class="label">การปล่อยก๊าซเรือนกระจก</div>
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
            <button onclick="location.href='carbon-footprint-MedCMU-dashboard-em'" class="button button-emission">การปล่อยก๊าซเรือนกระจก (Emission)</button>
            <button onclick="location.href='carbon-footprint-MedCMU-dashboard-re'" class="button button-reduction">การลดการปล่อยก๊าซเรือนกระจก (Reduction)</button>
        </div>
    </div>
    <!-- show overall carbon emission -->
    <div class="show-carbon">
        <div class="carbon-type">รวมการปล่อยก๊าซเรือนกระจกทั้งหมดในคณะแพทยศาสตร์</div>
        <div class="carbon-value">
            <?php
            // Query to get the total carbon emissions
            $sql = "SELECT SUM(total_cf) AS total_emission FROM emission_calculations";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $totalEmission = $stmt->fetchColumn(); // Fetch the total emission value
            ?>
            <?php echo number_format($totalEmission, 2); ?> <!-- Display the total emission -->
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
                    WHERE MONTH(ec.date_column) = :month AND YEAR(ec.date_column) = :year
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
        // Carbon Footprint Chart setup 
        /* const carbonCtx = document.getElementById('carbonChart').getContext('2d');
        new Chart(carbonCtx, {
            type: 'line',
            data: {
                labels: ['2022', '2023', '2024'], //connect database
                datasets: [{
                    label: 'การปล่อยคาร์บอน (Emission)',
                    data: [50, 45, 50], //connect database
                    borderColor: '#ff6b6b',
                    backgroundColor: 'rgba(255, 107, 107, 0.2)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'การลดการปล่อยคาร์บอน (Reduction)',
                    data: [25, 20, 24], //connect database
                    borderColor: '#4ecdc4',
                    backgroundColor: 'rgba(78, 205, 196, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Carbon Footprint Over Time'
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw;
                                return label + ' metric tons';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Year',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Carbon Emissions (kg CO2e)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        beginAtZero: true,
                    }
                }
            }
        }); */

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
        const barColors = 'rgba(54, 162, 235, 0.6)'; // Define bar color

        // Setup Block
        const totalCF = <?php echo json_encode($totalCF); ?>;
        const carbonType = <?php echo json_encode($carbonType); ?>;
        const data = {
            labels: carbonType,
            datasets: [{
                label: 'Carbon Footprint', // Add a label for the dataset
                backgroundColor: barColors,
                data: totalCF
            }]
        };

        // Config Block
        const config = {
            type: "bar",
            data,
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
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Emission Type',
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        };
        //Reder Block
        const barChart = new Chart(
            document.getElementById('barChart'),
            config
        );
    </script>

    <footer class="footer">
        <p>© 2024 Janyapon Saingam. All rights reserved.</p>
        <p>This research was conducted at the Faculty of Medicine, Chiang Mai University.</p>
    </footer>
</body>


</html>