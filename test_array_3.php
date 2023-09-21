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
                    <th>NAME</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- ใช้ JavaScript เพื่อแสดงข้อมูลที่ถูกรวมจากตัวอย่างข้อมูล -->
                <script>
                    const data = [{
                            CODE: "D016",
                            NAME: "บริษัท เด็นโซ่ อินโนเวทีฟ แมนูแฟคเจอริ่ง โซลูชั่น เอเชีย จำกัด",
                            TOTALAMT: "100.00"
                        },
                        {
                            CODE: "D017",
                            NAME: "บริษัท ABC Company",
                            TOTALAMT: "200.00"
                        },
                        {
                            CODE: "D016",
                            NAME: "บริษัท เด็นโซ่ อินโนเวทีฟ แมนูแฟคเจอริ่ง โซลูชั่น เอเชีย จำกัด",
                            TOTALAMT: "150.00"
                        }
                    ];

                    const mergedData = {};

                    data.forEach(item => {
                        const code = item.CODE;
                        const name = item.NAME;
                        const totalAmt = parseFloat(item.TOTALAMT);

                        // ใช้การรวม CODE และ NAME เป็น key
                        const key = `${code}`;

                        if (!mergedData[key]) {
                            mergedData[key] = {
                                CODE: code,
                                NAME: name,
                                TOTALAMT: 0
                            };
                        }

                        mergedData[key].TOTALAMT += totalAmt;
                    });

                    console.log(mergedData);
                    // เปลี่ยน mergedData เป็นอาเรย์
                    console.log(resultArray);


                    // แสดงข้อมูลที่รวมในตาราง
                    for (const key in resultArray) {
                        if (resultArray.hasOwnProperty(key)) {
                            const item = resultArray[key];

                            document.write(`
                            <tr>
                                <td>${item.CODE}</td>
                                <td>${item.NAME}</td>
                                <td>${item.TOTALAMT.toFixed(2)}</td>
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