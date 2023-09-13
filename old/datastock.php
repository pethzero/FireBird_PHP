<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
    session_start(); 
    if (!isset($_SESSION["RECNO"])) 
      {
        header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
        exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
      } 
    include("0_headcss.php"); 
    ?>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.css" integrity="sha512-9rQHiowu3AtR6xVE8Jz+lyV1r2/xXQVW0kI8+O9+PrfWSvoOHDF2SOUIUFAj0mwIAPf1ezTxRlpdngvsZeC4Rw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
    <link rel="stylesheet" href="css/loader.css">
    </noscript> -->
  </head>
  <body>
  <style>
    @media (max-width: 992px)
    {
      .chartMenu {
        width: 100vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(54, 162, 235, 1);
      }
      .chartMenu p {
        padding: 10px;
        font-size: 20px;
      }
      .chartCard {
        width: 100vw;
        height: calc(100vh - 40px);
        background: rgba(54, 162, 235, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .chartBox {
        width: 95%;
        height: 75%;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(54, 162, 235, 1);
        background: white;
      }
    }
.input-gray{
    background-color:#E8E8E8;
    }
  .datepicker td,th {
    text-align: center;
    padding: 8px 12px;
    font-size: 14px;
  } 
  .datepicker {
    border: 1px solid black;
  }

  </style>
  
  <?php 
    include("0_header.php"); 
    include("0_breadcrumb.php"); 
  ?>
<form  method="POST">
<div class="container">


  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
        <h1>ใบเบิกสินค้า</h1>
        <hr>
        <!-- <input type="text" class="form-control" id="barcodeInput" placeholder="กรอกรหัสบาร์โค้ด" > -->
    </div>
  </div>

  

  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
      <div class="mb-3">
        <label for="barcodeInput" class="form-label"><h5>ประเภทเบิก</h5></label>
      </div>
    </div>
  </div>

  <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 ">
          <input type="radio" id="showAllBtn" name="GET_TYPE" value="4" checked>
          <label for="showAllBtn">เบิกเพื่อวัตถุดิบเพื่อผลิต</label>

          <input type="radio" id="showApprovedBtn" name="GET_TYPE" value="5">
          <label for="showApprovedBtn">เบิกวัสดุอุปกรณ์</label>

        </div>
  </div>

  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
      <div class="mb-3">
        <label for="searchInput" class="form-label">ค้นหา</label>
        <!-- <input type="text" class="form-control" id="searchInput" placeholder="" > -->
          <select  class="form-control select2" id="searchInput"> 
          <!-- <option value="">----</option> -->
            <!-- <option value="one">First</option>
            <option value="two" >Second (disabled)</option>
            <option value="three">Third</option> -->
           </select>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
      <div class="mb-3">
        <label for="barcodeInput" class="form-label">Barcode</label>
        <input type="text" class="form-control" id="barcodeInput" placeholder="กรอกรหัสบาร์โค้ด" >
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
      <div class="mb-3">
        <button id="barcodeok" type="button" class="btn btn-primary">ยืนยัน</button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
      <div class="mb-3">
        <label for="docno" class="form-label">DocNo</label>
        <input type="text" class="form-control input-gray" id="docno"  readonly>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
      <div class="mb-3">
        <label for="datepicker" class="form-label">DocDate</label>
        <div class="input-group date" id="datepicker">
            <input type="text" class="form-control" id="date" placeholder="Date Of Birth" />
            <span class="input-group-append">
            </span>
        </div>

      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12-sm col-6-md col-6-lg">
      <div class="mb-3">
        <!-- <button id="confirmButton" type="button" class="btn btn-primary">บันทึกข้อมูล</button> -->
        <button id="confirmButton" type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
      </div>
    </div>
  </div>

  <hr>
  
  
  <div class="row">
      <table id="mytable" class="nowrap table table-striped table-bordered"  width='100%'> 
        <thead class="thead-light">
         <tr>
            <th>No.</th>
            <th>BARCODE</th>
            <th>RECNO</th>
            <th>ชื่อสินค้า</th>
            <th>ขอเบิก</th>
            <th>ยอดเบิก</th>
            <th>หน่วย</th>
            <th>ผ่าน</th>
            <th>ลบ</th>
          </tr>
        </thead>
        <tbody>
          <!-- สร้างเนื้อตารางด้วย JavaScript -->
        </tbody>
      </table>
    </div>
</div>
</form>



    
    <hr>
    <?php include("0_footer.php"); ?>
  </body>


  <?php 
  include("0_footerjs.php");
   ?>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->
<script>
var selected_REQTYPE
$("form").submit(function(event){
  event.preventDefault();

  selected_REQTYPE = $("input[name='GET_TYPE']:checked").val();
  if (counter === 0) {
      return false;
    } else {
      sendData();
      jsonDatatable = JSON.stringify(tableData);
      checkAllPassed(checkdata);
      // console.log(checkdata);
      if (!checkAllPassed(checkdata)) {
        Swal.fire(
          'มีข้อมูลผิดพลาด',
          'โปรดตรวจสอบข้อมูเบิก',
          'error'
        );
        return false;
      }
      AlertSave();
    }
  });

$(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });





   var dtable = $('#mytable').DataTable({
        "paging": false,
        "info": false,
        "searching": false,
        scrollX: true,
        rowCallback: function(row, data)
        {
        },
      });

    $('#date').val(moment(new Date()).format('DD/MM/YYYY'));

    $(function (){
      $("#datepicker").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true, 
        autoclose: true
        // toggleActive: true
      });
    });

    $('#productRecno').prop('disabled', true);
    $('#productName').prop('disabled', true);
   var jsondoncno = "";
    $('#barcodeInput').on("keydown", function(event)
    {
    if (event.key === "Enter" || event.keyCode === 13) {
        var barcodeValue = $('#barcodeInput').val().trim();
        Check_BarCode(barcodeValue);
      }
    });
  
    $( "#barcodeok" ).on( "click", function() {
      var barcodeValue = $('#barcodeInput').val().trim();
      Check_BarCode(barcodeValue);
    } );

  var counter = 0;
  function TableAdd(TBARCODE, TRECNO, TCALLNAME, TLIST) {
  var duplicateRow = dtable.rows().eq(0).filter(function (rowIdx)
  {
    return dtable.cell(rowIdx, 1).data() === TBARCODE;
  });

  if (duplicateRow.length === 0) {
    counter++;
    var inputQUANORD = '<input type="number" min="0" value="1" name="QUANORD[]"  class="form-control" />';
    var inputQUANDLY = '<input type="number" min="0" value="1" name="QUANDLY[]"  class="form-control" />';

    var newRow = dtable.row.add([
      counter,
      TBARCODE,
      TRECNO,
      TCALLNAME,
      inputQUANORD,
      inputQUANDLY,
      TLIST,
      '',
      '<button class="btn btn-danger delete-row">ลบ</button>'
    ]).draw(false).node();
    
    $(newRow).attr('id', 'row' + counter);
  } else {
    // แจ้งเตือนว่ามีข้อมูลซ้ำกัน
    // alert('ข้อมูลในคอลัมน์ TBARCODE มีค่าซ้ำกับข้อมูลที่มีอยู่ในตารางแล้ว');
    Swal.fire(
          'ข้อมูลในคอลัมน์ BARCODE ',
          'มีค่าซ้ำกับข้อมูลที่มีอยู่ในตารางแล้ว',
          'error'
        )
  }
}



  $('#mytable').on('click', '.delete-row', function()
    {
      counter--;
      dtable.row($(this).closest('tr')).remove().draw();
      dtable.column(0).nodes().each(function(cell, i) {
        var cellData = dtable.cell(cell).data();
        dtable.cell(cell).data(i + 1).draw();
      });
    });


  var tableData = [];
  var row = [];
  var checkdata = [];
  function sendData()
  {
      tableData = [];
      checkdata = [];
      $('#mytable tbody tr').each(function() {
        row = [];
        $(this).find('td').each(function(index) {
          if ($(this).find('select').length > 0)
          {
            var selectValue = $(this).find('select').val();
            row.push(selectValue);
          } else if ($(this).find('input').length > 0) {
            var inputValue = $(this).find('input').val();
            row.push(parseInt(inputValue));
          } else {
            row.push($(this).text());
          }
        });
        tableData.push(row);
      });
      console.log(tableData)
      // เพิ่มโค้ดเพื่อตรวจสอบและกำหนดสีเซลล์ "ผ่าน"
      $('#mytable tbody tr').each(function(){
          var excolumn = $(this).find('td:nth-child(4)');
          var requestColumn = $(this).find('td:nth-child(5)');
          var withdrawalColumn = $(this).find('td:nth-child(6)');
          var passedColumn = $(this).find('td:nth-child(8)');
          // เข้าถึงค่าใน input
          var requestValue = parseInt(requestColumn.find('input').val());
          var withdrawalValue = parseInt(withdrawalColumn.find('input').val());
          // มันเป็น String เลยเจอ ERROR
          if (requestValue < withdrawalValue)
          {
            passedColumn.removeClass().addClass('bg-danger').text('ไม่ผ่าน');
            checkdata.push(false);
          } else if (requestValue > withdrawalValue || requestValue === withdrawalValue) {
            passedColumn.removeClass().addClass('bg-success').text('ผ่าน');
            checkdata.push(true);
          }
        });
  }


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
          'คุณได้บันทึกการเบิก : '+jsondoncno,
          'success'
        )
        location.reload();
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


  function checkAllPassed(checkdata){
    var allPassed = checkdata.every(function(element) {
      return element === true;
    });
    console.log(allPassed);
    return allPassed
  }

  var jsonDatatable;
  function SaveData()
  {
    $.ajax({
        type: "POST",
        url: 'ajax_dinsert.php',
        data: {
          queryIdHD: 'InsertINVREQHD',
          queryIdDT: 'InsertINVREQDT',
          condition:'I',
          paramhd: { // อาร์เรย์ params ที่คุณต้องการส่ง
              RECNO:'',
              STATUS:'D',
              CORP:1,
              REQTYPE:selected_REQTYPE,
              IO:'O',
              DOCDATE:moment($('#date').val(), 'DD/MM/YYYY').format('MM/DD/YYYY'),
              DOCNO:jsondoncno,
            },
          paramdt: { // อาร์เรย์ params ที่คุณต้องการส่ง
              RECNO:'',
            },
            paramlist: {
              QUAN:$('#QUANDLY').val(),
            },
            DataJSON:jsonDatatable
        },
        dataSrc:'',
        success: function(response){
          // console.log(response)
        },
        error: function(xhr, status, error)
        {
          // console.error(error);
        }
      });
  }

  FucLastDocno()
  function FucLastDocno(){
        $.ajax({
        url: 'ajax_data.php',
        data: {
          queryId: 'lastdocnowithdrawstock',
          params: null,
          condition:'',
        },
        dataSrc:'',
        success: function(response)
        {
          console.log(response)
          var json_LastDocno = JSON.parse(response).data; 
          var lastDocno = json_LastDocno[0].DOCNO.split('/').pop(); // ดึงตัวเลขสุดท้ายออกมาจาก jsondoncno
          var incrementedDocno = parseInt(lastDocno) + 1; // เพิ่มค่าตัวเลขสุดท้ายขึ้นไปอีกหนึ่งหน่วย
          jsondoncno = json_LastDocno[0].DOCNO.replace(lastDocno, incrementedDocno); // สร้างค่าใหม่โดยแทนที่ตัวเลขสุดท้ายด้วยค่าที่เพิ่มแล้ว
          $('#docno').val(jsondoncno);

        },
        error: function(xhr, status, error)
        {
          console.error(error);
        }
      });
  }



  function Check_BarCode(selectdata)
    { 
        // event.preventDefault();
        $.ajax({
        url: 'ajax_data.php',
        data: {
          queryId: 'scanbarcode',
          params: {
            BARCODE:selectdata,
          },
          condition:'',
        },
        dataSrc:'',
        success: function(response)
        {
            // console.log(response)
          var databarcode = JSON.parse(response).data; 
          if (databarcode.length > 0) 
          {
            var productData = databarcode[0]; // ดึงข้อมูลชุดแรกจากอาร์เรย์
            $('#barcodeInput').val('')
            TableAdd(selectdata,productData.RECNO,productData.CALLNAME,productData.LISTUNIT)
            }
            else {
            $('#productName').val('');
            $('#barcodeInput').val('');
            }
            
        },
        error: function(xhr, status, error)
        {
          console.error(error);
        }
      });
    }

    var data_invent = [
    { "id": 0, "text": "---" ,"value":""},
    // { "id": 1, "text": "รหัสสินค้า 1" ,"value":"00000001"},
    // { "id": 2, "text": "ตัวเลือกที่ 2" ,"value":"00000002"},
    // { "id": 3, "text": "ตัวเลือกที่ 3" ,"value":"00000003"},
    // { "id": 4, "text": "ตัวเลือกที่ 4" ,"value":"00000004"},
    // { "id": 5, "text": "ตัวเลือกที่ 5" ,"value":"00000005"}
  ]

    // $('#searchInput').select2({
    //   data:data_invent,

    //    theme: 'bootstrap-5',
    // templateSelection: function(selected) {
    //         // if (selected.id !== '') {
    //         //     return selected.text + ' (OutPut: ' + selected.value + ')';
    //         // }
    //         return '';
    //     },
    //     templateResult: function(result)
    //     {
            
    //         if (!result.id) {
    //             return result.text;
    //         }
    //         var $result = $('<span></span>');
    //         $result.text(result.text + ' (Input: ' + result.value + ')');

    //         if (result.id == 0) {
    //           $result = '---';  
    //           return $result;
    //         }else{
    //           return $result;
    //         }

           
    //     },
    //     matcher: function(params, data) {
    //         if ($.trim(params.term) === '') {
    //             return data;
    //         }
    //         console.log(data)
    //         var inputText = params.term.toLowerCase().replace(/\s/g, '');
    //         var optionText = data.text.toLowerCase().replace(/\s/g, '');
    //         var optionValue = data.value.toLowerCase().replace(/\s/g, '');
    //         var optionValue = "";
    //         if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1) {
    //             return data;
    //         }
    //         return null;
    //     }
    // }).on('change', function() {
    //     var selectedValue = $(this).select2('data')[0].value;
    //     Check_BarCode(selectedValue)
    //     $(this).val('');
    //   });

 
</script>

</html>