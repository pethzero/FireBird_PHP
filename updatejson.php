<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>อัปเดตข้อมูลใน JSON</title>
  <!-- อิมพอร์ต Bootstrap 5 CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
    <h1>อัปเดตข้อมูลใน JSON</h1>
    <div class="mb-3">
      <label for="name" class="form-label">ชื่อ:</label>
      <input type="text" class="form-control" id="name" required>
    </div>
    <button type="button" class="btn btn-primary" id="updateBtn">อัปเดต</button>
  </div>

  <!-- อิมพอร์ต jQuery และ Bootstrap 5 JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
<script>
$(document).ready(function() {
  // เมื่อคลิกปุ่ม "อัปเดต"
  $("#updateBtn").on("click", function() {
    // ดึงค่าจากช่องกรอกข้อมูล
    var name = $("#name").val();

    // อ่านเนื้อหาของไฟล์ JSON (ex.json)
    $.getJSON("ex.json", function(data) {
      // เพิ่มข้อมูลใหม่ลงในอาเรย์ data
      data.data.push({ name: name });

      // แปลงข้อมูล JSON เป็นข้อความ
      var jsonData = JSON.stringify(data, null, 2);

      // อัปเดตข้อมูลในไฟล์ JSON (ex.json)
      $.ajax({
        url: "ex.json",
        type: "POST",
        data: jsonData,
        contentType: "application/json",
        success: function() {
          alert("อัปเดตข้อมูลเรียบร้อยแล้ว!");
        },
        error: function() {
          alert("เกิดข้อผิดพลาดในการอัปเดตข้อมูล");
        }
      });
    });
  });
});
</script>
</html>
