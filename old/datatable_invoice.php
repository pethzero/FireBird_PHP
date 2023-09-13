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

  <?php
  // include("connect_sql.php");
  ?>

  <section>
    <div id="app" class="container-fluid pt-3">

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>


      <div class="input-group input-daterange">
        <input type="text" class="form-control" id="datepickerbegin" value="13/09/2023">
        <span class="input-group-text">to</span>
        <input type="text" class="form-control" id="datepickerend" value="13/09/2023">
      </div>

      <button id="refresh">สุ่มข้อมูล</button>


      <h2>ใบเสนอราคา</h2>

      <hr>
      <h2>อันดับลูกค้า ใบเสนอราคา</h2>
      <div class="row">
        <div class="col-12">
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
            <tr>
              <th>#</th>
              <th>DOCDATE</th>
              <th>DOCNO</th>
              <th>ORDERHD</th>
            </tr>
            </thead>
            <tbody>
              <tr v-for="(row, index) in tableData" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ row.DOCDATE }}</td>
                <td>{{ row.DOCNO }}</td>
                <td>{{ row.ORDERHD }}</td>
              </tr>
            </tbody>
          </table>
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
  <form id="idForm" method="POST">

  </form>
  <div class="loading" style="display: none;"></div>

</body>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<?php include("0_footerjs.php"); ?>
<!-- <script src="js/dtcolumn.js"></script> -->

<script>
  new Vue({
    el: '#app',
    data: {
      databegin: null,
      dateend: null,
      recno: null,
      qid: 'QOUT_SUM_0',
      startd: null,
      tableData: [],
    },
    methods: {
      fetchData() 
      {
        const encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');
        const params = {
          queryId: this.qid,
          ABEGIN: this.databegin,
          AEND: this.dateend,
          condition: '',
        };

        // ดำเนินการเรียกใช้งาน AJAX หรือ Fetch API ในการดึงข้อมูล
        // และกำหนดค่า this.tableData เมื่อได้รับข้อมูล
        // เช่น axios, fetch, หรือ jQuery.ajax
        // หรือใช้ Vue Resource หากคุณมีการติดตั้งมัน

        // ตัวอย่างโดยใช้ axios:
        axios.get(encodedURL, {
            params
          })
          .then(response => {
            this.tableData = response.data.data;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
    mounted() {
      this.fetchData(); // เรียกใช้งาน fetchData เมื่อ Vue instance ถูกติดตั้ง
    },
  });

  // new Vue({
  //   el: '#app',
  //   data: {
  //     people: [],
  //     newPerson: {
  //       name: ''
  //     },
  //     editingPersonId: null, // Track the ID of the person being edited
  //     editedPersonName: '' // Track the edited name
  //   },
  //   created() {


  //   },
  //   mounted() {

  //   },
  //   methods: {

  //   }
  // });
  // $(document).ready(function() {

  //   /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
  //   $(window).keydown(function(event) {
  //     if (event.keyCode == 13 && !$(event.target).is('textarea')) {
  //       event.preventDefault();
  //       return false;
  //     }
  //   });

  //   var recno = null;
  //   // var qid = 'QOUT_SUM_0';
  //   var qid = null;
  //   var startd = null;

  //   var tablejsondata;
  //   var selectedRow = null;

  //   var selectedRecno = null;
  //   var datasave = '';

  //   var databegin = null;
  //   var dateend = null;
  //   // var encodedURL_Select = encodeURIComponent('ajax_select_sql_mysql.php');
  //   var encodedURL_Select = encodeURIComponent('ajax_select_sql_firdbird.php');

  //   //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
  //   // var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');

  //   function secertkey() {
  //     return encodeData;
  //   }

  //   var data_array = [];
  //   var startingValue = 1;
  //   var encodedURL = encodeURIComponent('ajax_select_sql_firdbird.php');
  //   var data_array = [];
  //   var table = $('#table_datahd').DataTable({
  //     ajax: {
  //       url: encodedURL,
  //       data: function(d) {
  //         d.queryId = qid; // ส่งค่าเป็นพารามิเตอร์ queryId
  //         d.params = {
  //           ABEGIN: databegin,
  //           AEND: dateend
  //         };
  //         d.condition = '';
  //         // d.sqlprotect = encodeData;
  //       },
  //       dataSrc: function(json) {
  //         tablejsondata = json.data;
  //         // console.log(tablejsondata)
  //         return json.data;
  //       }
  //     },
  //     scrollX: true,
  //     columns: [{
  //         data: null,
  //         render: function(data, type, row, meta) {
  //           return meta.row + 1;
  //         }
  //       },
  //       {
  //         data: 'DOCDATE',
  //         render: function(data, type, row) {
  //           return data
  //         }
  //       },
  //       {
  //         data: 'DOCNO',
  //         render: function(data, type, row) {
  //           return data
  //         }
  //       },
  //       {
  //         data: 'ORDERHD',
  //         render: function(data, type, row) {
  //           return data
  //         }
  //       },
  //     ],
  //     columnDefs: [{
  //         className: 'dt-right',
  //         targets: [2]
  //       },
  //       // {
  //       //   searchable: false,
  //       //   orderable: false,
  //       //   targets: 0
  //       // }
  //     ],
  //     order: [
  //       [3, 'desc'],
  //     ],
  //     dom: 'frtip',
  //     initComplete: function(settings, json) {
  //       // datachart(tablejsondata)
  //     },
  //     createdRow: function(row, data, dataIndex) {

  //     },
  //     drawCallback: function(settings) {

  //     },
  //     rowCallback: function(row, data) {

  //     },
  //   });


  //   $("#datepickerbegin").datepicker({
  //       format: "dd/mm/yyyy",
  //       todayHighlight: true,
  //       autoclose: true,
  //       clearBtn: true
  //     });

  //     $("#datepickerend").datepicker({
  //       format: "dd/mm/yyyy",
  //       todayHighlight: true,
  //       autoclose: true,
  //       clearBtn: true
  //     });

  //   // $('.input-daterange input').each(function() {
  //   //   $(this).datepicker('clearDates');
  //   // });

  //   $('#refresh').click(function() {
  //     // if (dateValue) {
  //     //   qid = 'DATESEL_ACTIVITYHD'
  //     // startd = moment($('#date').val(), 'DD/MM/YYYY').format('MM/DD/YYYY')
  //     // } else {
  //     //   qid = 'SEL_ACTIVITYHD';
  //     //   startd = null;
  //     // }
  //     qid = 'QOUT_SUM_0'
  //     table.ajax.reload();
  //   });
  //   ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
  //   //  $('html, body').animate({
  //   //       scrollTop: $('#dataoffset').offset().top
  //   //   }, 100); // ค่าความเร็วในการเลื่อน (มิลลิวินาที)

  //   $('#backhis').click(function() {
  //     window.location = 'main.php';
  //   });
  //   /////////////////////////////////////////////////////////////////////////////////////////////////////////


  // });
</script>

</html>