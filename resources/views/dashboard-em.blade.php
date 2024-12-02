<?php
$username = "root";
$password = "";
$database = "cf";


?>

<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carbon Footprint - MedCMU</title>

<!-- Load jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Then load jQuery UI -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- Then load Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<!-- Other scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<script src="monthpicker.js"></script>


<link rel="stylesheet" href="/path/to/cdn/jquery-ui.min.css" />

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
        max-width: 20%;
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

    .monthpicker {
        text-align: center;
        margin-bottom: 40px;
    }

    .calendar-icon {
        color: #01696E;
    }

    .carbon-unit {
        font-size: 18px;
        color: #666;
    }

    .icon-container {
        display: flex;
        justify-content: space-around;
        margin-top: 30px;
    }

    .icon-item {
        text-align: center;
        margin-top: 20px;
        color: #2c7873;
    }

    .icon-item i {
        font-size: 48px;
        margin-bottom: 10px;
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
            <button onclick="location.href='carbon-footprint-MedCMU-dashboard-em'" class="button button-emission">การปล่อยคาร์บอน (CO2)</button>
            <button onclick="location.href='carbon-footprint-MedCMU-dashboard-re'" class="button button-reduction">การลดการปล่อยคาร์บอน (CO2)</button>
        </div>
    </div>
    <div class="show-carbon">
        <div class="carbon-type">การปล่อยคาร์บอน (CO2)</div>
        <div class="carbon-value">
            00,000.00
            <span class="carbon-unit">TonCO2-eq</span>
        </div>
    </div>
    <div class="monthpicker">
        <!-- Month Picker Input -->
        <input id="monthpicker" type="text" placeholder="Select Month and Year">
        <span class="calendar-icon">
            <i class="fas fa-calendar-alt"></i>
        </span>
    </div>
    <div class="bar-container">
        <canvas id="myChart" style="width:100%;max-width:1200px"></canvas>
    </div>
    <script>
        // Carbon Footprint Chart
        const carbonCtx = document.getElementById('carbonChart').getContext('2d');
        new Chart(carbonCtx, {
            type: 'line',
            data: {
                labels: ['2565', '2566'], //connect database
                datasets: [{
                    label: 'การปล่อยคาร์บอน (CO2)',
                    data: [50, 45, ], //connect database
                    borderColor: '#ff6b6b',
                    backgroundColor: 'rgba(255, 107, 107, 0.2)',
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'การลดการปล่อยคาร์บอน (CO2)',
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
        $("#monthpicker").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'MM yy',
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
            }
        });

        $("#monthpicker").focus(function() {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

        // Bar chart
        const xValues = ["Carbon Footprint จากการเผาไหม้เชื้อเพลิง", "Carbon Footprint จากการรั่วไหลและอื่นๆ", "Carbon Footprint จากการใช้พลังงาน", "Carbon Footprint ทางอ้อมอื่นๆ"];
        const yValues = [55, 49, 44, 15];

        // Function to adjust color lightness
        function adjustColor(color, amount) {
            return '#' + color.replace(/^#/, '').replace(/../g, color => ('0' + Math.min(255, Math.max(0, parseInt(color, 16) + amount)).toString(16)).substr(-2));
        }

        // Sort yValues to determine top 3
        const indexedValues = yValues.map((value, index) => ({
            value,
            index
        }));
        indexedValues.sort((a, b) => b.value - a.value);

        const baseColor = "#20B2AA";
        const barColors = new Array(yValues.length).fill("#D3D3D3");

        // Assign colors to top 3
        barColors[indexedValues[0].index] = adjustColor(baseColor, -40);
        barColors[indexedValues[1].index] = adjustColor(baseColor, -20);
        barColors[indexedValues[2].index] = baseColor;

        new Chart("myChart", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
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
        });
    </script>

    <footer class="footer">
        <p>© 2024 Janyapon Saingam. All rights reserved.</p>
        <p>This research was conducted at the Faculty of Medicine, Chiang Mai University.</p>
    </footer>
</body>


</html>