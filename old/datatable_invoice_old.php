<!DOCTYPE html>
<html lang="en">

<head>

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


    // var qid = 'QOUT_INVOICE_0'; //QOUT_INVOICE_DATEBE
    // var condotion_id = 'NULL';  //DATEBE
    var qid = 'QOUT_INVOICE_DATEBE'; //
    var condotion_id = 'DATEBE'; //

    // var tablejsondata;
    var datasave = '';

    // หาวันที่ 1 ของเดือนนี้
    var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
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

    // var data_array = [];
    // var startingValue = 1;
    // var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');
    var tabledatahd = $('#table_datahd').DataTable({
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
            return formatCurrency((data.EXCHGRATE * data.TOTALAMT) * (1 + (data.VATRATE / 100)))
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
      // initComplete: function(settings, json) {
      // },
      // createdRow: function(row, data, dataIndex) {},
      // drawCallback: function(settings) {},
      // rowCallback: function(row, data) {},
    });

    var  jsonDataMerge;
    fecth_databased(databegin, dateend);
    async function fecth_databased(data_begin, date_end) {
      Param = [];
      Param.push({
        datebegin: data_begin,
        dateend: date_end
      })
      // console.log(Param)
      var formData = new FormData();
      try {
        // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
        const jsonResponse = await fetch('ajax/post_fb_select_qt.php', {
          method: 'POST',
          body: set_formdata('select'),
        });

        if (!jsonResponse.ok) {
          // $('.loading').hide();
          throw new Error('Error sending data to server');
        }

        const jsonDataHD = await jsonResponse.json();
        data1 = jsonDataHD;
        data2 = jsonDataHD;

        // const jsonDataMerge = data1.concat(data2); 
        jsonDataMerge = [...data1, ...data2];
        // const c = a1.concat(b2);
        console.log(jsonDataHD);
        console.log(jsonDataMerge);

        // await tabledatahd.clear().rows.add(jsonDataHD.datasql).draw();
        // await allsum(jsonDataHD.datasql)
        // await datachart(jsonDataHD.datasql);

        $('.loading').hide();
      } catch (error) {
        console.error(error);
      }
    }

    var topCode = [];
    var chartdatabase;

    // function datachart(data) {
    //   chartdatabase = data
    //     .map(function(item) {
    //       return {
    //         NAME: item.NAME,
    //         CODE: item.CODE,
    //         QUAN: item.QUAN,
    //       };
    //     })
    //     .sort(function(a, b) {
    //       return b.QUAN - a.QUAN;
    //     })
    //     .slice(0, 10)
    //   const dbase_dataset = chartdatabase.map(function(item) {
    //     return item.extotalamt;
    //   });
    //   // topCode = Object.keys(tophigh_QUAN);

    //   const topDataset = {
    //     label: 'ยอดขาย TOP 10',
    //     data: dbase_dataset,
    //     backgroundColor: 'rgba(0, 153, 51,0.6)',
    //     borderColor: 'rgba(0, 153, 51,1)',
    //     borderWidth: 1,
    //     fill: true
    //     // categoryPercentage: 1,
    //     // barPercentage: 0.8
    //   };
    //   myChart.data.datasets = [topDataset];
    //   // สร้างกราฟใหม่
    //   myChart.update();
    // }


    function set_formdata(conditionsformdata) {
      var formData = new FormData();
      // Param.push({})
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
        qid = 'QOUT_INVOICE_DATEBE';
        condotion_id = 'DATEBE';
        fecth_databased(result.databegin, result.dateend);
        $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + moment(result.databegin, 'DD/MM/YYYY').format('DD/MM/YYYY') + " ถึง " + moment(result.dateend, 'DD/MM/YYYY').format('DD/MM/YYYY') + "</h3>")
      }
    });

    $('#refreshall').click(function() {
      const result = checkdate(true);

      $('.loading').show();
      qid = 'QOUT_INVOICE_0';
      condotion_id = 'NULL';
      fecth_databased(result.databegin, result.dateend);
      $('#excelmessage').html("<h3>ข้อมูลทั้งหมด ณ ปัจจุบัน</h3>")

      // if (result.status) {
      //   $('.loading').show();
      //   qid = 'QOUT_INVOICE_0';
      //   condotion_id = 'NULL';
      //   fecth_databased(result.databegin, result.dateend);
      //   $('#excelmessage').html("<h3>ข้อมูลทั้งหมด ณ ปัจจุบัน</h3>")
      // }
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

    function netcal(total, exchgate, vat) {
      console.log(vat)
      if (vat == 0) {
        return total * exchgate;
      } else {
        return (total * exchgate) * (1 + (vat / 100));
      }
    }

    function allsum(array_table) {
      chartdatabase = array_table.map((item) => ({
        CODE: item.CODE,
        NAME: item.NAME,
        VATRATE: parseFloat(item.VATRATE) || 0,
        TOTALAMT: parseFloat(item.TOTALAMT) || 0,
        EXCHGRATE: parseFloat(item.EXCHGRATE) || 0,
        NETAMT: netcal(parseFloat(item.TOTALAMT) || 0, parseFloat(item.EXCHGRATE) || 0, parseFloat(item.VATRATE) || 0)
      }));

      console.log(chartdatabase)
      sum_result = 0;
      chartdatabase.forEach(item => {
        sum_result += item.NETAMT;
      });

      console.log(sum_result)
      // // แสดงผลรวมในคอนโซล
      // const formattedResult = sum_result.toFixed(2);
      // $('#sumtotal').val(formattedResult.replace(/\B(?=(\d{3})+(?!\d))/g, ','))

      // let chart_alldata = array_table.reduce(function(acc, item) {
      //   var existingItem = acc.find(function(element) {
      //     return element.CODE === item.CODE;
      //   });

      //   if (existingItem) {
      //     existingItem.TOTALAMT += parseFloat(item.TOTALAMT);
      //     if (item.VATRATE > 0) {
      //       existingItem.TOTALAMT *= 1+(parseFloat(item.VATRATE)/100);
      //     }
      //   } else {
      //     let totalAmt = parseFloat(item.TOTALAMT);
      //     if (item.VATRATE > 0) {
      //       totalAmt *=  1+(parseFloat(item.VATRATE)/100);
      //     }
      //     console.log(totalAmt)
      //     acc.push({
      //       CODE: item.CODE,
      //       NAME: item.NAME,
      //       TOTALAMT: totalAmt
      //     });
      //   }

      //   return acc;
      // }, []);


      // chart_alldata.sort(function(a, b) {
      //   return b.TOTALAMT - a.TOTALAMT;
      // });

      // chartdatabase = chart_alldata.slice(0, 10);

      // let namemessage = "";
      // let amtmessage = "";
      // if (chartdatabase.length > 0) {
      //   namemessage = (chartdatabase[0].CODE).trim() + " : " + (chartdatabase[0].NAME).trim();
      //   amtmessage = ((chartdatabase[0].TOTALAMT).toFixed(2)).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      // }
      // $('#company').val(namemessage)
      // $('#sumcompany').val(amtmessage)
      // data.datasets[0].data = chartdatabase.map(function(item) {
      //   return item.TOTALAMT;
      // });
      // myChart.update();
    }


    $("#downloadExcel").click(function() {
      // let beginDate = moment($('#datepickerbegin').val(), 'DD/MM/YYYY');
      // let endDate = moment($('#datepickerend').val(), 'DD/MM/YYYY');
      // if ($('#datepickerbegin').val() !== '' && $('#datepickerend').val() !== '') {
      //   // console.log("ประมวลผลได้");
      //   if (endDate.isBefore(beginDate)) {
      //     Swal.fire(
      //       'มีการป้อนวันที่ผิดพลาด',
      //       'ไม่สามารถประมวลผลได้ กรุณากรอกวันที่ใหม่',
      //       'error'
      //     )
      //   } else if (endDate.isSame(beginDate)) {
      //     // ถ้า endDate เท่ากับ beginDate
      //     $('.loading').show();
      //     databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
      //     dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
      //     download_excel(databegin, dateend)
      //     $('#dayid').text("ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY'))
      //   } else {
      //     // ถ้า endDate มากกว่า beginDate
      //     $('.loading').show();
      //     databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
      //     dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
      //     download_excel(databegin, dateend)
      //     $('#dayid').text("ณ วันที่ " + beginDate.format('DD/MM/YYYY') + " ถึง " + endDate.format('DD/MM/YYYY'))
      //   }
      // } else {
      //   Swal.fire(
      //     'มีการป้อนวันที่ผิดพลาด',
      //     'ไม่สามารถประมวลผลได้ กรุณากรอกวันที่ใหม่',
      //     'error'
      //   )
      // }
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
            text: 'ยอดขาย TOP 10', // ข้อความหัวเรื่อง
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
    /////////////////////////////////////////////////////////////////////////////////////////////////////////


  });
</script>

</html>