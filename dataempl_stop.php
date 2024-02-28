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

    input:read-only {
      background-color: #E8E8E8;
    }

    textarea:read-only {
      background-color: #E8E8E8;
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
            <div class="col-md-12">
              <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                  <section>
                    <div class="main_data">
                      <h2>ประวัติการลา</h2>
                      <hr>
                      <button type="button" id="btnTest"> Test </button>
                      <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <div class="chartCard">
                            <div class="chartBox">
                              <canvas id="myChart"></canvas>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-12">
                              <table id="tbd_emplrest" class="nowrap table table-striped table-bordered align-middle " width='100%'>
                                <thead class="thead-light">
                                  <tr>
                                    <th>รูปแบบ</th>
                                    <th>จำนวน</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td>ลากิจ</td>
                                    <td>0</td>
                                  </tr>
                                  <tr>
                                    <td>ลาป่วย(มีใบรับรอง)</td>
                                    <td>0</td>
                                  </tr>
                                  <tr>
                                    <td>ลาป่วย(ไม่มีใบรับรอง)</td>
                                    <td>0</td>
                                  </tr>
                                  <tr>
                                    <td>พักร้อน</td>
                                    <td>0</td>
                                  </tr>
                                  <tr>
                                    <td>ลาคลอด</td>
                                    <td>0</td>
                                  </tr>
                                  <tr>
                                    <td>ลาอุปสมบท</td>
                                    <td>0</td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-6">

                          <div class="chartCard">
                            <div class="chartBox">
                              <canvas id="myChart2"></canvas>
                            </div>
                          </div>

                          <div class="row mt-5">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <div class="input-group mb-3">
                                <span class="input-group-text c_activity">ชื่อ:</span>
                                <input type="text" class="form-control" id="empl_name" placeholder="" readonly>
                              </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <div class="input-group mb-3">
                                <span class="input-group-text c_activity">รหัส:</span>
                                <input type="text" class="form-control" id="empl_no" placeholder="" readonly>
                              </div>
                            </div>
                          </div>

                          <div class="row">

                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <div class="input-group date mb-3" id="datepicker_bdate">
                                <span class="input-group-text c_activity">วันที่เริ่ม:</span>
                                <input type="text" class="form-control" id="data_bdate" readonly />
                                <span class="input-group-append">
                                  <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                  </span>
                                </span>
                              </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                              <div class="input-group date mb-3" id="datepicker_edate">
                                <span class="input-group-text c_activity">วันที่สิ้นสุด:</span>
                                <input type="text" class="form-control" id="data_edate" readonly />
                                <span class="input-group-append">
                                  <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                  </span>
                                </span>
                              </div>
                            </div>


                            <div class="row">
                              <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">

                                <div class="input-group mb-3">
                                  <span class="input-group-text c_activity">รหัส:</span>
                                  <select class="form-select" id="data_status">
                                    <option value="T" selected>ทั้งปีของตัวเอง</option>
                                    <option value="B">เลือกแบบระบุวันที่</option>
                                    <option value="S">เลือกทั้งหมด</option>
                                  </select>
                                </div>


                              </div>
                            </div>



                          </div>
                        </div>
                      </div>




                    </div>
                  </section>

                  <section id='table'>
                    <hr>

                    <div class="row">
                      <div class="col-12">
                        <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
                          <thead class="thead-light">
                            <tr>
                              <th>ลำดับ</th>
                              <th>ลำดับ RECNO</th>
                              <th>รหัส</th>
                              <th>ชื่อ</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>

                  </section>
                  <section>
                    <div class="modal fade" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-sm modal-md modal-lg modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">บันทึกแจ้งซ่อม <span id='story' class="badge"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>

                          <div class="modal-body">
                            <!-- ส่วนที่เพิ่มเนื้อหาภายในกล่องโมดอลได้ที่นี่ -->
                            <section>
                              <div class="container-fluid">
                                <h2 id="dataactivity">ตารางนัดหมาย <span id='story' class="badge"></span></h2>
                                <hr>
                                <div class="row">

                                  <div class="input-group mb-3">
                                    <span class="input-group-text ">รหัสประจำตัว:</span>
                                    <input type="text" class="form-control" id="code" placeholder="กรอกรหัสประจำตัว" maxlength="16">
                                  </div>

                                  <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ระดับ:</span>
                                    <select class="form-select" id="userlevel">
                                      <option value="F" selected>ผู้ใช้งาน</option>
                                      <option value="T">แอดมิน</option>
                                      <?php
                                      if ($_SESSION['USERLEVEL'] == 'S') {
                                        echo '<option value="S">super admin</option>';
                                      }
                                      ?>
                                    </select>
                                  </div>

                                  <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ชื่อจริง:</span>
                                    <input type="text" class="form-control" id="namereal" placeholder="ชื่อจริง" maxlength="80">
                                  </div>

                                  <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ชื่อเล่น:</span>
                                    <input type="text" class="form-control" id="namenick" placeholder="ชื่อเล่น" maxlength="80">
                                  </div>

                                  <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ผู้ใช้งาน:</span>
                                    <input type="text" class="form-control" id="login" placeholder="ชื่อล๊อคอิน" maxlength="128">
                                  </div>

                                  <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">รหัสผ่าน:</span>
                                    <input type="password" class="form-control" id="pass" placeholder="รหัสผ่าน" maxlength="128" autocomplete="current-pass">

                                  </div>
                                </div>
                              </div>
                            </section>
                          </div>

                          <div class="modal-footer">
                            <button id="ok" type="submit" name='savedata' class="btn btn-primary">บันทึก</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>


                </div>
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
<script>
  $(document).ready(function() {
    var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";
    var userno = "<?php echo isset($_SESSION['EMPNO']) ? $_SESSION['EMPNO'] : ''; ?>";
    var username = "<?php echo isset($_SESSION['EMPNAME']) ? $_SESSION['EMPNAME'] : ''; ?>";
    var userecno = "<?php echo isset($_SESSION['RECNO']) ? $_SESSION['RECNO'] : ''; ?>";
    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });
    ///////////////////////////////////////////////////////////// DATA /////////////////////////////////////////////////////////////////
    var recno = null;
    var selectedRow = null;
    var selectedRecno = null;
    var id_modify;

    $(function() {
      // if (userlevel == "F") {
      //   $("#empl_name").val(username);
      //   $("#empl_no").val(userecno);
      // }
      $("#data_bdate").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        clearBtn: true
      });

      $("#data_edate").datepicker({
        format: "dd/mm/yyyy",
        todayHighlight: true,
        autoclose: true,
        clearBtn: true
      });

      $("#empl_name").val(username);
      $("#empl_no").val(userno);
    });


    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    var detailtable = $('#table_datahd').DataTable({
      scrollX: true,
      columns: [{
          data: 'ID'
        },
        {
          data: 'RECNO'
        },
        {
          data: 'EMPNO'
        },
        {
          data: 'EMPNAME'
        },
      ],
      columnDefs: [{
          className: 'noVis',
          targets: [0]
        },
        {
          "visible": false,
          "targets": [0, 1]
        },
        {
          "orderable": false,
          "targets": 1
        },
      ],
      order: [
        [1, 'asc'],
      ],
      dom: 'frtip',
      initComplete: function(settings, json) {},
      createdRow: function(row, data, dataIndex) {},
      drawCallback: function(settings) {},
      rowCallback: function(row, data) {
        $(row).on('click', function() {
          if (selectedRow !== null) {
            $(selectedRow).removeClass('table-custom');
          }
          $(this).addClass('table-custom');
          selectedRow = this;

          if (selectedRecno !== data.ID) {
            selectedRecno = data.ID;
            Processchart(data.RECNO)
          }
        });
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
              cancelButton: 'cancel'
            },
            reverseButtons: true
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
      async ProcessAlert() {
        try {
          return true;
        } catch (error) {
          console.error(error);
        }
      }

      async ParamCustomize() {
        try {

          // ParamID[0]['empno'] = $('#code').val().trim();
          // ParamID[0]['empname'] = $('#namereal').val().trim();
          // ParamID[0]['empnick'] = $('#namenick').val().trim();
          // ParamID[0]['login'] = $('#login').val().trim();
          // ParamID[0]['pass'] = $('#pass').val().trim();
          // ParamID[0]['userlevel'] = $('#userlevel').val().trim();

          return true;
        } catch (error) {
          console.error(error);
        }
      }
      async fetchData(url, section, status) {
        try {
          // ดึงข้อมูล  จากเซิร์ฟเวอร์
          const jsonResponse = await fetch(url, {
            method: 'POST',
            body: set_formdata(section),
          });

          if (!jsonResponse.ok) {
            throw new Error('Error sending data to server');
          }
          const jsonDataHD = await jsonResponse.json();

          return jsonDataHD; // เพิ่มบรรทัดนี้เพื่อ return ค่า jsonDataHD
        } catch (error) {
          console.error(error);
        }
      }
    }
    ////////////////////////////////////////////////////////  FETCH ////////////////////////////////////////////////////////////
    const dataFetcher = new DataFetcher();
    const operation = () => {
      dataFetcher.fetchData('ajax/new_fecth_oitem_mysqldata.php', 'select', true)
        .then(async (item) => {
          datarest_empl = await dataFetcher.fetchData('ajax/new_fecth_fbdata_new.php', 'emplrest', true);
          let datajson;
          if (userlevel === 'T' || userlevel === 'S') {
            datajson = item['data'][0];
            await detailtable.clear().rows.add(datajson).draw();
            await Processchart(parseInt(userecno));
          } else {
            datajson = [];
            await Processchart(parseInt(userecno));
          }


          // console.log(datarest_empl)
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          $('.loading').hide();
        });
    };

    // เรียกใช้งาน
    operation();

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
    var Paramtype = null;
    var apidata;
    // var ParamEmplMysql;
    var ParamEmplFB;
    var ParamID = [{
      id: id_modify,
      empno: $('#code').val().trim(),
      empname: $('#namereal').val().trim(),
      empnick: $('#namenick').val().trim(),
      login: $('#login').val().trim(),
      pass: $('#pass').val().trim(),
      userlevel: $('#userlevel').val().trim(),
    }];

    function set_formdata(conditionsformdata) {
      apidata = createNewApidata();

      var formData = new FormData();
      if (conditionsformdata == "select") {
        apidata[0].method = "GET_NEW";
        apidata[0].queryID = "ALL_EMPL_LIST";
        apidata[0].condition = "0000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = [null];
      } else if (conditionsformdata == "emplrest") {
        apidata[0].method = "GET";
        apidata[0].queryID = "EMPL_REST";
        apidata[0].condition = "0000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = [null];
      } else {}
      // console.log(apidata)
      formData.append('apidata', JSON.stringify(apidata));
      ////////////////
      return formData;
    }
    ///////////////////////////////////////////////// DATA_SUBMIT ///////////////////////////////////////////////////////////////
    $("#idForm").submit(async function(e) {
      event.preventDefault();
      var clickedButtonName = e.originalEvent.submitter.name;
      let action_status;
      console.log(clickedButtonName)
      switch (clickedButtonName) {

        case "view":
          break;
        case "btndelete":
          action_data('ajax/new_fecth_oitem_mysqldata.php', 'delete_new');
          break;
        case "compare":
          if (ParamEmplFB !== undefined) {
            action_data('ajax/new_fecth_oitem_mysqldata.php', 'add_dupicate');
          }
          break;
        default:
      }

    });

    function action_data(url, type) {
      let prosscessdata;
      dataFetcher.ParamCustomize()
        .then(async () => {
          let crudstatus = await dataFetcher.AlertSave();
          if (crudstatus) {
            $('.loading').show();
            prosscessdata = await dataFetcher.fetchData(url, type, true);
            await operation();
            console.log(prosscessdata)
            if (['new', 'update', 'delete'].includes(Paramtype)) {

              if (prosscessdata['type'] === 'W') {
                Swal.fire({
                  title: prosscessdata['message'],
                  text: "กรุณากรอกใหม่",
                  icon: "error",
                  buttons: ["OK"],
                  dangerMode: true,
                });
              } else if (prosscessdata['type'] === 'T') {
                Swal.fire({
                  title: 'บันทึกสำเร็จ',
                  text: "ข้อมูลูกบันทึกเรียบร้อย",
                  icon: "success",
                  buttons: ["OK"],
                  dangerMode: true,
                });
                $("#myModal").modal("hide"); // ปิดกล่องโมดอล
              }
            }

          }
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          // $('.loading').hide();
        });
    }


    ////////////////////////////////////////////////// _Action /////////////////////////////////////////////////////////
    // Button Add Data
    $("#newmodel").click(function() {
      Paramtype = "new";
      ParamID[0]['id'] = -1;
      buttontable("new", null)
    });



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////// CHART ////////////////////////////////////////////////////
    // Button Add Data
    var rest_data = [{
      data1: 0,
      data2: 0,
      data3: 0,
      data4: 0,
      data5: 0,
      data6: 0,
    }]


    function Processchart(dataid) {
     
      let check_status = updateDataBasedOnStatus(datarest_empl['data'][0], dataid)
      console.log('Update' + check_status)
      console.log(rest_data)

      if (check_status === true) {
        updateRestDataFromTable(rest_data);

        const newData = data.datasets[0].data.map((item, index) => rest_data[0][`data${index + 1}`]);
        data.datasets[0].data = newData;
        myChart.update();

        // สร้างข้อมูลใหม่สำหรับ myChart2
        const newData2 = data2.datasets[0].data.map((item, index) => rest_data[0][`data${index + 1}`]);
        data2.datasets[0].data = newData2;
        myChart2.update();
      }

    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function updateRestDataByStatus(rest_data, status) {
      switch (status) {
        case 1:
          rest_data[0]['data1'] += 1;
          break;
        case 2:
          rest_data[0]['data2'] += 1;
          break;
        case 3:
          rest_data[0]['data3'] += 1;
          break;
        case 4:
          rest_data[0]['data4'] += 1;
          break;
        case 5:
          rest_data[0]['data5'] += 1;
          break;
        case 6:
          rest_data[0]['data6'] += 1;
          break;
      }
    }

    function shouldProcessItem(item, dataid, check_type, data_bdate, data_edate) {
      const bdate = new Date(item['BDATE']);
      return check_type === "S" ||
        (item['EMPL'] === dataid && check_type !== "B") ||
        (item['EMPL'] === dataid && bdate >= new Date(data_bdate) && bdate <= new Date(data_edate));
    }

    function processItem(rest_data, item, dataid, check_type, data_bdate, data_edate) {
      if (shouldProcessItem(item, dataid, check_type, data_bdate, data_edate)) {
        updateRestDataByStatus(rest_data, item['STATUS']);
        return true;
      }
      return false;
    }

    function processData(check_status, check_type, dataObject, dataid, data_bdate, data_edate, rest_data) {
      if (check_status === true) {
        dataObject[0].forEach(item => {
          processItem(rest_data, item, dataid, check_type, data_bdate, data_edate);
        });
        return true;
      }
      return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    function updateDataBasedOnStatus(dataObject, dataid) {
      let check_status = true;
      let check_type = $('#data_status').val();
      let data_condtion;
      let data_bdate;
      let data_edate;
      rest_data = [{
        data1: 0,
        data2: 0,
        data3: 0,
        data4: 0,
        data5: 0,
        data6: 0,
      }];
      if (check_type === "B") {
        data_condtion = checkdate($('#data_status').val());
        check_status = data_condtion['status'];
        data_bdate = data_condtion['databegin'];
        data_edate = data_condtion['dateend'];
      }

      processData(check_status, check_type, dataObject, dataid, data_bdate, data_edate, rest_data);
      return true;
    }



    function updateRestDataFromTable(dataObject) {
      $('#tbd_emplrest tbody tr').each(function(index) {
        // ให้ td1 เก็บค่าของคอลัมน์ที่ 1 (รูปแบบ)
        let td1 = $(this).find('td:eq(0)').text();
        switch (td1) {
          case 'ลากิจ':
            $(this).find('td:eq(1)').text(dataObject[0].data1);
            break;
          case 'ลาป่วย(มีใบรับรอง)':
            $(this).find('td:eq(1)').text(dataObject[0].data2);
            break;
          case 'ลาป่วย(ไม่มีใบรับรอง)':
            $(this).find('td:eq(1)').text(dataObject[0].data3);
            break;
          case 'พักร้อน':
            $(this).find('td:eq(1)').text(dataObject[0].data4);
            break;
          case 'ลาคลอด':
            $(this).find('td:eq(1)').text(dataObject[0].data5);
            break;
          case 'ลาอุปสมบท':
            $(this).find('td:eq(1)').text(dataObject[0].data6);
            break;
        }
      });
    }



    const data = {
      labels: ['ลากิจ', 'ลาป่วย(มีใบรับรอง)', 'ลาป่วย(ไม่มีใบรับรอง)', 'พักร้อน', 'ลาคลอด', 'ลาอุปสมบท'],
      datasets: [{
        label: 'ประวัติลา',
        data: Array(6).fill(null), // กำหนดข้อมูลเริ่มต้นให้เป็น null ในอาร์เรย์ขนาด 10 ตัว
        backgroundColor: [
          'rgba(0, 153, 51, 0.2)',
          'rgba(255, 0, 0, 0.2)', // สีใหม่สำหรับ 'ลาป่วย(มีใบรับรอง)'
          'rgba(0, 0, 255, 0.2)', // สีใหม่สำหรับ 'ลาป่วย(ไม่มีใบรับรอง)'
          'rgba(255, 106, 0, 0.2)', // สีใหม่สำหรับ 'พักร้อน'
          'rgba(128, 0, 128, 0.2)', // สีใหม่สำหรับ 'ลาคลอด'
          'rgba(255, 165, 0, 0.2)', // สีใหม่สำหรับ 'ลาอุปสมบท'
        ],
        borderColor: [
          'rgba(0, 153, 51, 1)',
          'rgba(255, 0, 0, 1)', // สีใหม่สำหรับ 'ลาป่วย(มีใบรับรอง)'
          'rgba(0, 0, 255, 1)', // สีใหม่สำหรับ 'ลาป่วย(ไม่มีใบรับรอง)'
          'rgba(255, 106, 0, 1)', // สีใหม่สำหรับ 'พักร้อน'
          'rgba(128, 0, 128, 1)', // สีใหม่สำหรับ 'ลาคลอด'
          'rgba(255, 165, 0, 1)', // สีใหม่สำหรับ 'ลาอุปสมบท'
        ],
        // backgroundColor: [
        //   'rgba(0, 153, 51,0.2)',
        // ],
        // borderColor: [
        //   'rgba(0, 153, 51,1)'
        // ],
        borderWidth: 2
      }]
    };

    const config = {
      // type: 'bar',
      type: 'bar',
      data,
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'จำนวนการลา',
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
            text: 'ประวัติลา', // ข้อความหัวเรื่อง
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
            callbacks: {}
          }
        },
      }
    };


    const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );


    //////////////////////////////////////

    const data2 = {
      labels: ['ลากิจ', 'ลาป่วย(มีใบรับรอง)', 'ลาป่วย(ไม่มีใบรับรอง)', 'พักร้อน', 'ลาคลอด', 'ลาอุปสมบท'],
      datasets: [{
        label: 'ประวัติลา',
        data: Array(6).fill(null), // กำหนดข้อมูลเริ่มต้นให้เป็น null ในอาร์เรย์ขนาด 10 ตัว
        backgroundColor: [
          'rgba(0, 153, 51, 0.2)',
          'rgba(255, 0, 0, 0.2)', // สีใหม่สำหรับ 'ลาป่วย(มีใบรับรอง)'
          'rgba(0, 0, 255, 0.2)', // สีใหม่สำหรับ 'ลาป่วย(ไม่มีใบรับรอง)'
          'rgba(255, 106, 0, 0.2)', // สีใหม่สำหรับ 'พักร้อน'
          'rgba(128, 0, 128, 0.2)', // สีใหม่สำหรับ 'ลาคลอด'
          'rgba(255, 165, 0, 0.2)', // สีใหม่สำหรับ 'ลาอุปสมบท'
        ],
        borderColor: [
          'rgba(0, 153, 51, 1)',
          'rgba(255, 0, 0, 1)', // สีใหม่สำหรับ 'ลาป่วย(มีใบรับรอง)'
          'rgba(0, 0, 255, 1)', // สีใหม่สำหรับ 'ลาป่วย(ไม่มีใบรับรอง)'
          'rgba(255, 106, 0, 1)', // สีใหม่สำหรับ 'พักร้อน'
          'rgba(128, 0, 128, 1)', // สีใหม่สำหรับ 'ลาคลอด'
          'rgba(255, 165, 0, 1)', // สีใหม่สำหรับ 'ลาอุปสมบท'
        ],
        borderWidth: 2
      }]
    };

    const config2 = {
      type: 'doughnut',
      data: data2,
      options: {
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: false,
            text: 'ประวัติลา', // ข้อความหัวเรื่อง
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
            callbacks: {}
          }
        },
      }
    };

    const myChart2 = new Chart(
      document.getElementById('myChart2'),
      config2
    );

    // $("#myChart").css("height", 800);
    if (window.innerWidth <= 768) {
      // ถ้าความกว้างของหน้าจอน้อยกว่าหรือเท่ากับ 600px (สำหรับโทรศัพท์)
      $("#myChart").css("height", "200px");
    } else {
      // ถ้าความกว้างของหน้าจอมากกว่า 600px (สำหรับคอมพิวเตอร์ PC)
      $("#myChart").css("height", "480px");
    }
    ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////

    $('#btnTest').click(
      function() {
        const result = checkdate($('#data_status').val());
        // console.log(result);
      }
    )

    const checkdate = (daystatus) => {
      const beginDateInput = $('#data_bdate').val();
      const endDateInput = $('#data_edate').val();
      const beginDate = moment(beginDateInput, 'DD/MM/YYYY');
      const endDate = moment(endDateInput, 'DD/MM/YYYY');
      const result = {
        status: false,
        databegin: '',
        dateend: ''
      };

      if (daystatus === "B") {
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
      } else {
        return result;
      }

      result.status = true;
      result.databegin = beginDate.format('YYYY-MM-DD');
      result.dateend = endDate.format('YYYY-MM-DD');
      return result;
    };
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

  });
</script>

</html>