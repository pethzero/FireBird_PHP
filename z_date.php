<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flatpickr with Custom Sunday Color</title>
  <!-- เรียกใช้ Flatpickr ผ่าน CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body>
  <div class="container mt-5">
    <h1 class="mb-4">Flatpickr with Custom Sunday Color</h1>
    
    <!-- HTML Element สำหรับการเลือกวันที่ -->
    <input type="text" class="form-control" id="datepicker" placeholder="เลือกวันที่">
  </div>

  <script>
    const datePicker = flatpickr("#datepicker", {
      enableTime: false, // ปิดการเลือกเวลา
      dateFormat: "d/m/Y", // รูปแบบวันที่ "DD/MM/YYYY"
      onOpen: function(selectedDates, dateStr, instance) {
        const days = instance.calendarContainer.querySelectorAll(".flatpickr-day");
        days.forEach(function(day) {
          const date = day.dateObj;
          if (date && date.getDay() === 0) {
            // ถ้าวันที่เป็นวันอาทิตย์ (0 = วันอาทิตย์)
            day.style.color = "red"; // เปลี่ยนสีของวันอาทิตย์เป็นแดง
          }
        });
      },
    });
  </script>
</body>
</html>
