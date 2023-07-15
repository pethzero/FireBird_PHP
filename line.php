<!DOCTYPE html>
<html>
<head>
    <title>ส่งข้อความแจ้งเตือนผ่าน LINE Notify</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>ส่งข้อความแจ้งเตือนผ่าน LINE Notify</h1>
    <!-- <form id="notifyForm">
        <textarea id="message" name="message" rows="20" cols="50" placeholder="กรอกข้อความที่ต้องการส่ง"></textarea>
        <br>
        <input type="submit" value="ส่งข้อความ">
    </form> -->
    <label for="maintance">บันทึกประวัติเครื่อง:</label>
    <select name="maintance" id="maintance" style="width: 50px;">
        <option value="volvo">ดูแล</option>
        <option value="saab">ซ่อม</option>
    </select>
    <hr>
    <textarea id="message" name="message" rows="10" cols="40" placeholder="กรอกข้อความที่ต้องการส่ง"></textarea>
        <br>
        <hr>
        <button id="ok">SEND</button>
    <div id="result"></div>

    <script>
        $(document).ready(function() {
            $("#ok").click(function(){
              
            var message = $('#message').val().trim();
            $.ajax({
                url: 'ajax_line.php',
                method: 'POST',
                data: {
                    accessToken: 'Hh0ura2RMQuxyHutazonFsR4SdKT5f6ASoAGGEInuXv',
                    message: message,
                },
                success: function(response) {
                    $('#result').text('ส่งข้อความแจ้งเตือนผ่าน LINE Notify สำเร็จ!');
                    $('#message').val(''); // ล้างค่าใน textarea
                },
                error: function(xhr, status, error) {
                    $('#result').text('เกิดข้อผิดพลาดในการส่งข้อความแจ้งเตือนผ่าน LINE Notify');
                }
            });
            });
        });
    </script>
</body>
</html>
