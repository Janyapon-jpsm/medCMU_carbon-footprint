<?php

$host = "mysql";
$username = "root";
$password = "rootpassword";
$database = "cf";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    echo "Connected successfully!";
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

    <!-- bar chart -->
    <?php
    // Attempt select query execution
    try {
        $sql = "SELECT ec.*, et.type
                FROM emission_calculations ec
                JOIN emission_types et ON ec.em_id = et.em_id";

        $result = $pdo->query($sql);

        if ($result->rowCount() > 0) {
            $totalCF = [];
            $carbonType = [];

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $totalCF[] = $row["total_cf"]; // Assuming this is the correct column name
                $carbonType[] = $row["type"]; // Get the type name from the emission_types table
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
        <canvas id="barChart"></canvas>
    </div>
    <!--onclick="location.href='carbon-footprint-emission-detail'" -->


    <script>
        /*  // Carbon Footprint Chart
        const carbonCtx = document.getElementById('carbonChart').getContext('2d');
        new Chart(carbonCtx, {
            type: 'line',
            data: {
                labels: ['2565', '2566'], //connect database
                datasets: [{
                    label: 'การปล่อยคาร์บอน (Emission)',
                    data: [50, 45, ], //connect database
                    borderColor: '#ff6b6b',
                    backgroundColor: 'rgba(255, 107, 107, 0.2)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'การลดการปล่อยคาร์บอน (Reduction)',
                    data: [25, 20, ], //connect database
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
                            text: 'Carbon Emissions (TonCO2-eq)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        beginAtZero: true,
                    }
                }
            }
        });

        // Month picker initialization
        $(document).ready(function() {
            $("#monthpicker").datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'MM yy',
                yearRange: "2020:2030",
                onClose: function(dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
                }
            });
        }); */

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
                            text: 'Carbon Footprint (metric tons)',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Type',
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