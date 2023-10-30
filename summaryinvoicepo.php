<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
  <script src="assets/js/color-modes.js"></script>

  <?php
  session_start();
  if (!isset($_SESSION["RECNO"])) {
    header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
  }
  include("0_headcss.php");
  ?>
  <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      width: 100%;
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
      --bd-violet-bg: #712cf9;
      --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

      --bs-btn-font-weight: 600;
      --bs-btn-color: var(--bs-white);
      --bs-btn-bg: var(--bd-violet-bg);
      --bs-btn-border-color: var(--bd-violet-bg);
      --bs-btn-hover-color: var(--bs-white);
      --bs-btn-hover-bg: #6528e0;
      --bs-btn-hover-border-color: #6528e0;
      --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
      --bs-btn-active-color: var(--bs-btn-hover-color);
      --bs-btn-active-bg: #5a23c8;
      --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
      z-index: 1500;
    }

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
  <link href="dashboard.css" rel="stylesheet">
</head>

<body>
  <?php include("0_dbheader.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <!-- SIDE -->
      <?php include("0_sidebar.php"); ?>
      <!-- CONTENT -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">สรุปยอดผู้จำหน่าย</h1>
        </div>
        <form id="idForm" method="POST">
          <section>
            <div class="container-fluid">
              <h3>ค้นหา</h3>
              <div class="row pb-3">

                <!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                  <div class="input-group input-daterange">
                    <span class="input-group-text">เริ่มต้น</span>
                    <input type="text" class="form-control" id="datepickerbegin">
                    <span class="input-group-text">จนถึง</span>
                    <input type="text" class="form-control" id="datepickerend">
                  </div>
                </div> -->

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">

                <div class="row pb-3">
                  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="input-group input-daterange">
                      <span class="input-group-text">เริ่มต้น</span>
                      <input type="text" class="form-control" id="datepickerbegin">
                      <span class="input-group-text">จนถึง</span>
                      <input type="text" class="form-control" id="datepickerend">
                    </div>
                  </div>
                </div>

                  <div class="row pb-3">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                      <button id="refresh" type="button" class="btn btn-primary">ค้นหา</button>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                      <button id="refreshall" type="button" class="btn btn-primary">ค้นหาทั้งหมด</button>
                    </div>
                  </div>

                  <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #d6d6d6;">บริษัท</span>
                        <input type="text" class="form-control " id="dayid" readonly>
                  </div>
                  <h4><span id='dayid'></span> </h4>


                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                
                  <h4> ยอดซื้อประมาณการทั้งหมด </h4>
                  <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                      <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #d6d6d6;">ยอดรวมสุทธิทั้งหมด</span>
                        <input type="text" class="form-control  text-end" id="sumtotal" readonly>
                        <span class="input-group-text" style="background-color: #d6d6d6;">บาท</span>
                      </div>
                    </div>
                  </div>

                  <h4> ยอดซื้อประมาณการบริษัทเยอะที่สุด </h4>
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                      <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #d6d6d6;">บริษัท</span>
                        <input type="text" class="form-control " id="company" readonly>
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                      <div class="input-group mb-3">
                        <span class="input-group-text" style="background-color: #d6d6d6;">ยอดรวม</span>
                        <input type="text" class="form-control  text-end" id="sumcompany" readonly>
                        <span class="input-group-text" style="background-color: #d6d6d6;">บาท</span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>


              <div class="chartCard">
                <div class="chartBox">
                  <canvas id="myChart"></canvas>
                </div>
              </div>
              <hr>
              <h2>ใบเแจ้งหนี้</h2>
              <div class="row">
                <div class="col-12">
                  <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
                    <thead class="thead-light">
                      <tr>
                        <th>ลำดับ</th>
                        <!-- <th>ว.ด.ป.</th> -->
                        <!-- <th>INV. No.</th> -->
                        <th>Cus. Code</th>
                        <th>Customer</th>
                        <th>สุทธิเงินบาท</th>
                        <th>จำนวนใบแจ้งหนี้</th>

                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>

              <hr>


              <hr>


            </div>
          </section>
          <div class="loading" style="display: none;"></div>
        </form>

      </main>
    </div>
  </div>
</body>
<?php include("0_footerjs_piority.php"); ?>
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


    // var qid = 'PO_INVOICE_SUMMARY0'; //
    // var condotion_id = 'NULL'; //
    var qid = 'PO_INVOICE_SUMMARYDATEBE'; //
    var condotion_id = 'DATEBE'; //
    var datasave = '';

    // หาวันที่ 1 ของเดือนนี้
    var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
    var lastDayOfMonth = moment().endOf('month').format('DD/MM/YYYY');
    moment($('#datepickerbegin').val(firstDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
    moment($('#datepickerend').val(lastDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
    var databegin = moment().startOf('month').format('DD.MM.YYYY');
    var dateend = moment().endOf('month').format('DD.MM.YYYY');
    $('#dayid').val("ณ วันที่ " + firstDayOfMonth + " ถึง " + lastDayOfMonth)
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
      if (amount === '' || amount === null) {
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

    var tabledatahd = $('#table_datahd').DataTable({
      scrollX: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: 'CODE'
        },
        {
          data: 'NAME'
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return formatCurrency(data.NETAMT)
          }
        },
        {
          data: 'DOCNO',
        },
      ],
      columnDefs: [{
          className: 'dt-right',
          targets: [3, 4]
        },
        {
          type: 'th_date',
          targets: 1
        },
        {
          type: 'currency',
          targets: 3
        },
        {
          "visible": false,
          "targets": [0]
        },
        {
          "width": "5%",
          "targets": [1, 4]
        },
        {
          "width": "12%",
          "targets": [3]
        }

      ],
      order: [
        [3, 'desc'],
      ],
    });

    fecth_databased(databegin, dateend);
    async function fecth_databased(data_begin, date_end) {
      Param = [];
      Param.push({
        datebegin: data_begin,
        dateend: date_end
      })
      var formData = new FormData();
      try {
        // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
        const jsonResponse = await fetch('ajax/post_fb_select_qt.php', {
          method: 'POST',
          body: set_formdata('select'),
        });

        if (!jsonResponse.ok) {
          $('.loading').hide();
          throw new Error('Error sending data to server');
        }
        jsonPush = []
        const jsonDataHD = await jsonResponse.json();
        await allsum(jsonDataHD.datasql)
        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }

    var topCode = [];
    var chartdatabase;

    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      // Param.push({})
      console.log(qid)
      console.log(condotion_id)
      if (conditionsformdata == "select") {
        formData.append('queryIdHD', qid);
        formData.append('condition', condotion_id);
      } else {}
      formData.append('Param', JSON.stringify(Param));
      ////////////////
      return formData;
    }

    $('#idForm').on('submit', function(e) {
      e.preventDefault(); // ป้องกันการส่ง form ไปยังหน้าอื่น
      // ตรวจสอบว่าปุ่มที่ถูกคลิกคือ "save" หรือ "edit"
      let url = "";
      let status_sql = "";
      var clickedButtonName = e.originalEvent.submitter.name;
    });



    var Param;
    $('#refresh').click(function() {
      const result = checkdate(false);
      if (result.status) {
        $('.loading').show();
        $('#dayid').val("ณ วันที่ " + moment(result.databegin, 'DD.MM.YYYY').format('DD/MM/YYYY') + " ถึง " + moment(result.dateend, 'DD.MM.YYYY').format('DD/MM/YYYY'))
        qid = 'PO_INVOICE_SUMMARYDATEBE';
        condotion_id = 'DATEBE';
        fecth_databased(result.databegin, result.dateend);
      }
    });

    $('#refreshall').click(function() {
      const result = checkdate(true);
      $('.loading').show();
      $('#dayid').val("ข้อมูลทั้งหมด ณ ปัจจุบัน");
      qid = 'PO_INVOICE_SUMMARY0';
      condotion_id = 'NULL';
      fecth_databased(result.databegin, result.dateend);
    });

    const checkdate = (daystatus) => {
      const beginDateInput = $('#datepickerbegin').val();
      const endDateInput = $('#datepickerend').val();

      const beginDate = moment(beginDateInput, 'DD/MM/YYYY');
      const endDate = moment(endDateInput, 'DD/MM/YYYY');

      const result = {
        status: false,
        databegin: '',
        dateend: ''
      };
      if (!daystatus) {
        if (beginDateInput === '' || endDateInput === '') {
          Swal.fire(
            'มีการป้อนวันที่ผิดพลาด',
            'ไม่สามารถประมวลผลได้',
            'error'
          );
          return result;
        }

        if (endDate.isBefore(beginDate)) {
          Swal.fire(
            'มีการป้อนวันที่ผิดพลาด',
            'ไม่สามารถประมวลผลได้',
            'error'
          );
          return result;
        }
      }

      result.status = true;
      result.databegin = beginDate.format('DD.MM.YYYY');
      result.dateend = endDate.format('DD.MM.YYYY');
      return result;
    };

    var chartdatabase;


    var doccount;
    var json_alldata;

    function allsum(json_data) {
      doccount = 1;

      json_alldata = json_data.reduce(function(acc, item) {
        var existingItem = acc.find(function(element) {
          return element.CODE === item.CODE;
        });

        if (existingItem) {
          existingItem.NETAMT += parseFloat(item.NETAMT);
          if (item.DOCNO) {
            if (!existingItem.DOCNO) {
              existingItem.DOCNO = 1;
            } else {
              existingItem.DOCNO++;
            }
          }
        } else {
          var newItem = {
            CODE: item.CODE,
            DOCDATE: item.DOCDATE,
            NAME: item.NAME,
            EXCHGRATE: item.EXCHGRATE,
            NETAMT: parseFloat(item.NETAMT),
          };
          if (item.DOCNO) {
            newItem.DOCNO = 1;
          }
          acc.push(newItem);
        }

        return acc;
      }, []);

      sum_result = 0;
      json_alldata.forEach(item => {
        sum_result += item.NETAMT;
      });

      json_alldata.sort(function(a, b) {
        return b.NETAMT - a.NETAMT;
      });

      tabledatahd.clear().rows.add(json_alldata).draw();
      chartdatabase = json_alldata.slice(0, 10);
      const formattedResult = sum_result.toFixed(2);
      $('#sumtotal').val(formattedResult.replace(/\B(?=(\d{3})+(?!\d))/g, ','))
      let namemessage = "";
      let amtmessage = "";
      if (chartdatabase.length > 0) {
        namemessage = (chartdatabase[0].CODE).trim() + " : " + (chartdatabase[0].NAME).trim();
        amtmessage = ((chartdatabase[0].NETAMT).toFixed(2)).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      }
      $('#company').val(namemessage)
      $('#sumcompany').val(amtmessage)

      data.datasets[0].data = chartdatabase.map(function(item) {
        return item.NETAMT;
      });
      myChart.update();

    }

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

    ////////////////////////////////////////////////// CHART  //////////////////////////////////////////////////

    const data = {
      labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5', 'TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
      datasets: [{
        label: 'ยอดซื้อ TOP 10',
        data: Array(10).fill(null), // กำหนดข้อมูลเริ่มต้นให้เป็น null ในอาร์เรย์ขนาด 10 ตัว
        backgroundColor: [
          'rgba(0, 153, 51,0.2)',
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
                size: window.innerWidth <= 768 ? 14 : 16, // ขนาดตัวอักษรของหัวข้อแกน Y
                weight: 'bold' // ความหนาของตัวอักษรของหัวข้อแกน Y
              }
            },
            ticks: {
              font: {
                size: window.innerWidth <= 768 ? 12 : 14, // ขนาดตัวอักษรของตัวเลขบนแกน Y
                weight: 'normal' // ความหนาของตัวเลขบนแกน Y
              }
            }
          }
        },
        plugins: {
          title: {
            display: true,
            text: 'ยอดซื้อ TOP 10', // ข้อความหัวเรื่อง
            font: {
              size: 20, // ขนาดตัวอักษร
              weight: 'bold' // ความหนา
            }
          },

          tooltip: {
            titleFont: {
              size: window.innerWidth <= 768 ? 16 : 25,
            },
            bodyFont: {
              size: window.innerWidth <= 768 ? 14 : 20,
            },
            callbacks: {
              label: function(context) {
                let label = '';
                if (context.parsed.y !== null) {
                  if (context.datasetIndex === 0) {
                    label += chartdatabase[context.dataIndex].CODE + ':' + chartdatabase[context.dataIndex].NAME + ':' + formatCurrency(context.parsed.y);
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
    if (window.innerWidth <= 768) {
      // ถ้าความกว้างของหน้าจอน้อยกว่าหรือเท่ากับ 600px (สำหรับโทรศัพท์)
      $("#myChart").css("height", "400px");
    } else {
      // ถ้าความกว้างของหน้าจอมากกว่า 600px (สำหรับคอมพิวเตอร์ PC)
      $("#myChart").css("height", "800px");
    }

    $('#backhis').click(function() {
      window.location = 'main.php';
    });

    $('#detailhis').click(function() {
      window.location = 'datatable_invoice.php';
    });


    /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>



</html>