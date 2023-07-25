<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  session_start();
  //  echo $_SESSION["RECNO"];
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  ?>
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome-4.7.0.min.css"> -->
  <link rel="stylesheet" href="css/fontawesome-6.4.0.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> -->
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
  <?php
  include("0_header.php");
  include("0_breadcrumb.php");

  ?>
  <link rel="stylesheet" href="css/mycustomize.css">
  <style>
    .c_activity {
      width: 100px;
    }

    .h_textarea {
      height: 110px;
    }

    /* textarea {
      overflow-y: scroll;
    } */

    .datepicker td,
    th {
      text-align: center;
      padding: 8px 12px;
      font-size: 14px;
    }

    .datepicker {
      border: 1px solid black;
    }
  </style>

  <?php
  include("connect.php");
  include("sql.php");
  // include("0_fselect.php");
  ?>
  <form id="idForm" method="POST">
    <section>
      <div class="container">
        <h2 id="dataactivity">ตารางนัดหมาย</h2>
        <hr>
        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="input-group mb-3">
              <span class="input-group-text c_activity">บริษัท:</span>
              <select class="form-select" id="cust">
                <!-- <option value="-1">เลือกชื่อบริษัท...</option> -->

              </select>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="input-group mb-3">
              <select class="form-select cont" id="cont">
              </select>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="input-group mb-3">
              <span class="input-group-text c_activity">ลูกค้า:</span>
              <input type="text" class="form-control" id="contname" placeholder="ลูกค้า">
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="input-group mb-3">
              <span class="input-group-text c_activity">อ้างอิง:</span>
              <input type="text" class="form-control" id="ref" placeholder="อ้างอิง">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="input-group mb-3">
              <span class="input-group-text c_activity">โทรศัทพ์:</span>
              <input type="text" class="form-control" id="tel" placeholder="โทรศัทพ์">
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="input-group mb-3">
              <span class="input-group-text c_activity">อีเมล:</span>
              <input type="text" class="form-control" id="email" placeholder="อีเมล">
            </div>
          </div>
        </div>

        <!-- <div class="row ">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="row">
            <div class="input-group mb-3">
              <span class="input-group-text c_activity">ลูกค้า:</span>
              <input type="text" class="form-control"  id="contname" placeholder="ลูกค้า">
            </div>

            <div class="input-group mb-3">
                <span class="input-group-text c_activity" id="ref">อ้างอิง:</span>
                <input type="text" class="form-control" placeholder="อ้างอิง">
            </div>

          </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="input-group mb-3">
              <span class="input-group-text c_activity" >โทรศัทพ์:</span>
              <input type="text" class="form-control"  id="tel" placeholder="โทรศัทพ์">
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text c_activity" >อีเมล:</span>
              <input type="text" class="form-control" id="email" placeholder="อีเมล">
            </div>  
        </div>
      </div> -->

        <div class="row mb-3">
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">

            <div class="input-group ">
              <span class="input-group-text">ตำแหน่งนัดหมาย</span>
              <textarea id="addr" class="form-control h_textarea" rows="3" aria-label="With textarea"></textarea>
            </div>

            <div class="mt-2">
              <label class="form-label">สถานที่ติดต่อ</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="location" id="location1" value='I' checked>
                <label class="form-check-label" for="location1">
                  นอกสถานที่
                </label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="location" id="locatio2" value='O'>
                <label class="form-check-label" for="locatio2">
                  ภายในบริษัท
                </label>
              </div>
            </div>
          </div>
        </div>


        <div class="row mb-3">
          <div class="input-group">
            <span class="input-group-text c_activity">เรื่อง:</span>
            <input type="text" class="form-control" id="subject" placeholder="หัวข้อที่นัดหมาย">
          </div>
        </div>

        <div class="row mb-3">
          <div class="input-group">
            <span class="input-group-text">รายละเอียด:</span>
            <textarea id="detail" class="form-control h_textarea" rows="3" aria-label="With textarea"></textarea>
          </div>
        </div>


        <div class="row ">
          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="row">
              <!-- <div class="input-group mb-3">
                <span class="input-group-text c_activity" id="ref">อ้างอิง:</span>
                <input type="text" class="form-control" placeholder="อ้างอิง">
            </div> -->
              <!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity" id="ref">อ้างอิง:</span>
                <input type="text" class="form-control" placeholder="อ้างอิง">
              </div>
            </div> -->
              <!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity" id="">Status:</span>
                <input type="text" class="form-control" placeholder="บริษัท">
              </div>
            </div> -->
            </div>

            <div class="row">
              <div class="input-group mb-3">
                <span class="input-group-text c_activity">สถานะ:</span>
                <select class="form-select" id="status">
                  <option value="-1" selected>เลือก...</option>
                  <option value="A">ยังไม่เริ่มดำเนินการ</option>
                  <option value="I">อยู่ระหว่างดำเนินการ</option>
                  <option value="W">รอดำเนินการ</option>
                  <option value="D">ถูกเลื่อนออกไป</option>
                  <option value="F">เสร็จสิ้น</option>
                </select>
              </div>

              <div class="input-group mb-3">
                <span class="input-group-text c_activity">ความสำคัญ:</span>
                <select class="form-select" id="priority">
                  <option value="-1" selected>เลือก...</option>
                  <option value="H">สูง</option>
                  <option value="N">ปกติ</option>
                  <option value="L">ต่ำ</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                <div class="input-group mb-3">
                  <label class="form-label mt-2">ระยะเวลา</label>
                </div>
              </div>

              <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                <div class="input-group mb-3">
                  <span class="input-group-text ">วัน:</span>
                  <input type="number" class="form-control" min=0 value=0 id="timed" placeholder="">
                </div>
              </div>
              <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                <div class="input-group mb-3">
                  <span class="input-group-text ">ชม:</span>
                  <input type="number" class="form-control" min=0 value=0 id="timeh" placeholder="">
                </div>
              </div>

              <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3">
                <div class="input-group mb-3">
                  <span class="input-group-text ">น.:</span>
                  <input type="number" class="form-control" min=0 value=0 id="timem" placeholder="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="input-group date mb-3" id="datepicker">
                <span class="input-group-text c_activity">วันที่นัด:</span>
                <input type="text" class="form-control" id="date" />
                <span class="input-group-append">
                  <span class="input-group-text bg-light d-block">
                    <i class="fa fa-calendar"></i>
                  </span>
                </span>
              </div>
            </div>



          </div>

          <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="input-group mb-3">
              <span class="input-group-text c_activity">ค่าใช้จ่าย:</span>
              <input id="pcost" type="number" min=0 class="form-control">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text c_activity">ค่าเบิก:</span>
              <input id="pwithdraw" type="number" min=0 class="form-control">
            </div>

            <div class="input-group mb-3">
              <span class="input-group-text ">เจ้าของนัดหมาย:</span>
              <select class="form-select" id="owner">
              </select>
            </div>

          </div>
        </div>


        <!-- <button id="ok" type="button" class="btn btn-primary">บันทึก</button> -->
        <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>

      </div>
    </section>




    <hr>
    <footer class="text-center mt-auto">
      <div class="container pt-2">
        <div class="row">
          <div class="col-12">
            <p>Copyright ? SAN Co.,Ltd. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
    <?php
    //  include("0_footer.php");
    ?>

    <!-- <div class="modal fade" id="hq" aria-labelledby="hqLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hqLabel">ใบเสนอราคา</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">



          <div class="modal-footer">
            <button id="save" type="button" class="btn btn-primary">บันทึก</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          </div>
        </div>
      </div>
    </div> -->

    <!-- <div class="loading"> -->
  </form>

