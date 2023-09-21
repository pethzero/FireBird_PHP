<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 5 Example</title>
    <!-- เรียกใช้ CSS ของ Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
    <h1>Merged Data</h1>
    <table class="table">
        <thead>
            <tr>
                <th>CODE</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <!-- ใช้ JavaScript เพื่อแสดงข้อมูลที่ถูกรวมจากตัวอย่างข้อมูล -->
            <script>
                const data = [
                    {
                        CODE: "D016",
                        TOTALAMT: "100.00"
                    },
                    {
                        CODE: "D017",
                        TOTALAMT: "200.00"
                    },
                    {
                        CODE: "D016",
                        TOTALAMT: "150.00"
                    }
                ];

                const mergedData = {};

                // รวมข้อมูลโดยใช้ CODE เป็น key
                data.forEach(item => {
                    const code = item.CODE;
                    const totalAmt = parseFloat(item.TOTALAMT);

                    if (!mergedData[code]) {
                        mergedData[code] = 0;
                    }

                    mergedData[code] += totalAmt;
                });

                // แสดงข้อมูลที่รวมในตาราง
                for (const code in mergedData) {
                    if (mergedData.hasOwnProperty(code)) {
                        const totalAmt = mergedData[code].toFixed(2);

                        document.write(`
                            <tr>
                                <td>${code}</td>
                                <td>${totalAmt}</td>
                            </tr>
                        `);
                    }
                }
            </script>
        </tbody>
    </table>
</div>

<!-- เรียกใช้ JavaScript ของ Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua2tFHKIod5UgbV8kOG0M5z5h/YJwF5v4vCiF5R5f/CnZCl/jx+W9W++Tp" crossorigin="anonymous"></script>
</body>
</html>
