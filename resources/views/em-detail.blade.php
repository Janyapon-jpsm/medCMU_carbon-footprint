<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carbon Footprint Emission</title>
    <link rel="icon" href="\images\leaf-solid.svg" type="image/png">

    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Then load jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            justify-content: center;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .back-icon {
            position: absolute;
            left: 20px;
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
        position: sticky;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 2rem auto;
        max-width: 300px;
    }

    .filter-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .filter-button {
        padding: 8px 20px;
        background-color: #20B2AA;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .filter-button:hover {
        background-color: #01696E;
    }

    #monthpicker {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

        .content-sec {
            display: flex;
            flex-direction: column;
            align-items: center;
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
            text-align: center;
            color: #01696E;
            margin: 0;
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
            max-width: 1100px;
            width: 180%;
            height: 400px;
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
    <form id="filterForm" action="{{ route('dashboard.em-detail') }}" method="GET" class="filter-form">
        <input type="month" id="monthpicker" name="selected_date" value="{{ request('selected_date') }}" />
        <input type="hidden" name="scrollPosition" id="scrollPosition" value="" />
        <button type="submit" class="filter-button">Filter</button>
    </form>
</div>
    


    <div class="content-sec">
        <h2 class="title">Carbon Footprint จากการเผาไหม้เชื้อเพลิง</h2>
        <div class="content">
            <div class="flex-container">
                <div class="chart-container">
                    <canvas id="CombustionChart"></canvas>
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
                    <canvas id="LeakageChart"></canvas>
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
                    <canvas id="EnergyChart"></canvas>
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
                    <canvas id="IndirectChart"></canvas>
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
    // Get the elements based on your HTML structure
    const chartIds = ['CombustionChart', 'LeakageChart', 'EnergyChart', 'IndirectChart'];
    const chartTypes = [
        'Carbon Footprint จากการเผาไหม้เชื้อเพลิง',
        'Carbon Footprint จากการรั่วไหลและอื่นๆ',
        'Carbon Footprint จากการใช้พลังงาน',
        'Carbon Footprint ทางอ้อมอื่นๆ'
    ];
    
    const chartLabels = @json($chartLabels);
    const chartValues = @json($chartValues);
    const charts = [];

    // Create and render each chart
    chartIds.forEach((chartId, index) => {
        const ctx = document.getElementById(chartId).getContext('2d');
        const type = chartTypes[index];
        
        const data = {
            labels: chartLabels[type] || [],
            datasets: [{
                label: 'Carbon Footprint (kg CO2e)',
                backgroundColor: '#20B2AA',
                data: chartValues[type] || []
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: type,
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
                            text: 'Carbon Footprint (kg CO2e)',
                            font: {
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                            },
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            lineWidth: 1
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Emission Sources',
                            font: {
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        };

        charts.push(new Chart(ctx, config));
    });

    // Remove the automatic form submission on date change
    // Handle form submission only when Filter button is clicked
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const selectedDate = document.getElementById('monthpicker').value;
        const form = this;

        // Save current scroll position
        document.getElementById('scrollPosition').value = window.pageYOffset;
        
        // Submit the form
        form.submit();
    });

    // Restore scroll position after page load if available
    window.onload = function() {
        const scrollPosition = document.getElementById('scrollPosition').value;
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition));
        }
    };
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