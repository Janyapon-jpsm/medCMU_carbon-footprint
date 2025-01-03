<?php
// Set the content type to JSON
header('Content-Type: application/json');

// Database credentials
$host = 'mysql';
$username = 'root';
$password = 'rootpassword';
$database = 'cf';

try {
    // Create a PDO connection
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);

    // Set PDO options
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle connection errors
    echo json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]);
    exit;
}

// Input parameters for month and year
$selectedMonth = isset($_GET['month']) ? intval($_GET['month']) : null;
$selectedYear = isset($_GET['year']) ? intval($_GET['year']) : null;

// Query for the line chart: Carbon Footprint over time
$lineChartData = [
    'emissions' => [],
    'reductions' => []
];

try {
    // Query for emissions
    $queryEmissions = "
        SELECT year, SUM(amount) AS total_cf
        FROM emission_calculations
        GROUP BY year
        ORDER BY year ASC
    ";
    $stmtEmissions = $pdo->query($queryEmissions);
    $lineChartData['emissions'] = $stmtEmissions->fetchAll();

    // Query for reductions
    $queryReductions = "
        SELECT year, SUM(amount) AS total_cf
        FROM reduction_calculations
        GROUP BY year
        ORDER BY year ASC
    ";
    $stmtReductions = $pdo->query($queryReductions);
    $lineChartData['reductions'] = $stmtReductions->fetchAll();
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Error fetching line chart data: " . $e->getMessage()]);
    exit;
}

// Query for the bar chart: Carbon Footprint for selected month and year
$barChartData = [];
if ($selectedMonth !== null && $selectedYear !== null) {
    try {
        $queryBarChart = "
            SELECT em_type, SUM(amount) AS total_cf
            FROM emission_calculations
            WHERE month = :month AND year = :year
            GROUP BY em_type
        ";
        $stmtBarChart = $pdo->prepare($queryBarChart);
        $stmtBarChart->execute(['month' => $selectedMonth, 'year' => $selectedYear]);
        $barChartData = $stmtBarChart->fetchAll();
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => "Error fetching bar chart data: " . $e->getMessage()]);
        exit;
    }
}

// Combine response data
$response = [
    'success' => true,
    'lineChart' => $lineChartData,
    'barChart' => $barChartData
];

echo json_encode($response);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Footprint - MedCMU</title>
    <link rel="icon" href="\images\leaf-solid.svg" type="image/png">



    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Then load Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

    <!-- Other scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <!-- Then load jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            font-size: 18px;
            color: #01696E;
        }

        .carbon-value {
            margin-top: 10px;
            text-align: center;
            font-size: 36px;
            color: #20B2AA;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
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
            width: 1200px;
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
    <div class="container">
        <h2 class="section-title"><i class="fas fa-balance-scale"></i> การดำเนินงานเพื่อมุ่งสู่ความเป็นกลางทางคาร์บอน</h2>
        <div class="progress-bar">
            <!-- connect width % to the database -->
            <div class="progress-bar-fill" style="width: 35%; background-color: #4ecdc4;">35% การลดการปล่อยคาร์บอน</div>
            <div class="progress-bar-fill" style="width: 65%; background-color: #ff6b6b;">65% การปล่อยคาร์บอน</div>
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
    <div class="show-carbon">
        <div class="carbon-type">การปล่อยคาร์บอน (Carbon Emission)</div>
        <div class="carbon-value">
            00,000.00
            <span class="carbon-unit">Ton-eq</span>
        </div>
    </div>
    <div class="monthpicker-container">
        <span class="calendar-icon">
            <i class="fas fa-calendar-alt"></i>
        </span>
        <input id="monthpicker" type="text" placeholder="เลือกเดือนและปี" readonly>
    </div>
    <div class="bar-container">
        <canvas onclick="location.href='carbon-footprint-emission-detail'" id="myChart" style="width:100%;max-width:1200px"></canvas>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Contexts for Line and Bar Charts
            const carbonCtx = document.getElementById('carbonChart').getContext('2d');
            const barCtx = document.getElementById('barChart').getContext('2d');
            let carbonChart = null;
            let barChart = null;

            // Fetch chart data and update charts
            function fetchChartData(selectedMonth = null, selectedYear = null) {
                const url = selectedMonth && selectedYear ?
                    `fetch_combined_chart_data.php?month=${selectedMonth}&year=${selectedYear}` :
                    'fetch_combined_chart_data.php';

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Error in response:', data.error);
                            return;
                        }

                        // Line Chart Data
                        const years = data.lineChart.emissions.map(item => item.year);
                        const emissions = data.lineChart.emissions.map(item => item.total_cf);
                        const reductions = data.lineChart.reductions.map(item => item.total_cf);

                        // Update or Create Line Chart
                        if (carbonChart) {
                            carbonChart.data.labels = years;
                            carbonChart.data.datasets[0].data = emissions;
                            carbonChart.data.datasets[1].data = reductions;
                            carbonChart.update();
                        } else {
                            carbonChart = new Chart(carbonCtx, {
                                type: 'line',
                                data: {
                                    labels: years,
                                    datasets: [{
                                            label: 'Carbon Emissions (CO2)',
                                            data: emissions,
                                            borderColor: '#ff6b6b',
                                            backgroundColor: 'rgba(255, 107, 107, 0.2)',
                                            fill: true,
                                            tension: 0.4
                                        },
                                        {
                                            label: 'Carbon Reductions (CO2)',
                                            data: reductions,
                                            borderColor: '#4ecdc4',
                                            backgroundColor: 'rgba(78, 205, 196, 0.2)',
                                            fill: true,
                                            tension: 0.4
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Year'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Total (CO2)'
                                            },
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        }

                        // Bar Chart Data
                        const labels = data.barChart.map(item => item.em_type);
                        const values = data.barChart.map(item => item.total_cf);

                        // Update or Create Bar Chart
                        if (barChart) {
                            barChart.data.labels = labels;
                            barChart.data.datasets[0].data = values;
                            barChart.update();
                        } else {
                            barChart = new Chart(barCtx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Carbon Footprint',
                                        data: values,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        }
                                    },
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Emission Type'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Total (CO2)'
                                            },
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        }
                    })
                    .catch(error => console.error('Error fetching chart data:', error));
            }

            // Fetch data on page load
            fetchChartData();

            // Month-Year Picker Initialization for Bar Chart
            $("#monthpicker").datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                yearRange: "2020:2030",
                onClose: function(dateText, inst) {
                    const month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    const year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));

                    // Fetch data for the selected month and year
                    fetchChartData(parseInt(month) + 1, parseInt(year));
                }
            });
        });
    </script>

    <footer class="footer">
        <p>© 2024 Janyapon Saingam. All rights reserved.</p>
        <p>This research was conducted at the Faculty of Medicine, Chiang Mai University.</p>
    </footer>
</body>


</html>