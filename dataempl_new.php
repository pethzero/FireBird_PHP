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
                      <h2>ผู้ใช้งาน</h2>
                      <hr>

                      <div class="row pb-3">
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                          <button id='newmodel' type="button" class="btn btn-primary">เพิ่มพนักงาน</button>
                        </div>
                      </div>

                      <div class="row pb-3">
                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                          <button id='newempl' type="button" class="btn btn-primary float-end">สแกนพนักงาน</button>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                          <button id='compare' type="submit" name='compare' class="btn btn-primary float-end">เทียบ</button>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12">
                          <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
                            <thead class="thead-light">
                              <tr>
                                <th>ลำดับ</th>
                                <th>ข้อมูล</th>
                                <th>ผู้ใช้งาน</th>
                                <th>รหัส</th>
                                <th>ชื่อ</th>
                                <th>ชื่อเล่น</th>
                                <th>ระดับ</th>
                                <th width='3%'>ลบ</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
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
    var datasave = '';
    var id_modify;
    var dataold = {
      old_empno: '',
      old_login: ''
    };
    var paramhd;
    var viewstatus = 'F';

    $(function() {
      if (userlevel == "F") {
        $("#newmodel").remove();
      }
    });
    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
    var mainTable  = $('#table_datahd').DataTable({
      scrollX: true,
      columns: [{
          data: 'ID'
        },
        {
          data: null,
          render: function(data, type, row) {
            return customModelRender(row, userlevel);
          }
        },
        {
          data: 'LOGIN'
        },
        {
          data: 'EMPNO'
        },
        {
          data: 'EMPNAME'
        },
        {
          data: 'EMPNICK'
        },
        {
          data: 'USERLEVEL'
        },
        {
          data: null,
          render: function(data, type, row) {
            return customModelDelete(row, userlevel);
          }
        },
      ],
      columnDefs: [{
          className: 'noVis',
          targets: [0]
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
      order: [
        [3, 'asc'],
      ],
      dom: 'Bfrtip',
      buttons: [{
          extend: 'colvis',
          text: 'Show/Hide',
          columns: ':not(.noVis)',
        },
        {
          extend: 'excelHtml5',
          title: 'Data export',
          exportOptions: {
            columns: [1, 2]
          }
        }
      ],
      initComplete: function(settings, json) {
        var api = this.api();
        if (userlevel !== "S") {
          api.column(6).visible(false);
        }
      },
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
            // เช็คว่ามีแถวที่ถูกเลือกอยู่หรือไม่
            selectedRecno = data.ID;
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

          ParamID[0]['empno'] = $('#code').val().trim();
          ParamID[0]['empname'] = $('#namereal').val().trim();
          ParamID[0]['empnick'] = $('#namenick').val().trim();
          ParamID[0]['login'] = $('#login').val().trim();
          ParamID[0]['pass'] = $('#pass').val().trim();
          ParamID[0]['userlevel'] = $('#userlevel').val().trim();

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
        .then(async (data) => {
          datajson = data['data'][0];
          await mainTable .clear().rows.add(datajson).draw();
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
      old_empno: dataold['old_empno'],
      old_login: dataold['old_login'],
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
      } else if (conditionsformdata == "selectid") {
        apidata[0].method = "GET_NEW";
        apidata[0].queryID = "ID_EMPL_LIST_ID";
        apidata[0].condition = "ID000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = ParamID;
      } else if (conditionsformdata == "selectfb") {
        apidata[0].method = "GET";
        apidata[0].queryID = "ALL_EMPL_LIST";
        apidata[0].condition = "0000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = [null];
      } else if (conditionsformdata == "add_new") {
        apidata[0].method = "POST_CHECK";
        apidata[0].queryID = "IND_EMPL";
        apidata[0].condition = "EMPNOIND";
        apidata[0].tbanme = "C0001";
        apidata[0].listdata = ParamID;
      } else if (conditionsformdata == "update_new") {
        apidata[0].method = "POST_CHECK";
        apidata[0].queryID = "UPD_EMPL_ID";
        apidata[0].condition = "EMPNOUPD_ID";
        apidata[0].tbanme = "C0002";
        apidata[0].listdata = ParamID;
      } else if (conditionsformdata == "delete_new") {
        apidata[0].method = "POST_DELETE";
        apidata[0].queryID = "DLD_EMPL_ID";
        apidata[0].condition = "ID000";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = ParamID;
      } else if (conditionsformdata == "add_dupicate") {
        apidata[0].method = "POST_DUPLICATE";
        apidata[0].queryID = "INSERT_EMPL_NEW";
        apidata[0].condition = "EMPNOUPD";
        apidata[0].tbanme = "0000";
        apidata[0].listdata = ParamEmplFB;
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
        case "savedata":

          if (['new', 'update'].includes(Paramtype)) {
            if ($('#code').val().trim() === '' || $('#login').val().trim() === '' || $('#pass').val().trim() === '') {
              let messagedata;
              if ($('#code').val().trim() === '') {
                messagedata = "กรุณากรอกรหัสประจำตัว"
              } else if ($('#login').val().trim() === '') {
                messagedata = "กรุณากรอกรหัสไอดีผู้ใช้งาน"
              } else if ($('#pass').val().trim() === '') {
                messagedata = "กรุณากรอกรหัสผ่าน"
              }
              Swal.fire({
                title: messagedata,
                text: "ข้อมูลไม่สามารถบันทึกหรือแก้ไขได้",
                icon: "error",
                buttons: ["OK"],
                dangerMode: true,
              });
              return
            }

            let actionType;
            switch (Paramtype) {
              case 'new':
                actionType = 'add_new';
                break;
              case 'update':
                actionType = 'update_new';
                break;
                // case 'delete':
                //   actionType = 'delete';
                //   break;
              default:
                break;
            }
            action_data('ajax/new_fecth_oitem_mysqldata.php', actionType);
          }
          break;
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
    $("#newempl").click(function() {
      dataFetcher.fetchData('ajax/new_fecth_fbdata.php', 'selectfb', true).then(async (data) => {
          $('.loading').show();
          ParamEmplFB = data['data'][0]['result'][0].map((item) => {
            return {
              recno: item.RECNO,
              empno: item.EMPNO,
              empname: item.EMPNAME,
              empnick: item.EMPNICK,
              login: item.LOGIN,
              pass: item.PASS,
              userlevel: item.USERLEVEL
            };

          });
          console.log(ParamEmplFB)
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          $('.loading').hide();
        });
    });


    // Button Add Data
    $("#newmodel").click(function() {
      Paramtype = "new";
      ParamID[0]['id'] = -1;
      buttontable("new", null)
    });


    $('#table_datahd').on('click', '.view', async function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      let id_modify = rowData.ID;
      Paramtype = "view";
      ParamID[0]['id'] = id_modify;
      dataFetcher.fetchData('ajax/new_fecth_oitem_mysqldata.php', 'selectid', true)
        .then(async (data) => {
          $('.loading').show();
          await buttontable("view", data['data'][0])
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          $('.loading').hide();
        });


    });

    // // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
    $(".modal .btn-secondary, .modal .btn-close").click(function() {
      $("#myModal").modal("hide"); // ปิดกล่องโมดอล
    });


    $('#table_datahd').on('click', '.edit', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      let id_modify = rowData.ID;
      Paramtype = "update"
      ParamID[0]['id'] = id_modify;
      dataFetcher.fetchData('ajax/new_fecth_oitem_mysqldata.php', 'selectid', true)
        .then(async (data) => {
          $('.loading').show();
          await buttontable("update", data['data'][0])
        })
        .catch((error) => {
          console.error(error);
        })
        .finally(() => {
          $('.loading').hide();
        });
    });




    $('#table_datahd').on('click', '.trash', function() {
      var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
      let id_modify = rowData.ID;
      Paramtype = "dtele"
      ParamID[0]['id'] = id_modify;
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function buttontable(databutton, data) {
      const resetFields = () => {
        $('#code, #namereal, #namenick, #login, #pass').val('');
        $('#userlevel').val('F');
      };

      const setButtonAttributes = (btnRemove, btnAdd, btnText, bgRevmoe, bgAdd, bgText) => {
        $('#ok').removeClass(`${btnRemove}`).addClass(`${btnAdd}`).text(btnText);
        $('#story').removeClass(`${bgRevmoe}`).addClass(`${bgAdd}`).text(bgText);
      };

      if (databutton === "new") {
        viewstatus = 'T';
        datasave = 'save';
        resetFields();
        setButtonAttributes('btn-danger btn-success', 'btn-primary', 'บันทึก', 'bg-danger bg-success', 'bg-secondary', 'เพิ่ม');
        $("#myModal").modal("show");
      } else if (databutton === "update" || databutton === "view") {
        search_datalist(data)
        viewstatus = databutton === "update" ? 'T' : 'F';
        datasave = databutton === "update" ? 'update' : '';
        const btnRemove = databutton === "update" ? 'btn-primary btn-success' : 'btn-primary btn-danger';
        const btnAdd = databutton === "update" ? 'btn-danger' : 'btn-success';
        const btnText = databutton === "update" ? 'บันทึกแก้ไข' : 'ดูรายการ';

        const bgRevmoe = databutton === "update" ? 'bg-secondary bg-success' : 'bg-secondary bg-danger';
        const bgAdd = databutton === "update" ? 'bg-danger' : 'bg-success';
        const bgText = databutton === "update" ? 'แก้ไข' : 'ดูรายการ';
        setButtonAttributes(btnRemove, btnAdd, btnText, bgRevmoe, bgAdd, bgText);
        $("#myModal").modal("show");

      }

    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function search_datalist(json_searchdatalist) {
      console.log(json_searchdatalist)
      const fieldMappings = {
        code: 'EMPNO',
        namereal: 'EMPNAME',
        namenick: 'EMPNICK',
        login: 'LOGIN',
        pass: 'PASS',
        userlevel: 'USERLEVEL',
      };

      const data_list = json_searchdatalist[0];
      // id_modify = data_list.ID;
      Object.entries(fieldMappings).forEach(([elementId, fieldName]) => {
        // ถ้า data_list[fieldName] เป็น null หรือ undefined ให้กำหนดค่าเป็น ''
        const fieldValue = data_list[fieldName] ?? '';
        if (fieldName === 'USERLEVEL' && fieldValue === '') {
          $(`#${elementId}`).val('F');
        } else {
          $(`#${elementId}`).val(fieldValue);
        }
      });
      // dataold['old_empno'] = data_list.EMPNO;
      // dataold['old_login'] = data_list.LOGIN;
    }

    ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////////////////////////

  });
</script>

</html>