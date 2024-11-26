<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Footprint Emission</title>
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
        }

        .logo {
            max-height: 40px;
        }

        .header h1 {
            display: flex;
            align-items: center;
            margin: 0;
        }

        .monthpicker {
            text-align: left;
            margin: 30px 0px 20px 50px;
        }

        .calendar-icon {
            color: #01696E;
        }

        .title {
            padding-left: 30px;
            color: #01696E;
        }

        .chart-container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0px 20px 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }


        .pics-container {
            text-align: center;

        }

        .cfpics {
            max-height: 200px;
            margin: 10px 40px;
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
    </style>
</head>

<body>
    <div class="header">
        <i class='fas fa-arrow-left' style='font-size:36px' onclick="location.href='carbon-footprint-MedCMU-dashboard-em'"></i>&emsp;&emsp;
        <h1>
            <img class=" logo" src="\images\logo-med.png" />&nbsp; <b>Carbon Footprint </b> &nbsp;&nbsp;<i class="fas fa-leaf"></i>
        </h1>
    </div>

    <div class="monthpicker">
        <!-- Month Picker Input -->
        <input id="monthpicker" type="text" placeholder="Select Month and Year">
        <span class="calendar-icon">
            <i class="fas fa-calendar-alt"></i>
        </span>
    </div>
    <h2 class="title">CF จากการเผาไหม้เชื้อเพลิง</h2>
    <div class="chart-container">
        <canvas id="Chart1"></canvas>
    </div>
    <div class="pics-container">
        <img class="cfpics" src="\images\CF1-1.png" />
        <img class="cfpics" src="\images\CF1-2.png" />
        <img class="cfpics" src="\images\CF1-3.png" />
    </div>

    <h2 class="title">CF จากการรั่วไหลและอื่นๆ</h2>
    <div class="chart-container">
        <canvas id="Chart2"></canvas>
    </div>

    <h2 class="title">CF จากการใช้พลังงาน</h2>
    <div class="chart-container">
        <canvas id="Chart3"></canvas>
    </div>

    <h2 class="title">CF ทางอ้อมอื่นๆ</h2>
    <div class="chart-container">
        <canvas id="Chart4"></canvas>
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

        var xValues = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M"];
        var yValues = [55, 49, 47, 44, 40, 38, 37, 35, 30, 28, 25, 24, 19];
        var barColors = ["red", "green", "blue", "orange", "brown"];

        new Chart("Chart1", {
            type: "horizontalBar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "World Wine Production 2018"
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            min: 10,
                            max: 60
                        }
                    }]
                }
            }
        });

        var xValues = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K"];
        var yValues = [55, 49, 47, 44, 40, 38, 37, 35, 30, 28, 25];
        var barColors = ["red", "green", "blue", "orange", "brown"];

        new Chart("Chart2", {
            type: "horizontalBar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "World Wine Production 2018"
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            min: 10,
                            max: 60
                        }
                    }]
                }
            }
        });

        var xValues = ["A", "B", "C"];
        var yValues = [55, 49, 44];
        var barColors = ["red", "green", "blue"];

        new Chart("Chart3", {
            type: "horizontalBar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "World Wine Production 2018"
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            min: 10,
                            max: 60
                        }
                    }]
                }
            }
        });

        var xValues = ["A", "B", "C", "D", "E", "F", "G", "H"];
        var yValues = [55, 49, 47, 44, 40, 38, 37, 35];
        var barColors = ["red", "green", "blue", "orange", "brown"];

        new Chart("Chart4", {
            type: "horizontalBar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "World Wine Production 2018"
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            min: 10,
                            max: 60
                        }
                    }]
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