<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pie Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="myPieChart" width="400" height="400"></canvas>
    <script>
        // สร้างออบเจ็กต์สำหรับเก็บข้อมูล Pie Chart
        var pieData = {
            labels: [],
            datasets: [
                {
                    data: [],
                    backgroundColor: [],
                },
            ],
        };

        // สร้าง Pie Chart
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: pieData,
        });

        // อัปเดตข้อมูล Pie Chart และสีทุก 2 วินาที
        setInterval(function() {
            // สุ่มข้อมูลจำนวนแบบสุ่มมา
            var randomData = [];
            for (var i = 0; i < 10; i++) {
                randomData.push(Math.floor(Math.random() * 1000));
            }

            // สุ่มสีแบบสุ่มมา
            var colors = [];
            while (colors.length < 10) {
                var color = "#" + ((1 << 24) * Math.random() | 0).toString(16);
                if (!colors.includes(color)) {
                    colors.push(color);
                }
            }

            // อัปเดตข้อมูล Pie Chart
            pieData.labels = randomData;
            pieData.datasets[0].data = randomData;
            pieData.datasets[0].backgroundColor = colors;
            pieChart.update();
        }, 2000);
    </script>
</body>
</html>
