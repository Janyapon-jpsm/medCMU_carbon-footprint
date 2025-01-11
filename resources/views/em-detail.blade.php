<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Footprint Emission</title>
    <link rel="icon" href="\images\leaf-solid.svg" type="image/png">

    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Then load jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

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

        .header {
            position: sticky;
            top: 0;
            background-color: #20B2AA;
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .back-icon {
            font-size: 36px;
            background-color: #20B2AA;
            border: #20B2AA;
            border-radius: 20px;
            padding: 10px;
            color: #E5E5E5;
        }

        .back-icon:hover {
            background-color: #01696E;
            color: #f0f0f0;
        }

        .logo {
            max-height: 40px;
        }

        .header h1 {
            display: flex;
            align-items: center;
            margin: 0;
            flex-grow: 1;
            justify-content: center;
        }

        .monthpicker-container {
            display: flex;
            justify-content: flex-start;
            /* Change from center to flex-start */
            align-items: center;
            margin: 2rem;
            /* Change from margin: 2rem auto to just 2rem */
            position: relative;
            max-width: 300px;
            /* If you want it further from the left edge */
            margin-left: 3rem;
            /* Add some space from the left edge */
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

        .content-sec {
            text-align: center;
            width: 1390px;
            padding: 10px;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .content-sec:hover {
            background-color: whitesmoke;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .footer {
            margin-top: 40px;
            padding: 10px 0;
            width: 100%;
            position: relative;
            background-color: #E5E5E5;
            color: #A9A9A9;
            text-align: center;
        }

        .edit-icon {
            font-size: 15px;
            background-color: #E5E5E5;
            border: #E5E5E5;
            border-radius: 20px;
            padding: 10px;
            color: #A9A9A9;
        }

        .edit-icon:hover {
            background-color: #A9A9A9;
            color: #f0f0f0;
        }

        .title {
            padding-left: 30px;
            color: #01696E;
        }

        .content div {
            display: inline-block;
            text-align: left;
        }

        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px auto;
            max-width: 1000px;
            width: 170%;
        }


        .pics-container {
            text-align: center;
        }

        .cfpics {
            max-height: 200px;
            margin: 10px 20px;
        }

        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .flex-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 10px;
            margin: 0 auto;
        }

        .title {
            text-align: left;
            padding-left: 40px;
            color: #01696E;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <button class="back-icon">
            <i class="fas fa-arrow-left" onclick="location.href='carbon-footprint-MedCMU-dashboard-em'"></i>
        </button>
        &emsp;&emsp;
        <h1>
            <img class=" logo" src="\images\logo-med.png" onclick="location.href='carbon-footprint-MedCMU-dashboard-em'" />&nbsp; <b>Carbon Footprint </b> &nbsp;&nbsp;<i class="fas fa-leaf"></i>
        </h1>
    </div>

    <!-- month picker -->
    <div class="monthpicker-container">
        <span class="calendar-icon">
            <i class="fas fa-calendar-alt"></i>
        </span>
        <input id="monthpicker" type="text" placeholder="เลือกเดือนและปี" readonly>
    </div>

    <div class="content-sec">
        <h2 class="title">Carbon Footprint จากการเผาไหม้เชื้อเพลิง</h2>
        <div class="content">
            <div class="flex-container">
                <div class="chart-container">
                    <canvas id="Chart1"></canvas>
                </div>
            </div>
        </div>

        <div class="pics-container">
            <img class="cfpics" src="\images\CF1-1.png" />
            <img class="cfpics" src="\images\CF1-2.png" />
            <img class="cfpics" src="\images\CF1-3.png" />
            <img class="cfpics" src="\images\CF1-4.jpg" />
        </div>
    </div>

    <div class="content-sec">
        <h2 class="title">Carbon Footprint จากการรั่วไหลและอื่นๆ</h2>
        <div class="content">
            <div class="flex-container">
                <div class="chart-container">
                    <canvas id="Chart2"></canvas>
                </div>
            </div>
        </div>

        <div class="pics-container">
            <img class="cfpics" src="\images\CF2-1.png" style="width: 300px; height: 500px;" />
            <img class="cfpics" src="\images\CF2-2.jpg" />
            <img class="cfpics" src="\images\CF2-3.jpg" />
            <img class="cfpics" src="\images\CF2-4.jpg" />
        </div>
    </div>

    <div class="content-sec">
        <h2 class="title">Carbon Footprint จากการใช้พลังงาน</h2>
        <div class="content">
            <div class="flex-container">
                <div class="chart-container">
                    <canvas id="Chart3"></canvas>
                </div>
            </div>
        </div>

        <div class="pics-container">
            <img class="cfpics" src="\images\CF3-1.jpg" />
            <img class="cfpics" src="\images\CF3-2.png" />
            <img class="cfpics" src="\images\CF3-3.jpg" />
            <img class="cfpics" src="\images\CF3-4.jpg" style="width: 300px; height: 500px;" />
        </div>
    </div>

    <div class="content-sec">
        <h2 class="title">Carbon Footprint ทางอ้อมอื่นๆ</h2>
        <div class="content">
            <div class="flex-container">
                <div class="chart-container">
                    <canvas id="Chart4"></canvas>
                </div>
            </div>
        </div>
        <div class="pics-container">
            <img class="cfpics" src="\images\CF4-1.jpg" />
            <img class="cfpics" src="\images\CF4-2.jpg" />
            <img class="cfpics" src="\images\CF4-3.jpg" />
            <img class="cfpics" src="\images\CF4-4.jpg" />
        </div>
    </div>

    <script>
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

        // Sample data for the four charts
        const chart1Data = [55, 49, 47, 44, 40];
        const chart2Data = [60, 50, 45, 40, 35];
        const chart3Data = [70, 65, 60, 55, 50];
        const chart4Data = [80, 75, 70, 65, 60];

        // Function to create a horizontal bar chart
        function createHorizontalBarChart(chartId, labels, data, title) {
            const ctx = document.getElementById(chartId).getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, '#2c7873');
            gradient.addColorStop(1, '#20B2AA');

            const chartData = {
                labels: labels,
                datasets: [{
                    label: title,
                    backgroundColor: gradient,
                    data: data
                }]
            };

            const config = {
                type: 'horizontalBar',
                data: chartData,
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: title,
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Value',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Categories',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        }

        // Create the charts
        createHorizontalBarChart('Chart1', ['A', 'B', 'C', 'D', 'E'], chart1Data, 'Chart 1 Title');
        createHorizontalBarChart('Chart2', ['A', 'B', 'C', 'D', 'E'], chart2Data, 'Chart 2 Title');
        createHorizontalBarChart('Chart3', ['A', 'B', 'C', 'D', 'E'], chart3Data, 'Chart 3 Title');
        createHorizontalBarChart('Chart4', ['A', 'B', 'C', 'D', 'E'], chart4Data, 'Chart 4 Title');
    </script>

    <footer class="footer">
        <p>© 2024 Janyapon Saingam. All rights reserved.</p>
        <p>This research was conducted at the Faculty of Medicine, Chiang Mai University.</p>

        <button class="edit-icon">
            <i class="fas fa-pen" onclick="location.href='admin/login'"></i>
        </button>
    </footer>
</body>

</html>