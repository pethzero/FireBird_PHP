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
  <!-- <link rel="preload" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
  <link rel="preload" href="css/fixedColumns.dataTables.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">


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
  <link href="layout/bs5/dashboard.css" rel="stylesheet">
</head>

<body>
  <?php include("0_dbheader.php"); ?>
  <div class="container-fluid">
    <div class="row">
      <!-- SIDE -->
      <?php include("0_sidebar.php"); ?>
      <!-- CONTENT -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

        <form id="idForm" method="POST">

          <section>

            <div class="row pt-2 mb-2">
              <div class="col-md-12">
                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                  <div class="col p-4 d-flex flex-column position-static">
                    <div>
                      <h3>รายงานใบสั่งผลิตที่ยังไม่เริ่มการผลิต<span id="headname"> 3 วัน</span></h3>
                    </div>
                    <div class="row">
                      <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                        <select class="form-select" id="peroid">
                          <option value="0">ทุกรายการ</option>
                          <option value="3" selected>3 วัน</option>
                          <option value="5">5 วัน</option>
                          <option value="7">7 วัน</option>
                          <option value="14">2 อาทิตย์</option>
                          <option value="30">1 เดือน</option>
                          <option value="60">2 เดือน</option>
                          <option value="90">3 เดือน</option>
                        </select>
                      </div>
                      <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                        <button class="btn btn-success" id="downloadExcel">download excel</button>
                      </div>
                    </div>
           

                    <hr>
                    <div class="chartCard">
                      <div class="chartBox">
                        <canvas id="myChart"></canvas>
                      </div>
                    </div>
                    <hr>
            
                    <h4> ยอดสั่งขายประมาณการบริษัทเยอะที่สุด </h4>
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

                    <h4> ยอดสั่งขายประมาณการทั้งหมด </h4>
                    <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="input-group mb-3">
                          <span class="input-group-text" style="background-color: #d6d6d6;">ยอดรวมสุทธิทั้งหมด</span>
                          <input type="text" class="form-control  text-end" id="sumtotal" readonly>
                          <span class="input-group-text" style="background-color: #d6d6d6;">บาท</span>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-12">
                        <table id="table_datahd" class="nowrap table table-striped table-bordered    align-middle " width='100%'>
                          <thead class="thead-light">
                            <tr>
                              <th>ลำดับ</th>
                              <th>เลขที่ใบสั่งผลิต</th>
                              <th>วันที่สั่งผลิต</th>
                              <th>กำหนดเสร็จ</th>
                              <!-- <th>ผลิตครั้งล่าสุด</th> -->
                              <th>วันที่ผ่านมา</th>
                              <!-- <th>กระบวนการ</th>
                                <th>เครื่องจักร</th> -->
                              <!-- <th>ผู้ผลิต</th> -->
                              <!-- <th>ดี</th>
                                <th>เสีย</th>
                                <th>คืน</th>
                                <th>ทดแทน</th>
                                <th>ยกเลิก</th> -->
                              <th>ลูกค้า</th>
                              <th>สินค้าผลิต</th>
                              <th>ยอดสั่งผลิต</th>
                              <th>ราคารวม</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>




          </section>
          <div class="loading" style="display: none;"></div>
        </form>

      </main>
    </div>
  </div>
