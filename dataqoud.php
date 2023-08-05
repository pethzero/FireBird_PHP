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
  include("0_headcss.php"); ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
  <?php
  include("0_header.php");
  include("0_breadcrumb.php");
  ?>
  <link rel="stylesheet" href="css/mycustomize.css">
  <style>

  </style>


  <section>
    <div class="container pt-3">
      <h2>ข้อมูล</h2>
      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="showAllBtn" name="fav_language" value="all" checked>
          <label for="showAllBtn">แสดงทั้งหมด</label>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="showApprovedBtn" name="fav_language" value="approved">
          <label for="showApprovedBtn">ทำการอนุมัติแล้ว</label>

        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <input type="radio" id="waitApprovedBtn" name="fav_language" value="wait">
          <label for="waitApprovedBtn">รอทำการอนุมัติ</label>
        </div>

      </div>

      <div class="row mb-3">
        <div class="col-sm-12 col-md-6 col-lg-6">
          <label for="searchInput" class="form-label">ค้นหารายการรหัสลูกค้า แบบกรอง</label>
          <div class="input-group">
            <select class="form-control select2" id="searchInput"></select>
            <button class="btn btn-primary" id="searchClear">ล้าง</button>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-12">
          <h1>ใบเสนอราคา</h1>
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ข้อมูล</th>
                <th>เลขที่ใบเสนอราคา</th>
                <th>สถานะ</th>
                <th>รหัสลูกค้า</th>
                <th>ชื่อลูกค้า</th>
                <th>วันที่เปิดใบเสนอราคา</th>
                <th>วันหมดอายุ</th>
                <th>ราคารวม Vat</th>
                <th>ผู้ขาย</th>
                <th>ผู้ทำเอกสาร</th>
                <th>ผู้อนุมัติ</th>
                <th>REMARK</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>



      <div class="row mb-3 justify-content-end">
        <div class="col-sm-12 col-md-3 col-lg-3">
          <label for="pageInput" class="mr-2">Jump to Page:</label>
          <div class="input-group">
            <input type="number" class="form-control mr-2" id="pageInput">
            <button class="btn btn-primary" id="btnjump">ตกลง</button>
          </div>
        </div>
      </div>




    </div>

    </div>
  </section>


  <section>
    <div class="container pt-3">
      <div class="row">
        <div class="col-12">
          <h1>ข้อมูลใบเสนอราคา<label id="dtdocno"></label></h1>
          <table id="table_datadt" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>รหัสสินค้า</th>
                <th>รายการ</th>
                <th>จำนวน</th>
                <th>หน่วย</th>
                <th>ราคาต่อหน่วย</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </section>

  <hr>
  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-12">
          <h3 class="text-center">&nbsp;</h3>
        </div>
        <div class="col-md-4 col-12">
          <h3 class="text-center">SAN Co.,Ltd.</h3>
          <address class="text-center">
          </address>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="hq" aria-labelledby="hqLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="hqLabel">ใบเสนอราคา</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="row">
            <div class="col-12 pb-3">
              เลขที่ใบเสนอราคา: <span id="docNo"></span>
            </div>
            <div class="col-12 pb-3">
              ชื่อลูกค้า: <span id="name"></span>
            </div>
            <div class="col-12 pb-3">
              รหัสลูกค้า: <span id="code"></span>
            </div>
            <div class="col-12 pb-3">
              วันที่เปิดใบเสนอราคา: <span id="qdocDate"></span>
            </div>
            <div class="col-12 pb-3">
              ราคา: <span id="price"></span>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
              <label class="form-label mb-0">ผู้เสนอขาย:</label>
              <span id="saleName"></span>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">
              <select class="form-select" id="selectMenusaleName" aria-label="Select Sale">
              </select>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
              <label class="form-label mb-0">ผู้ทำเอกสาร:</label>
              <span id="makegerName"></span>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">
              <select class="form-select" id="selectMenumakegerName" aria-label="Select Document Maker">
              </select>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
              <label class="form-label mb-0">ผู้อนุมัติ:</label>
              <span id="approverName"></span>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6">
              <select class="form-select" id="selectMenuapproverName" aria-label="Select Approver">
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-sm-12">
              <div class="d-flex align-items-center">
                <span class="mr-2 mt-1">การอนุมัติ:</span>
                <button class="btn btn-success btn-sm" id="approverBtn" disabled>อนุมัติ</button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button id="save" type="button" class="btn btn-primary">บันทึก</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div>

  <div class="loading">