</body>
<?php include("0_footerjs.php"); ?>
<script src="js/dtcolumn.js"></script>


<script>
  $(document).ready(function() {


    var recno_cust = -1;
    var name_cust = "";
    var recno_cont = -1;
    var name_cont = "";
    var recno_tel = "";
    var recno_email = "";
    var recno_location = $("input[name='location']:checked").val();
    var recno_owner = -1;
    var recno_nowner = "";
   
    $(window).keydown(function(event){
    if((event.keyCode == 13) && ($(event.target)[0]!=$("textarea")[0])) {
        event.preventDefault();
            return false;
        }
    });

    function matchCustom(params, data) {
      var inputText = $.trim(params.term).toLowerCase().replace(/\s/g, '');
      var optionText = data.text.toLowerCase().replace(/\s/g, '');

      if (inputText === '') {
        return data;
      }
      if (typeof data.text === 'undefined') {
        return null;
      }
      if (optionText.indexOf(inputText) > -1) {
        var modifiedData = $.extend({}, data, true);
        return modifiedData;
      }
      return null;
    }

    function matchCustom_ajax(params, data) {
      if ($.trim(params.term) === '') {
        return data;
      }
      console.log(data)
      var inputText = params.term.toLowerCase().replace(/\s/g, '');
      var optionText = data.text.toLowerCase().replace(/\s/g, '');
      var optionValue = data.value.toLowerCase().replace(/\s/g, '');
      var optionTitle = data.title.toLowerCase().replace(/\s/g, '');
      if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
        return data;
      }
      return null;
    }

    // $('#datepicker').datepicker();
    $('#date').val(moment(new Date()).format('DD/MM/YYYY'));
    $(function() {
      $("#datepicker").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true
      });
    });

    var con_list;
    var contact;
    var targetEmail = '';
    var targetTel = '';
  
    var data_cont_name = [
      {
      "id": 0,
      "text": "เลือกชื่อลูกค้า...",
      "value": "-1"
    }
   ];
    var cust_list;
    var data_cust_name = [];

  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // GET CONTACT
    function Contact_list(recno_data)
    {
      $.ajax({
        url: 'ajax_data_select.php',
        data: {
          queryId: 'CUSTCONT_LIST',
          params: {
            CUST: recno_data
          },
          condition: '',
        },
        dataSrc: '',
        success: function(response) {
          con_list = JSON.parse(response).data;
          data_json_name(con_list)
          console.log(con_list)
          $('#cont').empty();
          $('#cont').select2("destroy").select2();
          createSelect_contact('#cont', data_cont_name);
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }
    // DATA JSON SEND SELECT2
    function data_json_name(data_list)
    {
      data_cont_name = [{}]
      data_cont_name.push({
        "id": 0,
        "text": "เลือกชื่อลูกค้า...",
        "value": "-1"
      });
      var existingCodes = {};
      for (var i = 0; i < data_list.length; i++) {
        var select2_code = data_list[i]['RECNO'];
        var select2_name = data_list[i]['CONTNAME'];

        if (select2_name != '') {
          if (!existingCodes[select2_code]) {
            data_cont_name.push({
              "id": data_cont_name.length + 1,
              "text": select2_name,
              "value": select2_code
            });
            existingCodes[select2_code] = true;
          }
        }

      }
      data_cont_name.sort(function(a, b) {
        return a.value.localeCompare(b.value);
      });
    }

    createSelect_contact('#cont', data_cont_name);
    function createSelect_contact(selector, data)
    {
      return $(selector).select2({
        data: data,
        // closeOnSelect: true,
        theme: 'bootstrap-5',
        // tags: true,
        // maximumSelectionLength: 1,
        matcher: matchCustom
      });
    }

    $("#cont").change(function()
          {
          recno_cont = $(this).select2('data')[0].value;
          $("#email").val("");
          $("#tel").val("");
          // ค้นหาค่า CONTEMAIL ที่มี RECNO เท่ากับ recno_cont
          var targetItem = con_list.find(item => item.RECNO === recno_cont.toString());
          name_cont = targetItem ? targetItem.CONTNAME : '';
          recno_tel = targetItem ? targetItem.CONTEMAIL : '';
          recno_email = targetItem ? targetItem.CONTTEL : '';
          $("#contname").val(name_cont);
          $("#email").val(recno_tel);
          $("#tel").val(recno_email);
        });


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // GET cust_list()
    cust_list()
    function cust_list()
    {
      $.ajax({
        url: 'ajax_data_select.php',
        data: {
          queryId: 'CUST_LIST',
          params: null,
          condition: '',
        },
        dataSrc: '',
        success: function(response) {
          cust_list = JSON.parse(response).data;
          data_json_cust(cust_list)
          console.log(data_cust_name)
          createSelect_customer('#cust', data_cust_name);
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }
    // DATA JSON SEND SELECT2
    function data_json_cust(data_list_cust) {
      // ตรวจสอบและตั้งค่า data_cust_name ใหม่ทุกครั้งที่เรียกใช้งานฟังก์ชัน
      data_cust_name = [{
        "id": 0,
        "text": "เลือกชื่อบริษัท...",
        "value": "-1",
        "title": ""
      }];
      var existingCodes = {};
      for (var i = 0; i < data_list_cust.length; i++) {
        var select2_recno = data_list_cust[i]['RECNO'];
        var select2_code = data_list_cust[i]['CODE'];
        var select2_name = data_list_cust[i]['NAME'];

        if (select2_name != '') {
          if (!existingCodes[select2_code]) {
            data_cust_name.push({
              "id": data_cust_name.length + 1,
              "text": select2_name,
              "value": select2_recno,
              "title": select2_code,
            });
            existingCodes[select2_code] = true;
          }
        }
      }
    }

    function createSelect_customer(selector, data) {
      return $(selector).select2({
        data: data,
        // closeOnSelect: true,
        theme: 'bootstrap-5',
        // tags: true,
        // maximumSelectionLength: 1,
        // dropdownParent: $('#hq'),
        // matcher: matchCustom,
        matcher: matchCustom_ajax,
        templateSelection: function(selected) {
          if (selected.id !== '') {
            if (selected.id == 0) {
              return 'เลือกชื่อบริษัท...';
            }
            return selected.text;
          }
          return '';
        },
        templateResult: function(result) {
          if (!result.id) {
            return result.text;
          }
          var $result = $('<span></span>');
          $result.text("รหัส" + result.title + ":" + result.text);
          if (result.id == 0) {
            $result.text('เลือกชื่อบริษัท...');
            return $result;
          } else {
            return $result;
          }
        }
      }).on('change', function() {
        if ($(this).val() != -1)
        {
          // recno_cust = $(this).val();
          recno_cust = $(this).select2('data')[0].value;
          name_cust = $(this).select2('data')[0].text;
          Contact_list($(this).val())
          $("#contname").val('');
          $("#email").val('');
          $("#tel").val('');
        }
      });
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // ใช้งานฟังก์ชัน data_json เพื่อกำหนดค่าให้กับ data_owner_name
    var owner_list;
    var data_owner_name = [];
    select2_owner_list()
    function select2_owner_list()
    {
      $.ajax({
        url: 'ajax_data_select.php',
        data: {
          queryId: 'EMPL_LIST',
          params: null,
          condition: '',
        },
        dataSrc: '',
        success: function(response) {
          owner_list = JSON.parse(response).data;
          data_owner_name = data_json(owner_list, 'RECNO', 'EMPNO', 'EMPNAME'); // กำหนดค่าใหม่ให้กับ data_owner_name
          console.log('www', data_owner_name)
          createSelect_owner('#owner', data_owner_name)
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    function createSelect_owner(selector, data) {
      let i = 0;
      return $(selector).select2({
        data: data,
        // closeOnSelect: true,
        theme: 'bootstrap-5',
        // tags: true,
        // maximumSelectionLength: 1,
        // dropdownParent: $('#hq'),
        // matcher: matchCustom,
        matcher: matchCustom_ajax,
        templateSelection: function(selected) {
          if (selected.id !== '') {
            if (selected.id == 0) {
              return 'เลือกชื่อผู้รับผิดชอบงาน...';
            }
            return selected.text;
          }
          return '';
        },
        templateResult: function(result) {
          if (!result.id) {
            return result.text;
          }
          var $result = $('<span></span>');
          $result.text("รหัส" + result.title + ":" + result.text);
          if (result.id == 0)
          {
            $result.text('เลือกชื่อผู้รับผิดชอบงาน...');
            return $result;
          } else {
            return $result;
          }
        }
      }).on('change', function() {
      recno_owner =  $(this).select2('data')[0].value;
      
      if(recno_owner == -1){
        recno_nowner = '';
      }else{
        recno_nowner = $(this).select2('data')[0].text;
      }
      console.log(recno_owner)
      console.log(recno_nowner)
      });
    }





    ////////////////////////////////////////////////////////////////////////////////////////////////
    function data_json(data_list, recno_key, code_key, name_key) {
      var target_list = [{
        "id": 0,
        "text": "เลือกชื่อผู้รับผิดชอบงาน...",
        "value": "-1",
        "title": ""
      }];
      var existingCodes = {};
      for (var i = 0; i < data_list.length; i++)
      {
        var select2_recno = data_list[i][recno_key];
        var select2_code = data_list[i][code_key];
        var select2_name = data_list[i][name_key];

        if (select2_name != '') {
          if (!existingCodes[select2_code]) {
            target_list.push({
              "id": target_list.length + 1,
              "text": select2_name,
              "value": select2_recno,
              "title": select2_code,
            });
            existingCodes[select2_code] = true;
          }
        }
      }
      return target_list; // คืนค่า target_list กลับไป
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////

    $("#idForm").submit(function(event) {
      event.preventDefault();
      if (recno_cust == -1) {
        Swal.fire(
          'กรุณาเลือกชื่อบริษัท',
          'ไม่สามารถบันทึกได้',
          'error'
        )
        return false
      }
      // SaveData()
      AlertSave() 

    });

    function AlertSave()
    {
      Swal.fire({
        title: 'คุณแน่ใจแล้วใช่ไหม',
        text: "คุณจะเปลี่ยนกลับไม่ได้!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ตกลงบันทึก',
        cancelButtonText: 'ยกเลิก',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        customClass: {
          confirmButton: 'ok',
          cancelButton: 'cancel'
        },
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          SaveData()
          Swal.fire(
            'บันทึกแล้ว',
            'นัดหมาย: '+name_cust,
            'success'
          )
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          Swal.fire(
            'ยกเลิก',
            'ยังไม่มีการบันทึก',
            'error'
          )
        }
      })
    }


    function SaveData() {
      $.ajax({
        type: "POST",
        url: 'ajax_thai_insert.php',
        data: {
          queryIdHD: 'IND_ACTIVITYHD',
          queryIdDT: '',
          genIdHD: 'GEN_ACTIVITYHD',
          genIdDT: '',
          condition: 'IHD',
          paramhd: { // อาร์เรย์ params ที่คุณต้องการส่ง
            RECNO: '',
            STATUS: $('#status').val(),
            CUSTNAME: name_cust,
            CONTNAME: $('#contname').val(),
            CUST: recno_cust,
            CONT: recno_cont,
            EMAIL: $('#email').val(),
            ADDR: $('#addr').val(),
            LOCATION: recno_location,
            SUBJECT: $('#subject').val(),
            DETAIL: $('#detail').val(),
            REF: $('#ref').val(),
            PRIORITY: $('#priority').val(),
            TIMED: $('#timed').val(),
            TIMEH: $('#timeh').val(),
            TIMEM: $('#timem').val(),
            STARTD: moment($('#date').val(), 'DD/MM/YYYY').format('MM/DD/YYYY'),
            PRICECOST: $('#pcost').val(),
            PRICEPWITHDRAW: $('#pwithdraw').val(),
            OWNERNAME: recno_nowner,
            OWNER: recno_owner,
          },
          paramdt: { // อาร์เรย์ params ที่คุณต้องการส่ง
            datanull: '',
          },
          paramlist: {
            datanull: '',
          },
          DataJSON: null
        },
        dataSrc: '',
        beforeSend: function() {},
        complete: function() {},
        success: function(response)
        {
          // console.log(response)
          if(response.status == 'success')
          {
            console.log('success')
          }
          else{
            Swal.fire(
                'เกิดปัญหาในการบันทึก',
                response.message,
                'error'
              )
          }
        },
        error: function(xhr, status, error)
        {
          console.log('error')
          console.error(error);
        }
      });
    }


    $('html, body').animate({
      scrollTop: $('#dataactivity').offset().top
    }, 100); // ค่าความเร็วในการเลื่อน (มิลลิวินาที)


  });
</script>

</html>