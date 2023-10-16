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
  <form id="idForm" method="POST">
    <section>
      <div class="container-fluid pt-3">

        <div class="row ">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
            <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
          </div>
        </div>

        <hr>
        <h3>ค้นหา</h3>
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

        <div class="row pb-1">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
            <button id="refresh" type="button" class="btn btn-primary">ค้นหา</button>
          </div>

          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
            <button id="refreshall" type="button" class="btn btn-primary">ค้นหาทั้งหมด</button>
          </div>
        </div>



        <span id="excelmessage"></span>

        <div class="row pb-3">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <button id="downloadExcel" type="button" class="btn btn-success">โหลด Excel <i class="fas fa-file-excel"></i></button>
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

        <hr>
        <div class="chartCard">
          <div class="chartBox">
            <canvas id="myChart"></canvas>
          </div>
        </div>

      </div>
    </section>
  </form>


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
    $('.loading').show();


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

    $('#dayid').text("ณ วันที่ " + firstDayOfMonth + " ถึง " + lastDayOfMonth)

    $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + firstDayOfMonth + " ถึง " + lastDayOfMonth)

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
        return '00/00/0000'; 
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
        },
        dataSrc: function(json) {
          tablejsondata = json.data;
          // totalsum(tablejsondata)
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
      $('#excelmessage').html("<h3>ข้อมูลโหลดทั้งหมด</h3>")
    });

    $('#refresh').click(function() {

      let beginDate = moment($('#datepickerbegin').val(), 'DD/MM/YYYY');
      let endDate = moment($('#datepickerend').val(), 'DD/MM/YYYY');
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
          $('#dayid').text("ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY'))
          $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY') + "</h3>")
        } else {
          // ถ้า endDate มากกว่า beginDate
          $('.loading').show();
          qid = 'QOUT_INVOICE_0'
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          table.ajax.reload(myCallback);
          $('#dayid').text("ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY'))
          $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY') + "</h3>")
        }
      } else {
        Swal.fire(
          'มีการป้อนวันที่ผิดพลาด',
          'ไม่สามารถประมวลผลได้',
          'error'
        )
      }
    });

    $("#downloadExcel").click(function() {
      let beginDate = moment($('#datepickerbegin').val(), 'DD/MM/YYYY');
      let endDate = moment($('#datepickerend').val(), 'DD/MM/YYYY');
      if ($('#datepickerbegin').val() !== '' && $('#datepickerend').val() !== '') {
        // console.log("ประมวลผลได้");
        if (endDate.isBefore(beginDate)) {
          Swal.fire(
            'มีการป้อนวันที่ผิดพลาด',
            'ไม่สามารถประมวลผลได้ กรุณากรอกวันที่ใหม่',
            'error'
          )
        } else if (endDate.isSame(beginDate)) {
          // ถ้า endDate เท่ากับ beginDate
          $('.loading').show();
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          download_excel(databegin, dateend)
          $('#dayid').text("ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY'))
        } else {
          // ถ้า endDate มากกว่า beginDate
          $('.loading').show();
          databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
          download_excel(databegin, dateend)
          $('#dayid').text("ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY'))
        }
      } else {
        Swal.fire(
          'มีการป้อนวันที่ผิดพลาด',
          'ไม่สามารถประมวลผลได้ กรุณากรอกวันที่ใหม่',
          'error'
        )
      }
    });

    const curcodeex = (amount) => {
      if (amount == "764") {
        return "TH"
      } else if (amount == "840") {
        return "US"
      } else {
        return 'TH'
      }
      return formattedCurCode;
    };


    async function download_excel(data_begin, date_end) {
      var Param = [];
      var formData = new FormData();
      Param.push({
        datebegin: data_begin,
        dateend: date_end
      })
      const mappedData = tablejsondata.map((item) => ({
        // recno: item.RECNO, //ลำดับที่
        docdate: formatDate(item.DOCDATE), //วันที่ที่ระบุในเอกสาร
        duedate: formatDate(item.DUEDATE), //วันที่ครบกำหนด  
        docno: item.DOCNO, //เลขที่ใบแจ้งหนี้
        orderno: item.ORDERNO, //ใบสั่งซื้อ
        detail: item.DETAIL, //รายการ
        quan: item.QUAN, //จำนวน
        unitamt: item.UNITAMT, //หน่วยละ
        totalamt: parseFloat(item.TOTALAMT), //ผลรวมเงินสุทธิ์
        curcode: curcodeex(item.CURCODE), //สกุลเงิน
        exchangeRate:item.EXCHGRATE, //อัตราแลกเปลี่ยน
        extotalamt: parseFloat(item.EXCHGRATE) * parseFloat(item.TOTALAMT) // ผลรวมเงินสุทธิ์บาท
      }));
      formData.append('queryIdHD', 'EXCEL_QOUT_INVOICE_SUMMARY');
      formData.append('Param', JSON.stringify(mappedData));
      formData.append('condition', 'DATEBE');
      try {
        // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
        // const jsonResponse = await fetch('ajax/process_dataeexcel.php', {
        //   method: 'POST',
        //   body: formData,
        // });

        // if (!jsonResponse.ok) {
        //   throw new Error('Error sending data to server');
        // }

        // const jsonData = await jsonResponse.json();
        // console.log(jsonData.datasql)
        ////////////////////
        formData.append('blobData', JSON.stringify(mappedData));


        const blobResponse = await fetch('export/excel_export.php', {
          method: 'POST',
          body: formData,
        });

        if (!blobResponse.ok) {
          throw new Error('Error sending data to server');
        }

        // ดาวน์โหลดข้อมูลเป็น Blob หรือทำอะไรกับ blobResponse ตามที่คุณต้องการ
        const blobData = await blobResponse.blob();

        const url = window.URL.createObjectURL(blobData);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = 'invoice' + '.xlsx'; // ตั้งชื่อไฟล์ที่จะดาวน์โหลด
        document.body.appendChild(a);
        a.click();

        window.URL.revokeObjectURL(url);
        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }
    var myCallback = function() {
      $('.loading').hide();
    };
    var categorizedData = {};
    // สร้างตัวแปร sum_result และกำหนดค่าเริ่มต้นเป็น 0
    var sum_result = 0;
    var datatop10 = [];
    var sum_result = 0;

    function allsum(array_table) {
      sum_result = 0;
      array_table.forEach(item => {
        // แปลงค่า TOTALAMT และ EXCHGRATE เป็นตัวเลข หรือใช้ 0 ถ้าเป็นค่าว่างหรือ null
        const totalAmt = parseFloat(item.TOTALAMT) || 0;
        const exchangeRate = parseFloat(item.EXCHGRATE) || 0;
        // คำนวณค่า TOTALAMT * EXCHGRATE
        const result = totalAmt * exchangeRate;
        // เพิ่มผลลัพธ์ลงใน sum_result
        sum_result += result;
        // แสดงผลลัพธ์

      });

      // แสดงผลรวมในคอนโซล
      const formattedResult = sum_result.toFixed(2);
      $('#sumtotal').val(formattedResult.replace(/\B(?=(\d{3})+(?!\d))/g, ','))



      var data_all = array_table
        .reduce(function(acc, item) {
          var existingItem = acc.find(function(element) {
            return element.CODE === item.CODE;
          });

          if (existingItem) {
            // หากมีข้อมูลใน acc ที่มี CODE เดียวกันแล้ว
            // ให้บวกค่า TOTALAMT เข้ากับข้อมูลที่มีอยู่แล้ว
            existingItem.TOTALAMT += parseFloat(item.TOTALAMT);
          } else {
            // หากยังไม่มีข้อมูลใน acc สำหรับ CODE นี้
            // ให้เพิ่มข้อมูลใหม่ลงใน acc
            acc.push({
              CODE: item.CODE,
              NAME: item.NAME,
              TOTALAMT: parseFloat(item.TOTALAMT)
            });
          }

          return acc;
        }, []);

      data_all.sort(function(a, b) {
        return b.TOTALAMT - a.TOTALAMT;
      });
      datatop10 = data_all.slice(0, 10);

      let namemessage = "";
      let amtmessage = "";
      if (datatop10.length > 0) {
        namemessage = (datatop10[0].CODE).trim() + " : " + (datatop10[0].NAME).trim();
        amtmessage = ((datatop10[0].TOTALAMT).toFixed(2)).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      }
      $('#company').val(namemessage)
      $('#sumcompany').val(amtmessage)
      data.datasets[0].data = datatop10.map(function(item) {
        return item.TOTALAMT;
      });
      myChart.update();
    }


    ////////////////////////////////////////////////// CHART  //////////////////////////////////////////////////

    const data = {
      labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5', 'TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
      datasets: [{
        label: 'ยอดขาย TOP 10',
        data: Array(10).fill(null), // กำหนดข้อมูลเริ่มต้นให้เป็น null ในอาร์เรย์ขนาด 10 ตัว
        backgroundColor: [
          'rgba(0, 153, 51,0.6)',
        ],
        borderColor: [
          'rgba(0, 153, 51,1)'
        ],
        borderWidth: 2
      }]
    };

    const config = {
      type: 'bar',
      data,
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'จำนวนการขาย',
              font: {
                size: window.innerWidth <= 600 ? 14 : 16, // ขนาดตัวอักษรของหัวข้อแกน Y
                weight: 'bold' // ความหนาของตัวอักษรของหัวข้อแกน Y
              }
            },
            ticks: {
              font: {
                size: window.innerWidth <= 600 ? 12 : 14, // ขนาดตัวอักษรของตัวเลขบนแกน Y
                weight: 'normal' // ความหนาของตัวเลขบนแกน Y
              }
            }
          }
        },
        plugins: {
          title: {
            display: true,
            text: 'ยอดขาย TOP 10', // ข้อความหัวเรื่อง
            font: {
              size: 20, // ขนาดตัวอักษร
              weight: 'bold' // ความหนา
            }
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                let label = '';
                if (context.parsed.y !== null) {
                  if (context.datasetIndex === 0) {
                    // console.log(datatop10[context.dataIndex].NAME)
                    label += datatop10[context.dataIndex].CODE + ":" + datatop10[context.dataIndex].NAME + ':' + ((context.parsed.y).toFixed(2)).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    // label += context.parsed.y;
                  }
                }
                return label;
              }
            }
          }
        },
      }
    };


    // render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );

    // $("#myChart").css("height", 800);
    if (window.innerWidth <= 600) {
      // ถ้าความกว้างของหน้าจอน้อยกว่าหรือเท่ากับ 600px (สำหรับโทรศัพท์)
      $("#myChart").css("height", "400px");
    } else {
      // ถ้าความกว้างของหน้าจอมากกว่า 600px (สำหรับคอมพิวเตอร์ PC)
      $("#myChart").css("height", "800px");
    }



    $('#backhis').click(function() {
      window.location = 'main.php';
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>

</html>