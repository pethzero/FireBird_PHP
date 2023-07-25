<!DOCTYPE html>
<html>
<head>
  <title>ตัวอย่าง Select2 และการค้นหาแบบทับซ้อน</title>
  <!-- ติดตั้ง jQuery และ Select2 library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>
<body>

  <h1>ตัวอย่าง Select2 และการค้นหาแบบทับซ้อน</h1>

  <!-- สร้าง Select2 ที่เปิดใช้งานการค้นหาแบบทับซ้อน (tags) -->
  <select id="mySelect" multiple="multiple" >
    <option value="1">Apple</option>
    <option value="2">Banana</option>
    <option value="3">Cherry</option>
    <option value="4">Durian</option>
    <option value="5">Grape</option>
  </select>

  <script>
    // สร้าง Select2 และเปิดใช้งานการค้นหาแบบทับซ้อน
    $(document).ready(function() {
        function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
      return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
      return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.indexOf(params.term) > -1) {
      var modifiedData = $.extend({}, data, true);
      // modifiedData.text += ' (matched)';

      // You can return modified objects from here
      // This includes matching the `children` how you want in nested data sets
      return modifiedData;
    }

    return null;
}

      $("#mySelect").select2({
        // เปิดใช้งานการค้นหาแบบทับซ้อน (tags)
        tags: true,
        maximumSelectionLength: 1
      });
    });
  </script>

</body>
</html>