</body>
<?php include("0_footerjs_piority.php"); ?>
<script src="js/systemdtcolum.js"></script>
<script src="js/dataTables.fixedColumns.min.js"></script>
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

    var qid = 'JOBDISCON'; //
    var condotion_id = 'DATEBE'; //
    var datasave = '';
    const firstDay = '30.12.1899';
    const currentDate = moment().format('DD.MM.YYYY');
    var headname = " 3 วัน";
    $("#peroid").change("select", function() {
      $('.loading').show();

      headname = $("select#peroid option:selected").text();
      
      if ($("#peroid").val() == '0') {
        // headname = "ทุกรายการ"
        fecth_databased(firstDay, currentDate);
      } else {
        headname =" "+headname
        const startDate = moment().subtract(parseInt($("#peroid").val()), 'days').format('DD.MM.YYYY');
        fecth_databased(startDate, currentDate);
      }
    });



    fecth_databased(moment().subtract(3, 'days').format('DD.MM.YYYY'), moment().format('DD.MM.YYYY'));


    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    var tabledatahd = $('#table_datahd').DataTable({
      // scrollCollapse: true,
      fixedColumns: true,
      scrollX: true,
      columns: [{
          data: null,
          render: function(data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: 'DOCNO',
        },
        {
          data: 'DOCDATE',
          render: function(data, type, row) {
            return formatDate(data);
          }
        },
        {
          data: 'COMPDATE',
          render: function(data, type, row) {
            return formatDate(data);
          }
        },
        {
          data: 'DAYLEFT',
        },

        {
          data: 'CUSTNAME',
        },
        {
          data: 'PRODNAME',
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return convertToIntegerFix(data.QUANORDER, 'none');
          }
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return formatCurrencyFix(data.TOTALAMT, 'thb')
          }
        },
      ],
      columnDefs: [{
          className: 'dt-right',
          targets: [4, 7, 8]
        }, {
          "visible": false,
          "targets": [0]
        },
        {
          type: 'currency',
          targets: 8
        },
      ],

      // order: [
      //   [3, 'desc'],
      // ],
    });




    var data_main;
    async function fecth_databased(data_begin, date_end) {
      Param = [];
      Param.push({
        // dateperiod: parseInt(fdata)
        datebegin: data_begin,
        dateend: date_end
      })
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
        data_main = jsonDataHD.datasql;
        // data_main = [];
        console.log(headname)
       $("#headname").text(headname)
        ProcessCalcula(data_main);
        tabledatahd.clear().rows.add(data_main).draw();

        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }
    var Param;

    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      if (conditionsformdata == "select") {
        formData.append('queryIdHD', qid);
        formData.append('condition', condotion_id);
      } else if (conditionsformdata == "excel") {
        formData.append('queryIdExcel', 'EXCEL_PRUDUCT_DISCON');
        formData.append('TureTotalAmt', exceltolal);
        formData.append('condition_footer', 'T');
        formData.append('blobData', JSON.stringify(excel_data));
      }
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

    $("#downloadExcel").click(function() {
      download_excel()
    });

    function ProcessCalcula(datacal) {

      json_alldata = datacal.reduce(function(acc, item) {
        var existingItem = acc.find(function(element) {
          return element.CODE === item.CODE;
        });
        let money = 0;
        if (item.TOTALAMT !== null) {
          money = item.TOTALAMT;
        }

        if (existingItem) {
          existingItem.TOTALAMT += parseFloat(money);
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
            NAME: item.CUSTNAME,
            TOTALAMT: parseFloat(money),
          };
          if (item.DOCNO) {
            newItem.DOCNO = 1;
          }
          acc.push(newItem);
        }

        return acc;
      }, []);
      // console.log(json_alldata)

      sum_result = 0;
      json_alldata.forEach(item => {
        sum_result += item.TOTALAMT;
      });

      json_alldata.sort(function(a, b) {
        return b.TOTALAMT - a.TOTALAMT;
      });



      chartdatabase = json_alldata.slice(0, 10);
      const formattedResult = sum_result.toFixed(2);
      $('#sumtotal').val(formattedResult.replace(/\B(?=(\d{3})+(?!\d))/g, ','))
      let namemessage = "";
      let amtmessage = "";
      if (chartdatabase.length > 0) {
        namemessage = (chartdatabase[0].CODE).trim() + " : " + (chartdatabase[0].NAME).trim();
        amtmessage = ((chartdatabase[0].TOTALAMT).toFixed(2)).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      }
      $('#company').val(namemessage)
      $('#sumcompany').val(amtmessage)

      data.datasets[0].data = chartdatabase.map(function(item) {
        return item.TOTALAMT;
      });
      myChart.update();
    }

    function ProcesssMatchData(datamap) {
      const mappedData = datamap.map((item) => {
        let money = 0;
        if (item.TOTALAMT !== null) {
          money = item.TOTALAMT;
        }

        return {
          DOCNO: item.DOCNO,
          DOCDATE:formatDate(item.DOCDATE),
          COMPDATE:formatDate(item.COMPDATE),
          DAYLEFT:item.DAYLEFT,
          CUSTNAME:item.CUSTNAME,
          PRODNAME:item.PRODNAME,
          QUANORDER:convertToIntegerFix(item.QUANORDER, 'none'),
          TOTALAMT:money,
        };
      });
      return mappedData;
    }

    var excel_data;
    var exceltolal;
    async function download_excel() {
      try {
        // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
        $('.loading').show();
        exceltolal =  $('#sumtotal').val();
        excel_data = ProcesssMatchData(data_main)
        const blobResponse = await fetch('export/excel_export.php', {
          method: 'POST',
          body: set_formdata('excel'),
        });

        if (!blobResponse.ok) {
          throw new Error('Error sending data to server');
          $('.loading').hide();
        }

        let namelike;
        namelike = 'ใบสั่งผลิตยังไม่เริ่ม_'+$("select#peroid option:selected").text().replace(/\s/g, '_');
        const blobData = await blobResponse.blob();
        const url = window.URL.createObjectURL(blobData);
        const a = document.createElement('a');
        a.style.display = 'none';
        a.href = url;
        a.download = namelike + '.xlsx'; // ตั้งชื่อไฟล์ที่จะดาวน์โหลด
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }

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
            display: false,
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
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // render init block
    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
    if (window.innerWidth <= 768) {
      // ถ้าความกว้างของหน้าจอน้อยกว่าหรือเท่ากับ 600px (สำหรับโทรศัพท์)
      $("#myChart").css("height", "300px");
    } else {
      $("#myChart").css("height", "620px");
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