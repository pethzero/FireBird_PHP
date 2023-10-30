<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตัวอย่าง Bootstrap 5 แบบ Table</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>ตัวอย่าง Bootstrap 5 แบบ Table</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ลำดับ</th>
                    <th scope="col">ชื่อ</th>
                    <th scope="col">นามสกุล</th>
                    <th scope="col">อีเมล</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>John
                        addqw
                    </td>
                    <td>Doe</td>
                    <td>john@example.com</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jane</td>
                    <td>Smith</td>
                    <td>jane@example.com</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Bob</td>
                    <td>Johnson</td>
                    <td>bob@example.com</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- เรียกใช้ Bootstrap JS (หากคุณต้องการใช้งานฟีเจอร์ที่ต้องการ JavaScript) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
