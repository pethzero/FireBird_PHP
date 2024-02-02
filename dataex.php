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

    /* input:read-only {
      background-color: #E8E8E8;
    } */

    textarea:read-only {
      background-color: #E8E8E8;
    }

    .check-boxlg {
      /* Double-sized Checkboxes */
      -ms-transform: scale(1.5);
      /* IE */
      -moz-transform: scale(1.5);
      /* FF */
      -webkit-transform: scale(1.5);
      /* Safari and Chrome */
      -o-transform: scale(1.5);
      /* Opera */
      padding: 3px;
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
      <div class="loading" style="display: none;"></div>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <form id="idForm" method="POST">

          <div class="row mt-2">
            <div class="col-md-12">
              <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                  <section>

                    <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">ชื่อ:</span>
                          <input type="text" class="form-control" id="data_cust" placeholder="">
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">หมายเลขเอกสาร:</span>
                          <input type="text" class="form-control" id="data_on" placeholder="">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">บุคคลที่ติดต่อ:</span>
                          <input type="text" class="form-control" id="data_cont" placeholder="">
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">เบอร์โทรศัพท์:</span>
                          <input type="text" class="form-control" id="data_phone" placeholder="">
                        </div>
                      </div>
                    </div>

                    <div class="row" style="margin-bottom: -5px;">
                      <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                        <h5>ลักษณะงาน</h5>
                        <div class="form-check" style="margin-bottom: 10px;">
                          <input class="form-check-input check-boxlg" type="checkbox" value="" id="defaultCheck1">
                          <label class="form-check-label" for="defaultCheck1">
                            สร้างใหม่ (New)
                          </label>
                        </div>
                        <div class="form-check" style="margin-bottom: 10px;">
                          <input class="form-check-input check-boxlg" type="checkbox" value="" id="defaultCheck2">
                          <label class="form-check-label" for="defaultCheck2">
                            ลับคมตัด (Re-grind)
                          </label>
                        </div>
                        <div class="form-check" style="margin-bottom: 10px;">
                          <input class="form-check-input check-boxlg" type="checkbox" value="" id="defaultCheck3">
                          <label class="form-check-label" for="defaultCheck3">
                            ดัดแปลงคมตัด (Modify)
                          </label>
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                        <div class="input-group mb-3">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Drawing No.</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <input type="text" class="form-control" id="data_phone" placeholder="">
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="col-sm-12 col-md-4 col-lg-6 col-xl-6">
                        <h5 style="margin-bottom: 1;">เอกสารที่แนบที่ต้องแนบ</h5>
                        <p style="margin-bottom: 0;">-DWG ลูกค้า</p>
                        <p style="margin-bottom: 0;">-ใบสั่งซื้อลูกค้า</p>
                        <p style="margin-bottom: 0;">-ใบสั่งซื้อลูกค้า</p>
                      </div>
                    </div>


                    <!-- <h5 >เอกสารที่แนบที่ต้องแนบ</h5> -->
                    <div class="row">
                      <h5>รายละเอียดข้อมูลเพิ่มเติม(สำหรับงาน New)</h5>
                      <h5>ชิ้นงานลูกค้า</h5>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">Part name;</span>
                          <input type="text" class="form-control" id="data_cont" placeholder="" readonly>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">Material:</span>
                          <input type="text" class="form-control" id="data_phone" placeholder="" readonly>
                        </div>
                      </div>
                      <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                          <span class="input-group-text ">Material:</span>
                          <input type="text" class="form-control" id="data_phone" placeholder="" readonly>
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

      $("#data_cust").val(username);
      $("#empl_no").val(userno);
    });


    //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////

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
      // dataFetcher.fetchData('ajax/new_fecth_oitem_mysqldata.php', 'select', true)
      //   .then(async (item) => {
      //     datarest_empl = await dataFetcher.fetchData('ajax/new_fecth_fbdata_new.php', 'emplrest', true);
      //     let datajson;
      //     if (userlevel === 'T' || userlevel === 'S') {
      //       datajson = item['data'][0];
      //       await detailtable.clear().rows.add(datajson).draw();
      //       await Processchart(parseInt(userecno));
      //     } else {
      //       datajson = [];
      //       await Processchart(parseInt(userecno));
      //     }


      //     // console.log(datarest_empl)
      //   })
      //   .catch((error) => {
      //     console.error(error);
      //   })
      //   .finally(() => {
      //     $('.loading').hide();
      //   });
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
      // empno: $('#code').val().trim(),
      // empname: $('#namereal').val().trim(),
      // empnick: $('#namenick').val().trim(),
      // login: $('#login').val().trim(),
      // pass: $('#pass').val().trim(),
      // userlevel: $('#userlevel').val().trim(),
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