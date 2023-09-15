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
  // $csrfToken = bin2hex(random_bytes(32)); // สร้าง token สุ่ม
  // $_SESSION['csrf_token'] = $csrfToken;
  // $_SESSION['csrf_token'] = keyse();
  ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
  <?php
  include("0_header.php");
  // include("0_breadcrumb.php");
  ?>
  <link rel="stylesheet" href="css/mycustomize.css">
  <style>
    .c_activity {
      width: 100px;
    }

    .h_textarea {
      height: 110px;
    }

    textarea {
      overflow-y: scroll;
    }

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

  <section>
    <div class="container-fluid pt-3">

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>


      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="input-group input-daterange">
            <span class="input-group-text">เริ่มต้น</span>
            <input type="text" class="form-control" id="datepickerbegin">
            <span class="input-group-text">จนถึง</span>
            <input type="text" class="form-control" id="datepickerend">
          </div>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refresh" type="button" class="btn btn-primary">ค้นหา</button>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id="refreshall" type="button" class="btn btn-primary">ค้นหาทั้งหมด</button>
        </div>
      </div>



      <h2>สมุดรายวันขาย</h2>

      <hr>
      <h2>ใบเแจ้งหนี้</h2>
      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ว.ด.ป.</th>
                <th>INV. No.</th>
                <th>Cus. Code</th>
                <th>Customer</th>
                <th>ใบสั่งซื้อ</th>
                <th>รายการ</th>
                <th>จำนวนชิ้น</th>
                <th>ราคาต่อชิ้น</th>
                <th>ราคารวม</th>
                <th>สกุล</th>
                <th>อัตราแลก</th>
                <th>สุทธิเงินบาท</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>

      <hr>
      <h4><span id='dayid'></span> </h4>
      <h4> ยอดขายประมาณการทั้งหมด </h4>
      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="input-group mb-3">
            <span class="input-group-text" style="background-color: #d6d6d6;">ยอดรวมสุทธิทั้งหมด</span>
            <input type="text" class="form-control  text-end" id="sumtotal" readonly>
            <span class="input-group-text" style="background-color: #d6d6d6;">บาท</span>
          </div>
        </div>
      </div>

      <h4> ยอดขายประมาณการบริษัทเยอะที่สุด </h4>
      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="input-group mb-3">
            <span class="input-group-text" style="background-color: #d6d6d6;">บริษัท</span>
            <input type="text" class="form-control " id="company" readonly>
          </div>
        </div>

        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
          <div class="input-group mb-3">
            <span class="input-group-text" style="background-color: #d6d6d6;">ยอดรวม</span>
            <input type="text" class="form-control  text-end" id="sumcompany" readonly>
            <span class="input-group-text" style="background-color: #d6d6d6;">บาท</span>
          </div>
        </div>
      </div>

      <!-- <div class="chartCard">
        <div class="chartBox">
          <canvas id="myChart"></canvas>
        </div>
      </div> -->

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
  <form id="idForm" method="POST">

  </form>
  <div class="loading" style="display: none;"></div>

</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
<?php include("0_footerjs.php"); ?>
<!-- <script src="js/dtcolumn.js"></script> -->