</body>
<?php include("0_footerjs.php"); ?>
<script src="js/dtcolumn.js"></script>


<script>
  $(document).ready(function() {
    var tablejsondata;
    var selectedRow = null;
    var selectedRecno = null;

    var encodedURL = encodeURIComponent('ajax_data.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      ajax: {
        url: encodedURL,
        data: function(d) {
          d.queryId = '0001'; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.params = null;
        },
        dataSrc: function(json) {
          tablejsondata = json.data
          return json.data;
        }
      },
      scrollX: true,
      columns: dtcolumn['dataquoud'],
      order: [
        [0, 'desc']
      ],
      dom: 'Blfrtip',
      buttons: ['colvis'],
      columnDefs: [{
          type: 'currency',
          targets: 8
        },
        {
          "visible": false,
          "targets": 0
        },
        { "orderable": false, "targets": 1 },
        // {
        //     searchPanes: {
        //         show: true
        //     },
        //     targets: [2]
        // },
        // {
        //     searchPanes: {
        //         show: false
        //     },
        //     // targets: [0,1,2,3,4,5,6,7,8,9,10,11,12,13]
        //     targets: [0,1,2,4,5,6,7,8,9,10,11,12]
        // }
      ],
      // columnDefs: [
      //   { type: 'currency', targets: 8 },
      //   {"visible": false,"targets": 0},
      //  ],
      // buttons: [
      //       'searchPanes'
      //   ],
      // dom: 'Bfrtip',
      // dom: 'Plfrtip',
      //   searchPanes: {
      //       preSelect: [{
      //           rows:['Edinburgh','London'],
      //           column: 2
      //       }]
      //   },
      // pageLength: 10, // กำหนดจำนวนแถวต่อหน้าที่แสดง
      // paging: true, // เปิดใช้งานปุ่มแสดงเลขหน้า
      initComplete: function(settings, json) {
        $('.loading').hide();
        data_json(tablejsondata)
        select_get()
      },
      createdRow: function(row, data, dataIndex) {
        // ค่าของคอลัมน์ STATUS อยู่ใน data.STATUS
        // console.log(status);
        // let status = data.EMPNAMEAPPROVER !== '' ? 'bg-success' : 'bg-danger';
        // $(row).find('td:eq(2)').addClass(status); // ในที่นี้ คอลัมน์ STATUS มีลำดับที่ 3 (จำนวนคอลัมน์เริ่มต้นที่ 0)
      },
      drawCallback: function(settings) {
        if (init_op == 1) {
          $('.loading').hide();
          Swal.fire(
            'บันทึกแล้ว',
            'คุณได้อนุมัติใบเสนอราคา : ' + docno,
            'success'
          )
          init_op = 0;
        }
      },
      rowCallback: function(row, data) {
        // console.log('rowCallback')
        $(row).on('click', function() {
          if (selectedRow !== null) {
            $(selectedRow).removeClass('table-custom');
          }
          $(this).addClass('table-custom');
          selectedRow = this;

          if (selectedRecno !== data.RECNO) {
            // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
            tabledtpost(data.RECNO);
            $('#dtdocno').text('  ' + data.QDOCNO);
            selectedRecno = data.RECNO;
            // console.log(data.RECNO);
          }
        });
      },

    });

    var dataX = [{
      "id": 0,
      "text": "---",
      "value": ""
    }];

    function data_json(tablejsondata) {
      var existingCodes = {};
      for (var i = 0; i < tablejsondata.length; i++) {
        var cus_code = tablejsondata[i]['CODE'];
        var cus_name = tablejsondata[i]['NAME'];

        if (!existingCodes[cus_code]) {
          dataX.push({
            "id": dataX.length + 1,
            "text": cus_code + ":" + cus_name,
            "value": cus_code
          });

          existingCodes[cus_code] = true;
        }
      }
      dataX.sort(function(a, b) {
        return a.value.localeCompare(b.value);
      });
    }


    var table_datadt = $('#table_datadt').DataTable({
      scrollX: true,
      columns: dtcolumn['dataquoud_dt'],
      order: [
        [0, 'desc']
      ],
      columnDefs: [
        {
        "visible": false,
        "targets": 0
      }, ],
      dom: 'rt',
      drawCallback: function(settings) {
        // table_datadt.ajax.reload();
      }
    });


    function tabledtpost(recnodt) {
      $.ajax({
        url: 'ajax_data.php',
        data: {
          // queryId: '0003',
          queryId: '0006',
          params: { // อาร์เรย์ params ที่คุณต้องการส่ง
            RECNO: recnodt,
          },
        },
        dataSrc: '',
        success: function(response) {
          var dataArray = JSON.parse(response);
          table_datadt.clear();
          table_datadt.rows.add(dataArray.data).draw();
        },
        error: function(xhr, status, error) {
          // จัดการข้อผิดพลาดที่เกิดขึ้น
          console.error(error);
        }
      });

    }

    var recno_no;
    var recno_saleName;
    var recno_makegerName;
    var recno_approverName;
    var docno;
    $('#table_datahd').on('click', '.btn-primary', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      docno = rowData.QDOCNO;
      var name = rowData.NAME;
      var code = rowData.CODE;
      var qdocdate = rowData.QDOCDATE;
      var saleName = rowData.EMPNAMESALES;
      var makegerName = rowData.EMPNAMEMAKER;
      var approverName = rowData.EMPNAMEAPPROVER;
      var price = rowData.NETAMT;
      // console.log(qdocdate);

      $('#docNo').text(docno);
      $('#name').text(name);
      $('#code').text(code);
      $('#qdocDate').text(formatDate(qdocdate));
      $('#saleName').text(saleName);
      $('#makegerName').text(makegerName);
      $('#approverName').text(approverName);
      $('#price').text(price + " บาท");

      ///////////////////////////////////////////////////////////////////////////
      recno_no = rowData.RECNO;
      recno_saleName = setSelect2Value('#selectMenusaleName', saleName);
      recno_makegerName = setSelect2Value('#selectMenumakegerName', makegerName);
      recno_approverName = setSelect2Value('#selectMenuapproverName', approverName);
      ////////////////////////////////////////////////////////////////////

      if (approverName) {
        // ถ้ามีชื่อผู้อนุมัติ
        $('#approverBtn').text("ทำการอนุมัติแล้ว");
        $('#approverBtn').removeClass('btn-danger').addClass('btn-success');
      } else {
        // ถ้าไม่มีชื่อผู้อนุมัติ
        $('#approverBtn').text('รอทำการอนุมัติ');
        $('#approverBtn').removeClass('btn-success').addClass('btn-danger');
      }
    });

    handleRadioChange();

    function handleRadioChange() {
      $('#showAllBtn').on('change', function() {
        if ($(this).is(':checked')) {
          // เปลี่ยนเงื่อนไขการค้นหาให้เป็นค่าว่าง
          $('#table_datahd').DataTable().columns(3).search('').draw();
          $('#table_datahd').DataTable().columns(11).search('').draw();
        }
      });

      // เมื่อเลือกปุ่มแสดงผู้อนุมัติ
      $('#showApprovedBtn').on('change', function() {
        if ($(this).is(':checked')) {
          // เปลี่ยนเงื่อนไขการค้นหาให้เป็นค่า "ผู้อนุมัติ"
          $('#table_datahd').DataTable().columns(3).search('อนุมัติแล้ว').draw();
          $('#table_datahd').DataTable().columns(11).search('.+', true, false).draw();
        }
      });

      $('#waitApprovedBtn').on('change', function() {
        if ($(this).is(':checked')) {
          // เปลี่ยนเงื่อนไขการค้นหาให้เป็นค่าว่าง
          $('#table_datahd').DataTable().columns(3).search('รออนุมัติ').draw();
          $('#table_datahd').DataTable().columns(11).search('^$', true, false).draw();
        }
      });
    }

    function select_get() {
      $('#searchInput').select2({
        data: dataX,
        closeOnSelect: true,
        theme: 'bootstrap-5',
        templateSelection: function(selected) {
          if (selected.id !== '') {
            if (selected.id == 0) {
              return '';
            }
            return selected.text + ' : ' + selected.value;

          }
          return '';
        },
        templateResult: function(result) {
          // console.log(result)
          if (!result.id) {
            return result.text;
          }
          var $result = $('<span></span>');
          // $result.text(result.text + ' (Input: ' + result.value + ')');
          $result.text(result.text);
          // return $result;
          if (result.id == 0) {
            $result.text('---');
            return $result;
          } else {
            return $result;
          }
        },
        matcher: function(params, data) {
          if ($.trim(params.term) === '') {
            return data;
          }
          // console.log(data)
          var inputText = params.term.toLowerCase().replace(/\s/g, '');
          var optionText = data.text.toLowerCase().replace(/\s/g, '');
          var optionValue = data.value.toLowerCase().replace(/\s/g, '');
          if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1) {
            return data;
          }
          return null;
        }
      }).on('change', function() {
        var selectedValue = $(this).select2('data')[0].value;
        // const selectedValue = $(this).val(); // ค่าที่ถูกเลือกใน <select>
        // console.log(selectedValue)
        $('#table_datahd').DataTable().column(4).search(selectedValue).draw();
      });
    }

    $('#searchClear').on('click', function() {
      var selectInput = document.getElementById("searchInput");
      var optionToSelect = "0"; // ตัวเลือกที่ต้องการเลือก (เปลี่ยนเป็นค่าที่คุณต้องการ)
      // ตรวจสอบว่าตัวเลือกที่ต้องการเลือกมีอยู่ใน select หรือไม่
      if (selectInput.querySelector(`option[value="${optionToSelect}"]`)) {
        $(selectInput).val(optionToSelect).trigger("change.select2");
      }
      $('#table_datahd').DataTable().column(4).search('').draw();

    })


    $("#btnjump").click(function() {
      jumpToPage();
    });

    function jumpToPage() {
      var pageNumber = parseInt($('#pageInput').val(), 10);
      var maxPage = table.page.info().pages;

      if (pageNumber >= 1 && pageNumber <= maxPage) {
        table.page(pageNumber - 1).draw('page');
        $('#pageInput').val('')
      } else {
        Swal.fire(
          'Invalid page number',
          'มีการป้อนข้อมูลผิดพลาด',
          'error'
        )
        $('#pageInput').val('')
      }
    }

    $("#save").click(function() {
      AlertSave()
    });


    function AlertSave() {
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
          $('#hq').modal('hide');
          SaveData()
          // console.log('จบ')

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

    var init_op = 0;

    function SaveData() {
      var rowData = table.row(selectedRow).data(); // ดึงข้อมูลแถวที่เลือกใน DataTable
      var rowIndex = table.row(selectedRow).index(); // หาตำแหน่งแถวที่เลือกใน DataTable

      // console.log(rowData)
      // console.log(rowIndex)
      // console.log(rowData)
      rowData.QDOCNO = 'SX'
      rowData.EMPNAMEAPPROVER = 'คมกริช ยาวระ'
      rowData.STATUS = 'คมกริช ยาวระ'

      // console.log(rowIndex)
      // console.log(rowData)
      table.row(rowIndex).data(rowData).draw();
      // $.ajax({
      //   type: "POST",
      //   url: 'ajax_dupdate.php',
      //   data: {
      //     queryIdHD: 'UD_QUOTHD',
      //     queryIdDT: '',
      //     condition: 'U',
      //     paramhd: { // อาร์เรย์ params ที่คุณต้องการส่ง
      //       RECNO: recno_no,
      //       SALES: recno_saleName,
      //       MAKER: recno_makegerName,
      //       APPROVER: recno_approverName,
      //     },
      //     paramdt: { // อาร์เรย์ params ที่คุณต้องการส่ง
      //       datanull: '',
      //     },
      //     paramlist: {
      //       datanull: '',
      //     },
      //     DataJSON: null
      //   },
      //   dataSrc: '',
      //   beforeSend: function() {},
      //   complete: function() {},
      //   success: function(response) 
      //   {

      //     // console.log('load')

      //     init_op = 1;
      //     // table.ajax.reload();
      //     // $('.loading').show();


      //   },
      //   error: function(xhr, status, error) {
      //     console.error(error);
      //   }
      // });
    }

    var emp_list;
    Employee_list()

    function Employee_list() {
      $.ajax({
        url: 'ajax_data_select.php',
        data: {
          queryId: 'EMPL_LIST',
          params: null,
          condition: '',
        },
        dataSrc: '',
        success: function(response) {
          emp_list = JSON.parse(response).data;
          data_json_name(emp_list)
          createSelect2('#selectMenusaleName', data_emp_name, 'sale');
          createSelect2('#selectMenumakegerName', data_emp_name, 'maker');
          createSelect2('#selectMenuapproverName', data_emp_name, 'apporver');
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    function createSelect2(selector, data, ifcondition) {
      return $(selector).select2({
        data: data,
        // closeOnSelect: true,
        theme: 'bootstrap-5',
        dropdownParent: $('#hq'),
        templateSelection: function(selected) {
          if (selected.id !== '') {
            if (selected.id == 0) {
              return '';
            }
            return selected.text + ' : ' + selected.value;
          }
          return '';
        },
        templateResult: function(result) {
          if (!result.id) {
            return result.text;
          }
          var $result = $('<span></span>');
          $result.text(result.text);
          if (result.id == 0) {
            $result.text('---');
            return $result;
          } else {
            return $result;
          }
        },
        matcher: function(params, data) {
          if ($.trim(params.term) === '') {
            return data;
          }
          var inputText = params.term.toLowerCase().replace(/\s/g, '');
          var optionText = data.text.toLowerCase().replace(/\s/g, '');
          var optionValue = data.value.toLowerCase().replace(/\s/g, '');
          if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1) {
            return data;
          }
          return null;
        }
      }).on('change', function() {
        if (ifcondition === 'sale') {
          recno_saleName = $(this).select2('data')[0].value;
        } else if (ifcondition === 'maker') {
          recno_makegerName = $(this).select2('data')[0].value;
        } else if (ifcondition === 'apporver') {
          recno_approverName = $(this).select2('data')[0].value;
        }
      });
    }

    var data_emp_name = [{
      "id": 0,
      "text": "---",
      "value": ""
    }];

    function data_json_name(emp_list) {
      var existingCodes = {};
      for (var i = 0; i < emp_list.length; i++) {
        var cus_code = emp_list[i]['RECNO'];
        var cus_name = emp_list[i]['EMPNAME'];

        if (!existingCodes[cus_code]) {
          data_emp_name.push({
            "id": data_emp_name.length + 1,
            "text": cus_name,
            "value": cus_code
          });

          existingCodes[cus_code] = true;
        }
      }
      data_emp_name.sort(function(a, b) {
        return a.value.localeCompare(b.value);
      });
    }

    function setSelect2Value(selector, searchText) {
      $(selector).val(null).trigger("change.select2"); // ยกเลิกการเลือกทุกตัวเลือกก่อน
      var optionFound = false;
      $(selector).find('option').each(function() {
        if ($(this).text().toLowerCase() === searchText.toLowerCase()) {
          $(this).prop('selected', true);
          optionFound = true;
          return false; // หยุดการวนลูปเมื่อพบตัวเลือกที่ต้องการ
        }
      });
      // ทำการเปิดใช้งาน select2 ใหม่หลังจากทำการเลือกตัวเลือก
      $(selector).trigger('change.select2');
      if (!optionFound) {
        // หากไม่พบตัวเลือกที่ต้องการ
        return '';
      } else {
        return $(selector).select2('data')[0].value;
      }
    }
  });
</script>

</html>