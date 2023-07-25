<!DOCTYPE html>
<html lang="en">

<head>
<?php include("0_headcss.php"); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
  <title>Modal with DataTable Example</title>
  
</head>
<style>
    .table-redx {
      background-color: red !important;
    }

    .colorfy {
      --bs-body-bg: blue !important;
    /* background: blue !important;
    color: white; */
  }
  /* .dataTables_scrollHeadInner{  width:100% !important; }
  .dataTables_scrollHeadInner table{  width:100% !important; } */

  .table-custom  {
    --bs-table-color: #000;
    /* --bs-table-bg: #cfe2ff; */
    --bs-table-bg:#98b7ef;
    --bs-table-border-color: #bacbe6;
    --bs-table-striped-bg: #c5d7f2;
    --bs-table-striped-color: #000;
    --bs-table-active-bg: #bacbe6;
    --bs-table-active-color: #000;
    --bs-table-hover-bg: #bfd1ec;
    --bs-table-hover-color: #000;
    color: var(--bs-table-color);
    border-color: var(--bs-table-border-color)
}


    /* .table td.colorfy {
    background: blue !important;
    color: white !important;
  } */
  

  </style>
  
<body>


<div class="selection">
<div class="container" >
  <!-- START -->
    <div class="row">
          <div class="col-12">
          <h1>Machine Data</h1>
          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle" width='100%'>
            <thead class="thead-light">
              <tr>
                <th>ลำดับ</th>
                <th>ดูข้อมูล</th>
                <th>ภาพประกอบ</th>
                <th>สถานะ</th>
                <th>รหัสอุปกรณ์</th>
                <th>ชื่ออุปกรณ์</th>
                <th>ประเภทอุปกรณ์</th>
                <!-- <th>นาที/สัปดาห์</th> -->
                <!-- <th>ต้นทุน / นาที (บาท)</th> -->
                <!-- <th>อัตราทุน (%)</th> -->
                <!-- <th>กะกลางวัน</th> -->
                <!-- <th>กะกลางคืน</th> -->
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          </div>
    </div>
    <hr>
    <div class="row">
      <div class="col">
        <h1>PM TIME</h1>
        <table id="table_pmtimehd" class="nowrap table table-striped table-bordered" width='100%'>
          <thead class="thead-light">
            <tr>
              <th>RECNO</th>
              <th>Show</th>
              <th>Machine</th>
              <th>Name</th>
              <th>No</th>
              <th>Interval</th>
              <th>Document Code</th>
              <th>Job</th>
              <th>Area</th>
              <th>Delay</th>
              <th>Remark</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
<!-- END -->

</div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade" id="pmtime" tabindex="-1" aria-labelledby="pmtimeLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pmtimeLabel">Modal Title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
          <h1>PM TIME รายละเอียด</h1>
          <div class="table-responsive">
            <table id="table_pmtimedt" class="nowrap table table-striped table-bordered" width='100%'>
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>CODE</th>
                  <th>STATUS</th>
                  <th>WARNING TIME</th>
                  <th>BEGIM TIME</th>
                  <th>END TIME</th>
                  <th>REMARK</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>UMC500-6M</td>
                  <th>CLOSE</th>
                  <td>10 / 01 /2023</td>
                  <td>10 / 01 /2023</td>
                  <td>12 / 01 /2023</td>
                  <th>หมายเหตุ</th>
                </tr>
              </tbody>
            </table>
           </div>
          </div>
          <hr>
         
          <div class="row">
          <h1>LIST TIME</h1>
          <div class="table-responsive">
            <table id="table_listtime" class="nowrap table table-striped table-bordered" width='100%'>
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>EML</th>
                  <th>STATUS</th>
                  <!-- <th>WARNING TIME</th> -->
                  <th>BEGIM TIME</th>
                  <th>END TIME</th>
                  <th>regerger</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>คุณ ทนโดด</td>
                  <th>CLOSE</th>
                  <!-- <td>10 / 01 /2023</td> -->
                  <td>10 / 01 /2023</td>
                  <td>12 / 01 /2023</td>
                  <th>เช็คคราบ</th>
                </tr>
              </tbody>
            </table>
          </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <?php
  //  include("0_dtcolumn.php");
   ?>
     <script src="js/dtcolumn.js" rel="preload" as="script"></script>
     <!-- <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script> -->
  <?php include("0_footerjs.php"); ?>

</body>

<script>

var selectedRow = null;
var selectedRecno = null;

    $(document).ready(function() {
      $('#example').DataTable();
    var encodedURL = encodeURIComponent('ajax_data.php');
    var data_array = [];
    var table = $('#table_datahd').DataTable({
      ajax: {
        url: encodedURL,
        data: function(d) {
          // d.queryId = 'machine'; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.queryId = 'machine'; // ส่งค่าเป็นพารามิเตอร์ queryId
          d.params = null;
          d.condition = 'F';
        },
        dataSrc: function(json) {
          console.log(json);
          console.log(json.data);
          return json.data;
        }
      },
      scrollX: true,
      // responsive: true,
      columns: dtcolumn['datamachine'],
      columnDefs: [
      {
        "visible": false,
        "targets": 0
      },
      { targets: [ 1,2 ], className: 'dt-center' }
    ],
      initComplete: function(settings, json) {
        $('.loading').hide();
        // console.log(json)
      },
      drawCallback: function(settings) 
      {
        var api = this.api();
        api.rows().every(function(rowIdx, tableLoop, rowLoop) {
          var data = this.data();
          var variableT = data.STATUS; // แทน yourVariable ด้วยชื่อตัวแปรที่คุณต้องการตรวจสอบ

          if (variableT === 'T') {
            var row = api.row(rowIdx).node();
            // $(row).addClass('table-secondary'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
          }
        });
      },
      rowCallback: function(row, data)
      {
        $(row).on('click', function()
        {
        // ทำสิ่งที่คุณต้องการเมื่อคลิกที่แถว
        console.log(data.RECNO);
        // $(row).addClass('table-secondary');
        if (selectedRow !== null) {
          $(selectedRow).removeClass('table-custom');
        }
        $(this).addClass('table-custom');
        selectedRow = this;
        });
      },
    });

    });

    

      $('#table_pmtimehd').DataTable({
        ajax: {
        url: 'json/example_array.json',
        dataSrc: function(json) {
          console.log(json);
          console.log(json.data);
          return json.data;
        }
        },
        scrollX: true,
        columns: dtcolumn['datamachinepmtime'],
        columnDefs: [{
        "visible": false,
        "targets": 0
        }],
      });

      var tablepimetime_dt =  $('#table_pmtimedt').DataTable({
        // scrollX: true,
      });

      $('#table_listtime').DataTable({
        // scrollX: true,
      });
    

    $('#table_pmtimehd').on('click', '.pmtime', function()
    {
    // $('#table_pmtimehd').DataTable().columns.adjust().draw();
    // let rowDataPmtime = $('#table_pmtimehd').DataTable().row($(this).closest('tr')).data();
    });

    $('#pmtime').on('show.bs.modal', function(event) {
      // console.log('SSS');
        // setTimeout(function() {
        //   $('#table_pmtimehd').DataTable().columns.adjust().draw();
        //     console.log('SSS');
        // }, 1);
    });

    $('#table_datahd').on('click', '.focusdatahd', function() {
    let rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
    console.log(rowData);
    $('html, body').animate({
        scrollTop: $('#table_pmtimehd').offset().top
      }, 100); // ค่าความเร็วในการเลื่อน (มิลลิวินาที)
    });

 


  </script>


</html>