<script>
  $(document).ready(function() {

    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });

    var recno = null;
    var qid = 'QOUT_INVOICE_0';
    // var qid = null;
    var startd = null;

    var tablejsondata;
    var selectedRow = null;

    var selectedRecno = null;
    var datasave = '';


    var encodedURL_Select = encodeURIComponent('ajax_select_sql_firdbird.php');

    // หาวันที่ 1 ของเดือนนี้
    var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
    // หาวันสุดท้ายของเดือนนี้
    var lastDayOfMonth = moment().endOf('month').format('DD/MM/YYYY');

    moment($('#datepickerbegin').val(firstDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
    moment($('#datepickerend').val(lastDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')

    var databegin = moment().startOf('month').format('DD.MM.YYYY');
    var dateend = moment().endOf('month').format('DD.MM.YYYY');

   $('#dayid').text( "ณ วันที่ " + firstDayOfMonth + " ถึง " + lastDayOfMonth )
   
    $("#datepickerbegin").datepicker({
      format: "dd/mm/yyyy",
      todayHighlight: true,
      autoclose: true,
      clearBtn: true
    });

    $("#datepickerend").datepicker({
      format: "dd/mm/yyyy",
      todayHighlight: true,
      autoclose: true,
      clearBtn: true
    });



    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    // var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');


    const formatDate = (data) => {
      if (!data || data === '0000-00-00') {
        return '00/00/0000'; // ถ้าค่าว่างหรือไม่ถูกต้อง ส่งค่าว่างกลับไป
      }

      const dateObj = new Date(data);
      const day = dateObj.getDate();
      const month = dateObj.getMonth() + 1;
      const year = dateObj.getFullYear();
      // const formattedDate = `${(day < 10 ? '0' + day : day)}.${(month < 10 ? '0' + month : month)}.${year}`;
      const formattedDate = `${(day < 10 ? '0' + day : day)}/${(month < 10 ? '0' + month : month)}/${year}`;
      return formattedDate;
    };

    const formatValue = (amount) => {
      if (amount === '') {
        return '';
      }
      let formattedAmount = parseFloat(amount).toFixed(2);
      formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return formattedAmount;
    };


    const formatCurrency = (amount) => {
      if (amount === '') {
        return '';
      }
      let formattedAmount = parseFloat(amount).toFixed(2);
      formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      formattedAmount += '฿';
      return formattedAmount;
    };

    const formatDec = (amount) => {
      if (amount === '') {
        return '';
      }
      let formattedDec = parseFloat(amount).toFixed(2);
      return formattedDec;
    };

    var data_array = [];
    var startingValue = 1;
    var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      ajax: {
        url: encodedURL,
        data: function(d) {
          d.queryId = qid; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.params = {
            ABEGIN: databegin,
            AEND: dateend
          };
          d.condition = 'mix';
          // d.sqlprotect = encodeData;
        },
        dataSrc: function(json) {
          tablejsondata = json.data;
          totalsum(tablejsondata)
          allsum(tablejsondata)
          return json.data;
        }
      },
      scrollX: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: 'DOCDATE',
          render: formatDate
        },
        {
          data: 'DOCNO'
        },
        {
          data: 'CODE'
        },
        {
          data: 'NAME'
        },
        {
          data: 'ORDERNO'
        },
        {
          data: 'DETAIL'
        },
        // { data: 'QUAN'},
        {
          data: 'QUAN',
          render: function(data, type, row, meta) {
            return formatDec(data);
          }
        },
        {
          data: 'UNITAMT',
          render: formatValue
        },
        {
          data: 'TOTALAMT',
          render: formatValue
        },
        {
          data: 'CURCODE',
          render: function(data, type, row, meta) {
            if (data == "764") {
              return "TH"
            } else if (data == "840") {
              return "US"
            } else {
              return 'TH'
            }
          }
        },
        {
          data: 'EXCHGRATE'
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return formatCurrency(data.EXCHGRATE * data.TOTALAMT)
          }
        },
      ],
      columnDefs: [{
          className: 'dt-right',
          targets: [8, 9, 11, 12]
        },
        {
          type: 'th_date',
          targets: 2
        },
        {
          type: 'currency',
          targets: 12
        },
        {
          "visible": false,
          "targets": [0]
        }
      ],
      order: [
        [2, 'desc'],
      ],
      // dom: 'frtip',
      initComplete: function(settings, json) {
        $('.loading').hide();
      },
      createdRow: function(row, data, dataIndex) {},
      drawCallback: function(settings) {},
      rowCallback: function(row, data) {},
    });


    $('#refreshall').click(function() {
      $('.loading').show();
      qid = 'QOUT_INVOICE_ALL'
      databegin = '00.00.0000'
      dateend = '00.000.0000'
      table.ajax.reload(myCallback);

      $('#dayid').text("ทั้งหมดตั้งแต่เริ่ม")
    });

    $('#refresh').click(function() {

      let beginDate = moment($('#datepickerbegin').val(), 'DD/MM/YYYY');
      let endDate = moment($('#datepickerend').val(), 'DD/MM/YYYY');
      // console.log(beginDate)
      // console.log(endDate)


      if ($('#datepickerbegin').val() !== '' && $('#datepickerend').val() !== '') {
        // console.log("ประมวลผลได้");
        if (endDate.isBefore(beginDate)) {
          Swal.fire(
            'มีการป้อนวันที่ผิดพลาด',
            'ไม่สามารถประมวลผลได้',
            'error'
          )
        } else if (endDate.isSame(beginDate)) {
          // ถ้า endDate เท่ากับ beginDate
          $('.loading').show();
          qid = 'QOUT_INVOICE_0'
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          table.ajax.reload(myCallback);
          $('#dayid').text( "ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY') )
        } else {
          // ถ้า endDate มากกว่า beginDate
          $('.loading').show();
          qid = 'QOUT_INVOICE_0'
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          table.ajax.reload(myCallback);
          $('#dayid').text( "ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY') )
        }
      } else {
        Swal.fire(
          'มีการป้อนวันที่ผิดพลาด',
          'ไม่สามารถประมวลผลได้',
          'error'
        )
      }
    });

    var myCallback = function() {
      $('.loading').hide();
    };


    var categorizedData = {};

    // สร้างตัวแปร sum_result และกำหนดค่าเริ่มต้นเป็น 0
    var sum_result = 0;

    function totalsum(data_total) {
      // วนลูปผ่านแต่ละอิลิเมนต์และคำนวณค่า TOTALAMT * EXCHGRATE
      sum_result = 0;

      data_total.forEach(item => {
        // แปลงค่า TOTALAMT และ EXCHGRATE เป็นตัวเลข หรือใช้ 0 ถ้าเป็นค่าว่างหรือ null
        const totalAmt = parseFloat(item.TOTALAMT) || 0;
        const exchangeRate = parseFloat(item.EXCHGRATE) || 0;

        // คำนวณค่า TOTALAMT * EXCHGRATE
        const result = totalAmt * exchangeRate;
        // เพิ่มผลลัพธ์ลงใน sum_result
        sum_result += result;

        // แสดงผลลัพธ์
        // console.log(`รหัส: ${item.CODE}, ผลลัพธ์: ${result}`);
      });

      // แสดงผลรวมในคอนโซล
      const formattedResult = sum_result.toFixed(2);
      $('#sumtotal').val(formattedResult.replace(/\B(?=(\d{3})+(?!\d))/g, ','))
    }

    function allsum(data) {
      // สร้างตัวแปรสำหรับเก็บ CODE ที่มีค่า TOTALAMT * EXCHGRATE สูงที่สุด
      let maxCode = "";
      let maxTotalAmtTimesExchangeRate = -Infinity;
      let NameCompany = "";
      let maxSumCompanyName = "";
      // สร้างออบเจ็กต์เพื่อเก็บผลรวมของ CODE แต่ละรายการ
      const codeSumMap = {};

      // วนลูปผ่านข้อมูลในอาร์เรย์
      data.forEach(item => {
        const code = item.CODE;
        const totalAmt = parseFloat(item.TOTALAMT) || 0;
        const exchangeRate = parseFloat(item.EXCHGRATE) || 0;
        const company = item.NAME || "";

        const result = totalAmt * exchangeRate;

        // อัพเดทผลรวมของ CODE
        codeSumMap[code] = (codeSumMap[code] || 0) + result;
        // console.log(codeSumMap)
        // เช็คว่าค่า TOTALAMT * EXCHGRATE สูงที่สุดหรือไม่
        if (result > maxTotalAmtTimesExchangeRate) {
          maxTotalAmtTimesExchangeRate = result;
          maxCode = code;
          NameCompany = company;
        }
      });

      // console.log(codeSumMap)
      // หา CODE ที่มีผลรวมมากที่สุด
      let maxSumCode = "";
      let maxSumValue = -Infinity;
      for (const code in codeSumMap) {
        // console.log(codeSumMap)
        if (codeSumMap[code] > maxSumValue) {
          maxSumValue = codeSumMap[code];
          maxSumCode = code;
          maxSumCompanyName = data.find(item => item.CODE === code)?.NAME || "";

          // console.log(maxSumValue)
          // console.log(maxSumCode)
        }
      }


      let namemessage = "";
      let formattedResultTotalCompany = maxSumValue.toFixed(2);
      namemessage = maxSumCode + " : " + maxSumCompanyName;
      if (formattedResultTotalCompany === "-Infinity") {
        formattedResultTotalCompany = "0.00"; // เปลี่ยนเป็น 0.00 หรือค่าที่คุณต้องการ
        namemessage = "";
      }

      $('#company').val(namemessage)
      $('#sumcompany').val(formattedResultTotalCompany.replace(/\B(?=(\d{3})+(?!\d))/g, ','))

    }

    // function FuccategorizedData(dataArray)
    //   {
    //     // var data = dataArray;
    //     categorizedData = {};
    //     dataArray.forEach(item => 
    //     {
    //       // const year = item["Year"];
    //       // const month = item["Mouth"];
    //       // const totalAmt = item["TOTALAMT"];

    //       // if (!categorizedData[year])
    //       // {
    //       //   categorizedData[year] = [];
    //       // }

    //       // categorizedData[year].push({ month, totalAmt });
    //     });
    //     console.log(categorizedData);
    //   }    ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
    //  $('html, body').animate({
    //       scrollTop: $('#dataoffset').offset().top
    //   }, 100); // ค่าความเร็วในการเลื่อน (มิลลิวินาที)

    $('#backhis').click(function() {
      window.location = 'main.php';
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>

</html>