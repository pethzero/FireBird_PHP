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

    .button-container {
      display: flex;
      gap: 10px;
      /* ระยะห่างระหว่างปุ่ม */
    }

    div.dataTables_paginate {
      float: left;
      margin: 0;
    }

    .swal2-confirm,
    .swal2-cancel {
      text-align: right !important;
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
      <div class="loading" style="display: none;"></div>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <form id="idForm" method="POST">

          <div class="row mt-2">
            <ul class="nav nav-tabs " id="myTab" role="tablist">
              <li class="nav-item " role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#layout-tab-home" type="button" role="tab" aria-controls="home" aria-selected="true">หน้าหลัก</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tabdata-tab" data-bs-toggle="tab" data-bs-target="#tabdata" type="button" role="tab" aria-controls="tabdata" aria-selected="false">ข้อมูล</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="tabdetail-tab" data-bs-toggle="tab" data-bs-target="#tabdetail" type="button" role="tab" aria-controls="tabdetail" aria-selected="false">รายละเอียด</button>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="layout-tab-home" role="tabpanel" aria-labelledby="home-tab">
                <!-- START -->
                <div class="row mt-2" id="main_layout">
                  <div class="col-md-12">
                    <div class="row ">
                      <div class="col">
                        <section>

                          <div class="main_data">
                            <h2>สรุปใบวางบิล</h2>
                            <hr>

                            <div class="row pb-3">
                              <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <select class="form-select" id="slc_year">
                                </select>
                              </div>



                            </div>

                            <div class="row">
                              <div class="col-12">
                                <table id="table_datahd" class=" table table-striped table-bordered align-middle " width='100%'>
                                  <thead class="thead-light">
                                    <tr>
                                      <th>ลำดับ</th>
                                      <th width="6%">รหัส</th>
                                      <th width="6%">ชื่อเรียก</th>
                                      <th>ชื่อลูกค้า</th>
                                      <th>รายละเอียด</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>

                          </div>
                        </section>



                      </div>
                    </div>
                  </div>
                </div>
                <!-- END -->
              </div>
              <div class="tab-pane fade" id="tabdata" role="tabpanel" aria-labelledby="tabdata-tab">
                <div class="row mt-2">
                  <h2>ข้อมูลใบวางบิล</h2>
                  <hr>


                  <!-- <div class="input-group mb-3">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="selectDataRecord" id="DataRecord1" value="add_new" checked>
                      <label class="form-check-label" for="DataRecord1">เพิ่มข้อมูล</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="selectDataRecord" id="DataRecord2" value="edit">
                      <label class="form-check-label" for="DataRecord2">แก้ไขข้อมูล</label>
                    </div>
                  </div> -->
                  <div class="input-group mb-3">
                    <span class="input-group-text c_activity">ชื่อบริษัท:</span>
                    <!-- <input type="text" class="form-control" id="tbx_code" placeholder="ชื่อเล่น" maxlength="80"> -->
                    <select class="form-select" id="slc_cust">
                    </select>
                  </div>

                  <div class="input-group mb-3" style='display:none'>
                    <span class="input-group-text c_activity">รหัส:</span>
                    <input type="text" class="form-control inputreadonly" id="tbx_recno" placeholder="" maxlength="80" readonly>
                  </div>

                  <div class="input-group mb-3">
                    <span class="input-group-text c_activity">รหัส:</span>
                    <input type="text" class="form-control inputreadonly" id="tbx_code" placeholder="" maxlength="128" readonly>
                  </div>

                  <div class="input-group mb-3">
                    <span class="input-group-text c_activity">ปี:</span>
                    <select class="form-select" id="slc_year_create">
                    </select>
                  </div>


                  <div class="input-group mb-3">
                    <span class="input-group-text c_activity">รายละเอียด:</span>
                    <textarea class="form-control location-input" id="tbx_detail" maxlength="1500" rows="8"></textarea>
                  </div>



                  <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <button id='btn_add' type="button" class="btn btn-primary">บันทึกข้อมูล</button>
                  </div>

                </div>
              </div>
              <div class="tab-pane fade " id="tabdetail" role="tabpanel" aria-labelledby="tabdetail-tab">
                <div class="row mt-2">
                  <h2>รายละเอียดวางบิล</h2>
                  <hr>
                  <div class="col-12">
                    <table id="table_datadetail" class=" table table-striped table-bordered align-middle " width='100%'>
                      <thead class="thead-light">
                        <tr>
                          <th>ลำดับ</th>
                          <th width="6%">รหัส</th>
                          <th>ชื่อลูกค้า</th>
                          <th width="6%">ปี</th>
                          <th width="6%">ข้อมูล</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>


                <section>
                  <div class="modal fade" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="myModalLabel">ข้อมูลรายละเอียด<span id='story' class="badge"></span></h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                          <section>
                            <div class="container-fluid">
                              <div class="input-group mb-3">
                                <span class="input-group-text c_activity">รหัส:</span>
                                <input type="text" class="form-control inputreadonly" id="tbx_code_edit" placeholder="รหัส" readonly>
                              </div>

                              <div class="input-group mb-3">
                                <span class="input-group-text c_activity">ชื่อ:</span>
                                <input type="text" class="form-control inputreadonly" id="tbx_name_edit" placeholder="ชื่อ" readonly>
                              </div>

                              <div class="input-group mb-3">
                                <span class="input-group-text c_activity">ปี:</span>
                                <input type="text" class="form-control inputreadonly" id="tbx_year_edit" placeholder="ปี" readonly>
                              </div>


                              <div class="input-group mb-3">
                                <span class="input-group-text c_activity">รายละเอียด:</span>
                                <textarea class="form-control location-input" id="tbx_detail_edit" maxlength="1500" rows="8"></textarea>
                              </div>


                            </div>
                          </section>
                        </div>

                        <div class="modal-footer">
                          <button type="button" id="record_e" name='record_e' class="btn btn-primary">บันทึก</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </div>


          </div>


        </form>
      </main>
    </div>
  </div>
</body>
<?php include("0_footerjs.php"); ?>
<script src="js/systemdetail.js"></script>
<script src="js/system_components.js"></script>
<script src="js/system_format.js"></script>
<script>
  $(document).ready(function() {
    var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";
    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });
    ////////// TAB
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((el) => {
      el.addEventListener('shown.bs.tab', () => {
        DataTable.tables({
          visible: true,
          api: true
        }).columns.adjust();
      });
    });
    ///////////////////////////////////////////////////////////// DATA /////////////////////////////////////////////////////////////////
    var recno = null;
    var selectedRow = null;
    var selectedRecno = null;
    var datasave = '';
    var id_modify;

    var paramhd;
    var viewstatus = 'F';

    $(function() {
      if (userlevel == "F") {
        $("#newmodel").remove();
      }
    });
    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    // MAIN
    var mainTable = $('#table_datahd').DataTable({
      scrollX: true,
      columns: [{
          data: 'RECNO'
        },
        {
          data: 'CODE'
        },
        {
          data: 'SNAME'
        },
        {
          data: 'NAME'
        },
        {
          data: null,
          render: function(data, type, row) {
            var detailHTML = data['DETAIL'].replace(/\r?\n/g, "<br>");
            return detailHTML;
          }
        },
      ],
      columnDefs: [
        // {
        //   className: 'dt-center text-center align-middle',
        //   targets: [4]
        // },
        {
          "visible": false,
          "targets": 0
        },
        {
          "orderable": false,
          "targets": 1
        },
      ],
      // order: [
      //   [3, 'asc'],
      // ],
      dom: 'pfrtip',
      initComplete: function(settings, json) {},
      createdRow: function(row, data, dataIndex) {},
      drawCallback: function(settings) {},
      rowCallback: function(row, data) {
        // $(row).on('click', function() {
        //   if (selectedRow !== null) {
        //     $(selectedRow).removeClass('table-custom');
        //   }
        //   $(this).addClass('table-custom');
        //   selectedRow = this;

        //   if (selectedRecno !== data.ID) {
        //     // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
        //     selectedRecno = data.ID;
        //   }
        //   console.log('wow');
        // });
        // $(row).on('dblclick', function() {
        //   console.log('Double clicked!');
        //   if (selectedRow !== null) {
        //     $(selectedRow).removeClass('table-custom');
        //   }
        //   $(this).addClass('table-custom');
        //   selectedRow = this;

        //   if (selectedRecno !== data.ID) {
        //     // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
        //     selectedRecno = data.ID;
        //     console.log('Go Edit')
        //   }
        // });

      },
    });
    // DETAIL
    var detailTable = $('#table_datadetail').DataTable({
      scrollX: true,
      columns: [{
          data: 'recno'
        },
        {
          data: 'code'
        },
        {
          data: 'name'
        },
        {
          data: 'year'
        },
        {
          data: null,
          render: function(data, type, row, meta) {
            return ModelEditRecno(meta.row + 1, ''); // ใส่ลำดับของแถวเพิ่มเข้าไปในคอลัมน์
          }
        },
      ],
      columnDefs: [{
          className: 'dt-center text-center align-middle',
          targets: [4]
        },
        {
          "visible": false,
          "targets": 0
        },
        {
          "orderable": false,
          "targets": 1
        },
      ],
      dom: 'pfrtip',
      initComplete: function(settings, json) {},
      createdRow: function(row, data, dataIndex) {},
      drawCallback: function(settings) {},
      rowCallback: function(row, data) {

      },
    });
    ///////////////////////////////////////////////////// PROCESS NEW  ////////////////////////////////////////////////////////////////
    class DataFetcher {
      constructor() {}
      async AlertSave() {
        try {
          const result = await Swal.fire({
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
              cancelButton: 'cancel',
            },
          });

          if (result.isConfirmed) {
            return true;
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('ยกเลิก', 'ยังไม่มีการบันทึก', 'error');
            return false;
          }
        } catch (error) {
          console.error(error);
          return false;
        }
      }

      async ProcessAlert(Alert_title, Alert_text, Alert_icon) {
        try {
          Swal.fire(Alert_title, Alert_text, Alert_icon);
          return true;
        } catch (error) {
          console.error(error);
        }
      }

      async ProcessAlert_N(Alert_title, Alert_text, Alert_icon) {
        try {
          const result = await Swal.fire({
            title: Alert_title,
            text: Alert_text,
            icon: Alert_icon,
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6',
            customClass: {
              confirmButton: 'ok'
            },
            timer: 5000, // กำหนดเวลาสำหรับการปิดอัตโนมัติหลังจาก 5 วินาที
            timerProgressBar: true,
            allowOutsideClick: false
          });

          if (result.isConfirmed) {
            return true;
          } else {
            return false;
          }
        } catch (error) {
          console.error(error);
          return false;
        }
      }


      async ParamCustomize() {
        try {
          let status = true;
          let title = 'กรุณาเลือกบริษัท';
          let text = 'ไม่สามารถดำเนินการได้';
          let icon = 'error';

          const detailValue = $('#tbx_detail').val();
          const yearValue = $('#slc_year_create').val();

          console.log(Param_Search)
          if (Param_Search.length === 0) {
            status = false;
            console.log('wow')
          } else {
            console.log('no')
            title = 'คุณได้เลือกบริษัท';
            text = 'ดำเนินการ';
            icon = 'info';
            ParamID = Param_Search.map(function(item) {
              return {
                recno: item.RECNO,
                code: safeTrim(item.CODE),
                sname: safeTrim(item.SNAME),
                name: safeTrim(item.NAME),
                detail: safeTrim(detailValue),
                year: parseInt(safeTrim(yearValue))
              };


            });

            if (safeTrim(detailValue) === "") {
              status = false;
              title = 'กรุณาเติมรายละเอียด';
              text = '';
              icon = 'error';
            }
          }
          return {
            param: ParamID,
            status: status,
            title: title,
            text: text,
            icon: icon
          };
        } catch (error) {
          console.error(error);
          return {
            param: [],
            status: false,
            title: title,
            text: text,
            icon: icon
          };
        }
      }

      async ParamCustomize_Edit() {
        try {
          let edit_item = []
          edit_item.push(rowData);
          ParamID = edit_item.map(function(item) {
            return {
              recno: item.recno,
              code: safeTrim(item.code),
              sname: safeTrim(item.sname),
              name: safeTrim(item.name),
              detail: safeTrim($('#tbx_detail_edit').val()),
              year: parseInt(item.year)
            };
          });
          return {
            param: ParamID,
            status: true,
            title: '',
            text: '',
            icon: ''
          };
        } catch (error) {
          console.error(error);
          return {
            param: [],
            status: false,
            title: title,
            text: text,
            icon: icon
          };
        }
      }


      async fetchData(url, section, status) {
        return new Promise(async (resolve, reject) => {
          try {
            // ดึงข้อมูลจากเซิร์ฟเวอร์
            const jsonResponse = await fetch(url, {
              method: 'POST',
              body: set_formdata(section),
            });
            if (!jsonResponse.ok) {
              throw new Error('Error sending data to server');
            }
            const jsonDataHD = await jsonResponse.json();
            resolve(jsonDataHD); // ส่งค่า jsonDataHD ผ่าน resolve เมื่อดึงข้อมูลสำเร็จ
          } catch (error) {
            reject(error); // ส่ง error ผ่าน reject เมื่อเกิดข้อผิดพลาด
          } finally {
            // console.log("Finally");
          }
        });
      }
    }
    ////////////////////////////////////////////////////////  FETCH ////////////////////////////////////////////////////////////
    const dataFetcher = new DataFetcher();
    const dataProcessor = new DataProcessor();
    const select2Creator = new Select2Creator();
    const year_i = 2018;

    const operation = async () => {
      try {
        $('.loading').show();
        await Inital_Year(year_i);
        const Fecth_dataMain = await dataFetcher.fetchData('ajax/x_fecth_fb.php', 'select', true);
        Data_Main = Fecth_dataMain['data'][0];

        const Fecth_dataDetail = await dataFetcher.fetchData('ajax/x_fecth_mysql.php', 'selectid', true);
        Data_Detail = Fecth_dataDetail['data'][0];

        console.log(Data_Detail);
        // await Process_Year(Data_Detail);

        await data_mapping(Data_Main, Data_Detail, new Date().getFullYear());
        await mainTable.clear().rows.add(Data_Mem).draw();
        await detailTable.clear().rows.add(Data_Detail).draw();

        const processedCust = await dataProcessor.process_new(Data_Main, 'RECNO', 'CODE', 'NAME');
        await select2Creator.CreateSLC2('#slc_cust', processedCust, 'เลือก', 'รหัส ', false);
        process_slc = 1;
      } catch (error) {
        console.error(error);
      } finally {
        $('.loading').hide();
      }
    };
    // เรียกใช้งาน
    operation();


    function Inital_Year(inital) {
      let selectYear = $('#slc_year_create');
      let tableYear = $('#slc_year');
      let currentYear = new Date().getFullYear();
      for (let year = inital; year <= currentYear + 3; year++) {
        selectYear.append(`<option value="${year}">${year}</option>`);
        tableYear.append(`<option value="${year}">${year}</option>`);
      }
      selectYear.val(currentYear); // ตั้งค่า select element เป็นปีปัจจุบัน
      tableYear.val(currentYear); // ตั้งค่า select element เป็นปีปัจจุบัน
    }

    ////////////////////////////////////////////////////////  SELECT  //////////////////////////////////////////////////////////////////
    process_slc = 0;
    $('#slc_year').change(function() {
      if (process_slc !== 0) {
        let selectedYear = $(this).val();
        data_mapping(Data_Main, Data_Detail, parseInt(selectedYear));
        mainTable.clear().rows.add(Data_Mem).draw();
      }
    });

    $('#slc_cust').change(function() {
      if (process_slc !== 0) {
        search_datalist(Data_Main, parseInt($(this).select2('data')[0].id))
        // search_datalist(Data_Main, $(this).select2('data')[0].id)
        // console.log($(this).select2('data')[0])
        // console.log($(this).select2('data'))
      }
    });

    ////////////////////////////////////////////////////////  FORMDATA  //////////////////////////////////////////////////////////////////
    function createNewApidata() {
      return [{
        method: null,
        queryID: null,
        condition: null,
        tbanme: null,
        listdata: null
      }];
    }

    var apidata;
    var Paramtype = null;
    var ParamID = [];
    var Data_Mem = [];
    var Data_Detail;
    var Data_Main;

    function set_formdata(conditionsformdata) {
      apidata = createNewApidata();

      var formData = new FormData();
      if (conditionsformdata == "select") {
        apidata[0].method = "GET";
        apidata[0].queryID = "SELECT_CUST";
        apidata[0].condition = "0000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = [null];
      } else if (conditionsformdata == "selectid") {
        apidata[0].method = "GET_NEW";
        apidata[0].queryID = "SC_BILLDETAIL";
        apidata[0].condition = "0000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = [null];
      } else if (conditionsformdata == "selectfb") {
        apidata[0].method = "GET";
        apidata[0].queryID = "ALL_EMPL_LIST";
        apidata[0].condition = "0000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = [null];
      } else if (conditionsformdata == "add_new") {
        apidata[0].method = "POST_CHECK";
        apidata[0].queryID = "BILL00001";
        apidata[0].condition = "BILLDETAIL";
        apidata[0].tbanme = "C0003";
        apidata[0].listdata = ParamID;
      } else if (conditionsformdata == "edit") {
        apidata[0].method = "POST_0001";
        apidata[0].queryID = "B000002";
        apidata[0].condition = "BD01745";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = ParamID;
      } else {}
      formData.append('apidata', JSON.stringify(apidata));
      ////////////////
      return formData;
    }
    ///////////////////////////////////////////////// DATA_SUBMIT ///////////////////////////////////////////////////////////////
    $("#idForm").submit(async function(e) {
      event.preventDefault();
      var clickedButtonName = e.originalEvent.submitter.name;
      let action_status;
      // console.log(clickedButtonName)
    });
    ////////////////////////////////////////////////// _Action /////////////////////////////////////////////////////////
    // // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    // $('#home-tab').tab('show');
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#myModal").modal("hide"); // ปิดกล่องโมดอล
    });
    var rowData = null;

    
    // function go_process(){
    //   let status = true;
    //   if(process_slc !== 0){
    //     status = false
    //   }
    //   return status
    // }

    // $('#table_datadetail').on('click', '.edit', async function() {
    //   if (process_slc !== 0) {
    //     rowData = $('#table_datadetail').DataTable().row($(this).closest('tr')).data();
    //     match_val(rowData, fieldMappings_edit);
    //     $("#myModal").modal("show"); // ปิดกล่องโมดอล
    //   }
    // });

    $('#table_datadetail').on('click', '.edit', async function() {
      if (process_slc !== 0) {
        rowData = $('#table_datadetail').DataTable().row($(this).closest('tr')).data();
        match_val(rowData, fieldMappings_edit);
        $("#myModal").modal("show"); // ปิดกล่องโมดอล
      }
    });


    $("#record_e").click(function() {
      if (process_slc !== 0) {
        new Promise(async (resolve, reject) => {
          try {
            const fetchStatus = await processData('edit');
            await $("#myModal").modal("hide");
        
            resolve(fetchStatus);
          } catch (error) {
            reject(error);
          }
        });
      }
    });

    
    $("#btn_add").click(function() {
      if (process_slc !== 0) {
        new Promise(async (resolve, reject) => {
          try {
            const fetchStatus = await processData('add_new');
            resolve(fetchStatus);
          } catch (error) {
            reject(error);
          }
        });
      }
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    async function processData(condition) {
      let fetchResult = null;
      let fetchStatus = false;
      let conditionform = '';
      try {

        let Data_Adjust;
        if (condition == "add_new") {
          Data_Adjust = await dataFetcher.ParamCustomize();
        } else {
          Data_Adjust = await dataFetcher.ParamCustomize_Edit();
        }

        console.log(Data_Adjust);
        if (Data_Adjust['status'] === false) {
          await dataFetcher.ProcessAlert(Data_Adjust['title'], Data_Adjust['text'], Data_Adjust['icon']);
        } else {
          await dataFetcher.AlertSave().then(async value => {
            if (value === true) {
              $('.loading').show();
              fetchResult = await dataFetcher.fetchData('ajax/x_fecth_mysql.php', condition, true);
            }
          });
        }

        if (fetchResult !== null) {
          switch (fetchResult['type']) {
            case "T":
              fetchStatus = true;
              if (condition == "add_new") {
                await Data_Detail.push(Data_Adjust['param'][0]);
                // await detailTable.clear().rows.add(Data_Detail).draw();
                await detailTable.rows.add([Data_Adjust['param'][0]]).draw();
              } else {
                let indexToUpdate = Data_Detail.findIndex(function(item) {
                  return item.recno === Data_Adjust['param'][0].recno && item.year === Data_Adjust['param'][0].year;
                });

                if (indexToUpdate !== -1) {
                  Data_Detail[indexToUpdate].detail = Data_Adjust['param'][0].detail;
                }
              }
              $('#slc_year').val($('#slc_year_create').val());
              await data_mapping(Data_Main, Data_Detail, parseInt($('#slc_year_create').val()));
              await mainTable.clear().rows.add(Data_Mem).draw();
              await $('.loading').hide();
              finishalert = await dataFetcher.ProcessAlert_N("การบันทึกสำเร็จ", 'ข้อมูลถูกบันทึกเรียบร้อย', 'success');
              break;
            case "W":
              await dataFetcher.ProcessAlert(fetchResult['message'], 'มีข้อมูลซ้ำ', 'error');
              await $('.loading').hide();
              break;

            default:
              // กรณีที่ไม่ตรงกับเงื่อนไขข้างบน
              break;
          }
        }

        return fetchStatus;
      } catch (error) {
        throw error;
      } finally {
        // console.log("Finally");
      }
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    var Param_Search = [];
    const fieldMappings_add = {
      tbx_recno: 'RECNO',
      tbx_code: 'CODE',
    };
    const fieldMappings_edit = {
      tbx_code_edit: 'recno',
      tbx_name_edit: 'name',
      tbx_year_edit: 'year',
      tbx_detail_edit: 'detail',
    };


    function search_datalist(data_list, data_slc) {
      // console.log(data_list,data_slc)
      let foundItem;
      Param_Search = [];
      if (data_list && Array.isArray(data_list)) {
        foundItem = data_list.find(item => item.RECNO === data_slc);
        if (foundItem) {
          Param_Search.push(foundItem);
          match_val(foundItem, fieldMappings_add);
        } else {
          match_val(null, fieldMappings_add);
        }
      }
    }

    function match_val(item, fieldMappings) {
      const data_list = item;
      Object.entries(fieldMappings).forEach(([elementId, fieldName]) => {
        // const fieldValue = data_list[fieldName] ?? '';
        const fieldValue = (data_list && data_list[fieldName]) ? data_list[fieldName] : '';
        $(`#${elementId}`).val(fieldValue);
      });
    }

    function data_mapping(d_main, d_detail, Select_Year) {
      Data_Mem = [];
      // สร้าง Data_Mem
      Data_Mem = d_main.map(function(mainItem) {
        // กรอง Data_Detail ตาม recno ของ mainItem
        var filteredDetails = d_detail.filter(function(detailItem) {
          return (detailItem.recno === mainItem.RECNO) && (detailItem.year === Select_Year);
        });
        // รวม detail ใน filteredDetails เข้าด้วยกัน
        var combinedDetail = filteredDetails.map(function(detailItem) {
          return detailItem.detail;
        }).join();
        // สร้าง Object ใหม่เพื่อเก็บข้อมูลใน Data_Mem
        return {
          RECNO: mainItem.RECNO,
          CODE: mainItem.CODE,
          SNAME: mainItem.SNAME,
          NAME: mainItem.NAME,
          DETAIL: combinedDetail
        };
      });
    }

    function Process_Year(data) {
      // let years = [...new Set(data['data'][0].map(item => item.year))];
      let years = [...new Set(data.map(item => item.year))];
      // console.log(years)
      years.sort((a, b) => b - a); // เรียงลำดับจากมากไปน้อย
      // เพิ่ม <option> ลงใน <select>
      let selectYear = $('#slc_year');
      years.forEach(year => {
        selectYear.append(`<option value="${year}">${year}</option>`);
      });
    }
    ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
    function safeTrim(value) {
      return (value !== null && value !== undefined) ? value.trim() : value;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    // $('input[name="selectDataRecord"]').change(function() {
    //   selectDR = $(this).val();
    //   updateButton();
    // });

    // function updateButton() {
    //   var btn = $('#btn_add');
    //   if (selectDR === 'add_new') {
    //     btn.removeClass('btn-danger').addClass('btn-primary').text('บันทึกข้อมูล');
    //   } else if (selectDR === 'edit') {
    //     btn.removeClass('btn-primary').addClass('btn-danger').text('แก้ไขข้อมูล');
    //   }
    //   /////////////////
    //   // var indexToUpdate = Data_Detail.findIndex(function(item) {
    //   //   // return item.recno === Data_Adjust['param'][0].recno && item.year === Data_Adjust['param'][0].year;
    //   //   console.log(item.recno)
    //   //   return item.recno === 4 && item.year === 2024;
    //   // });

    //   // if (indexToUpdate !== -1) {
    //   //   // อัปเดตข้อมูล "detail" ใน Data_Detail ด้วยข้อมูลใหม่
    //   //   Data_Detail[indexToUpdate].detail = "fffffffffffff";
    //   //   data_mapping(Data_Main, Data_Detail, 2024);
    //   //   mainTable.clear().rows.add(Data_Mem).draw();
    //   // }
    //   /////////////////
    // }
    // ค้นหาว่าข้อมูลที่ต้องการอัปเดตอยู่ที่ตำแหน่งใดใน Data_Detail โดยใช้ "recno" และ "year" เป็นตัวบ่งชี้

  });
</script>

</html>