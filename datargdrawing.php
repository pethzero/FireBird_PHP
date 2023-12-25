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
    $csrfToken = bin2hex(random_bytes(32)); // สร้าง token สุ่ม
    $_SESSION['csrf_token'] = $csrfToken;
    // $_SESSION['csrf_token'] = keyse();
    ?>
    <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>

<body>
    <?php
    include("0_header.php");
    include("0_breadcrumb.php");

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

        .button-container {
            display: flex;
            gap: 10px;
            /* ระยะห่างระหว่างปุ่ม */
        }

        /* .input-gray{
        background-color:#E8E8E8;
        } */
        input:read-only {
            background-color: #E8E8E8;
        }

        textarea:read-only {
            background-color: #E8E8E8;
        }
    </style>

    <?php
    include("connect_sql.php");
    ?>

    <section>
        <div class="container-fluid pt-3">

            <div class="row pb-3">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
                </div>
            </div>

            <h2>เพิ่มผู้ใช้งาน</h2>
            <!-- <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
            <div class="input-group date mb-3" id="datepicker_search">
              <span class="input-group-append">
                <span class="input-group-text bg-light d-block">
                  <i class="fa fa-calendar"></i>
                </span>
              </span>
              <input type="text" class="form-control" id="date_search" readonly />
            </div>
          </div>
        </div> -->




            <!-- <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                    <button id='seacrh' type="button" class="btn btn-primary">ค้นหา</button>
                </div>
            </div> -->

            <hr>

            <div class="row pb-3">

                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <button id='newmodel' type="button" class="btn btn-primary">เพิ่มพนักงาน</button>
                </div>
            </div>




            <div class="row">
                <div class="col-12">
                    <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
                        <thead class="thead-light">
                            <tr>
                                <th>ลำดับ</th>
                                <th>ข้อมูล</th>
                                <th>Customer</th>
                                <th>Drawing Number</th>
                                <th>Rev No.</th>
                                <th>Part Name</th>
                                <th>Date</th>
                                <th>Remark</th>
                                <th>ผู้จัดทำ</th>
                                <th>แก้ไขล่าสุด</th>
                                <!-- <th>ลำดับ</th>
                                <th>ข้อมูล</th>
                                <th>รหัส</th>
                                <th>ชื่อ</th>
                                <th>ชื่อเล่น</th>
                                <th>ระดับ</th> -->
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text c_activity">Customer:</span>
                                                <input type="text" class="form-control" id="custname" placeholder="ลูกค้า">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text c_activity">Drawing Number:</span>
                                                <input type="text" class="form-control" id="drawno" placeholder="Drawing Number">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text c_activity">Rev. No:</span>
                                                <input type="number" class="form-control" id="revno" placeholder="Rev No." readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text c_activity">Part Name:</span>
                                                <input type="text" class="form-control" id="partname" placeholder="Part Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group date mb-3" id="datepicker">
                                                <span class="input-group-text c_activity">วันที่บันทึก:</span>
                                                <input type="text" class="form-control" id="date" />
                                                <span class="input-group-append">
                                                    <span class="input-group-text bg-light d-block">
                                                        <i class="fa fa-calendar"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text c_activity">Remark:</span>
                                                <textarea id="remark" class="form-control h_textarea" rows="3" aria-label="With textarea"></textarea>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text ">ผู้บันทึก:</span>
                                                <input type="text" class="form-control" id="recuser" placeholder="ผู้บันทึก">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text ">ผู้บันทึกครั้งแรก:</span>
                                                <input type="text" class="form-control" id="createuser" placeholder="ผู้บันทึก" readonly>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                        </section>
                    </div>

                    <div class="modal-footer">
                        <!-- <button id="btnmodified" style="display: none;" type="button" class="btn btn-warning">แก้ไข ReVno บันทึกใหม่</button> -->
                        <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- <div class="loading"> -->

</body>
<?php include("0_footerjs.php"); ?>
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

        var recno = null;
        // var qid = 'SEL_DRAWING';
        var selectedRow = null;
        var selectedRecno = null;
        var datasave = '';

        // var recno_owner = 0;
        // var recno_nowner = "";

        // var recno_cust = 0;
        // var recno_namecust = "";

        // var recno_cont = 0;
        // var recno_namecont = "";

        var recno_edit;
        // var recno_equipment = 0;
        // var encodedURL_Select = encodeURIComponent('ajax_select_sql_mysql.php');
        var encodedURL_Insert = 'ajax/ajaxinsertnew.php';
        var encodedURL_Update = 'ajax/ajaxupdatenew.php';
        var encodedURL_Modifi = 'ajax/ajaxmodifi.php';

        $(function() {
            if (userlevel == "F") {
                $("#newmodel").remove();
            }

            $("#date_search").datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                todayHighlight: true,
                autoclose: true
            });
        });


        //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
        // console.log(userlevel)
        const customModelRender = (row, istatus) => {
            if (istatus == "T" || istatus == "S") {
                if (row['STATUS'] == 'A') {
                    return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` +
                        `<button class="btn btn-danger btn-sm edit" id="edit_table_modal_${row['RECNO']}"><i class="far fa-edit"></i></button>` +
                        `<button class="btn btn-warning btn-sm modified" id="modified_table_modal_${row['RECNO']}"><i class="far fa-edit"></i></button>` + `</div>`;
                } else {
                    return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `</div>`;
                }
            } else {
                return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `</div>`;
            }
        };

        var encodedURL = encodeURIComponent('ajax_select_sql_mysql.php');
        var data_array = [];
        var detailtable = $('#table_datahd').DataTable({
            // ajax: {
            //     url: encodedURL,
            //     data: function(d) {
            //         d.queryId = qid; // ส่งค่าเป็นพารามิเตอร์ queryId
            //         d.params = null;
            //         // d.params = {
            //         //   // RECNO:recno,
            //         //   STARTD: startd,
            //         // };
            //         d.condition = '';
            //         d.sqlprotect = encodeData;
            //     },
            //     dataSrc: function(json) {
            //         tablejsondata = json.data;
            //         return json.data;
            //     }
            // },
            scrollX: true,
            columns: [{
                    data: 'RECNO'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        // return `<div class="button-container">` + `<button class="btn btn-primary btn-sm view" id="view_table_modal_${row['RECNO']}"><i class="far fa-eye"></i></button>` + `<button class="btn btn-danger btn-sm edit" id="edit_table_modal_${row['RECNO']}"><i class="far fa-edit"></i></button>` + `</div>`;
                        // return `<button class="btn btn-primary btn-sm edt" data-bs-toggle="modal" data-bs-target="#edt" data-bs-row-id="${row['RECNO']}"><i class="fa fa-edit"></i></button>`;
                        return customModelRender(row, userlevel);
                    }
                },
                {
                    data: 'CUSTOMER'
                },
                {
                    data: 'DRAWNO'
                },
                {
                    data: 'REVNO'
                },
                {
                    data: 'PARTNAME'
                },
                {
                    data: 'RECDATE'
                },
                {
                    data: 'REMARK'
                },
                {
                    data: 'CREATEDBY'
                },
                {
                    data: 'MODIFIEDBY'
                }
            ],
            columnDefs: [{
                    "visible": false,
                    "targets": 0
                },
                {
                    className: 'noVis',
                    targets: [0]
                },
                {
                    className: 'dt-center',
                    targets: [3]
                }
            ],
            order: [
                [0, 'desc'],
            ],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'colvis',
                    text: 'Show/Hide',
                    columns: ':not(.noVis)',
                    // columnText: function ( dt, idx, title ) {
                    // return (idx+1)+': '+title;
                    // }
                },
                //  'csv', 
                {
                    extend: 'excelHtml5',
                    title: 'Data export',
                    exportOptions: {
                        // columns: [ 2, 3,4,5,6,7,8,9,10 ]
                        columns: [1, 2]
                    }
                }
            ],

            initComplete: function(settings, json) {
                // $('.loading').hide();
            },
            createdRow: function(row, data, dataIndex) {

            },
            drawCallback: function(settings) {

            },
            rowCallback: function(row, data) {
                $(row).on('click', function() {
                    if (selectedRow !== null) {
                        $(selectedRow).removeClass('table-custom');
                    }
                    $(this).addClass('table-custom');
                    selectedRow = this;
                    if (selectedRecno !== data.RECNO) {
                        selectedRecno = data.RECNO;
                    }
                });
            },
        });





        $("#datepicker").datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            todayHighlight: true,
            autoclose: true
        });

        // $("#datepicker_first").datepicker({
        //     format: "dd/mm/yyyy",
        //     clearBtn: true,
        //     todayHighlight: true,
        //     autoclose: true
        // });

        // $("#datepicker_last").datepicker({
        //     format: "dd/mm/yyyy",
        //     clearBtn: true,
        //     todayHighlight: true,
        //     autoclose: true
        // });


        $('#date_search').val(moment(new Date()).format('DD/MM/YYYY'));

        $("#newmodel").click(function() {
            $('#ok').removeClass('btn-danger btn-success btn-warning').addClass('btn-primary').text('บันทึก');
            $('#story').removeClass('bg-danger bg-success').addClass('bg-secondary').text('เพิ่ม');
            datasave = 'save';
            $uploadolddb = '';
            viewstatus = 'T';

            /// INPUT
            $('#custname').val('');
            $('#drawno').val('');
            $('#revno').val(0);
            $('#partname').val('');
            $('#date').val('');
            $('#remark').val('');
            $('#createuser').val('');
            $('#recuser').val('');

            $('#custname').prop('readonly', false);
            $('#drawno').prop('readonly', false);
            $('#partname').prop('readonly', false);

            $('#date').prop('readonly', false);
            $('#remark').prop('readonly', false);
            $('#recuser').prop('readonly', false);
            $("#myModal").modal("show"); // เปิดกล่องโมดอล
        });

        $('#table_datahd').on('click', '.edit', function() {
            var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
            $('#ok').removeClass('btn-primary btn-success btn-warning').addClass('btn-danger').text('บันทึกแก้ไข');
            $('#story').removeClass('bg-secondary bg-success').addClass('bg-danger').text('แก้ไข');
            viewstatus = 'T';
            datasave = 'update';
            $('#custname').prop('readonly', true);
            $('#drawno').prop('readonly', false);
            $('#partname').prop('readonly', false);
            $('#date').prop('readonly', false);
            $('#remark').prop('readonly', false);
            $('#recuser').prop('readonly', false);
            recno_edit = rowData.RECNO;
            console.log(recno_edit)
            CRUDSQL('ajax/fecth_item.php', 'select')
                .then(() => {
                    $("#myModal").modal("show");
                })
                .catch(error => {
                    console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
                });

        });

        // $('#table_datahd').on('click', '.modified', function() {
        //     var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
        //     $('#ok').removeClass('btn-primary btn-success btn-danger').addClass('btn-warning').text('บันทึกแก้ไข RevNO');
        //     $('#story').removeClass('bg-secondary bg-success').addClass('bg-danger').text('แก้ไข');
        //     // recno_edit = rowData.RECNO;
        //     viewstatus = 'T';
        //     datasave = 'modified';

        //     // $("#btnmodified").show();

        //     $('#custname').prop('readonly', true);
        //     $('#drawno').prop('readonly', true);
        //     $('#partname').prop('readonly', false);
        //     $('#date').prop('readonly', false);
        //     $('#remark').prop('readonly', false);
        //     $('#recuser').prop('readonly', false);

        //     search_datalist(rowData.RECNO);
        //     $("#myModal").modal("show");
        // });


        // $('#table_datahd').on('click', '.view', function() {
        //     var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
        //     $('#ok').removeClass('btn-primary btn-danger btn-warning').addClass('btn-success').text('ดูรายการ');
        //     $('#story').removeClass('bg-secondary bg-danger').addClass('bg-success').text('ดูรายการ');
        //     viewstatus = 'F';
        //     $('#custname').prop('readonly', true);
        //     $('#drawno').prop('readonly', true);
        //     $('#partname').prop('readonly', true);
        //     $('#date').prop('readonly', true);
        //     $('#remark').prop('readonly', true);
        //     $('#recuser').prop('readonly', true);

        //     search_datalist(rowData.RECNO);
        //     $("#myModal").modal("show");
        // });

        // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
        $(".modal .btn-secondary, .modal .btn-close").click(function() {
            $("#myModal").modal("hide"); // ปิดกล่องโมดอล
        });

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



        ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////
        var viewstatus = 'F';
        $("#idForm").submit(function(event) {
            event.preventDefault();
            if (viewstatus == 'T') {
                if (datasave == "save") {
                    if ($('#drawno').val() == '') {
                        Swal.fire(
                            'กรุณากรอกชื่อ Drawno',
                            'ไม่สามารถบันทึกได้',
                            'error'
                        )
                        return false
                    } else if ($('#recuser').val() == '') {
                        Swal.fire(
                            'กรุณากรอกชื่อ ผู้บันทึก',
                            'ไม่สามารถบันทึกได้',
                            'error'
                        )
                        return false
                    }

                }
                AlertSave();
            }
        });

        var paramhd;
        database_server()
        async function database_server() {
            try {
                const jsonResponse = await fetch('ajax/fecth_getoneitem_mysql.php', {
                    method: 'POST',
                    body: set_formdata('select_draw'),
                });

                if (!jsonResponse.ok) {
                    $('.loading').hide();
                    throw new Error('Error sending data to server');
                }
                const jsonDataMain = await jsonResponse.json();
                console.log(jsonDataMain.datamain)
                await detailtable.clear().rows.add(jsonDataMain.datamain).draw();
                onprocess = false;
                $('.loading').hide();
            } catch (error) {
                console.error(error);
            }
        }


        /////////////////////////////////////////////////////////////// INSERT AND UPDATE ///////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////// SAVE //////////////////////////////////////////////////////////////
        // function SaveData() {
        //     $.ajax({
        //         url: encodedURL_Insert,
        //         type: "POST",
        //         data: set_formdata('save'),
        //         dataSrc: '',
        //         contentType: false,
        //         processData: false,
        //         cache: false,
        //         beforeSend: function() {},
        //         complete: function() {},
        //         success: function(response) {
        //             save_json = JSON.parse(response);
        //             // console.log(save_json)
        //             // console.log( save_json.status  )
        //             table.ajax.reload();
        //             if (save_json.status == 'success') {
        //                 Swal.fire({
        //                     title: "บันทึกแล้ว",
        //                     text: "ข้อความที่คุณต้องการแสดง",
        //                     icon: "success",
        //                     buttons: ["OK"],
        //                     dangerMode: true,
        //                 }).then(function(willRedirect) {
        //                     if (willRedirect) {
        //                         $('#myModal').modal('hide');
        //                     }
        //                 });
        //                 setTimeout(function() {
        //                     swal.close(); // ปิด SweetAlert
        //                     $('#myModal').modal('hide');
        //                 }, 2000);
        //                 /////////////////////////////////
        //             } else if (save_json.status == 'none') {
        //                 // console.log('ซ้ำ')
        //                 Swal.fire(
        //                     'เกิดปัญหาในการบันทึก',
        //                     JSON.parse(response).message,
        //                     'error'
        //                 )
        //             } else {
        //                 Swal.fire(
        //                     'เกิดปัญหาในการบันทึก',
        //                     JSON.parse(response).message,
        //                     'error'
        //                 )
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.log('error')
        //             console.error(error);
        //         }
        //     });
        // }
        // ////////////////////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////////////
        // function UpdateData() {
        //     $.ajax({
        //         url: encodedURL_Update,
        //         type: "POST",
        //         data: set_formdata('update'),
        //         dataSrc: '',
        //         contentType: false,
        //         processData: false,
        //         cache: false,
        //         beforeSend: function() {},
        //         complete: function() {},
        //         success: function(response) {
        //             save_json = JSON.parse(response);
        //             if (save_json.status == 'success') {
        //                 // console.log(save_json)
        //                 table.ajax.reload();
        //                 Swal.fire({
        //                     title: "บันทึกแล้ว",
        //                     text: "ข้อความที่คุณต้องการแสดง",
        //                     icon: "success",
        //                     buttons: ["OK"],
        //                     dangerMode: true,
        //                 }).then(function(willRedirect) {
        //                     // willRedirect คือค่า boolean ที่บอกว่าผู้ใช้เลือก OK (true) หรือยกเลิก (false)
        //                     if (willRedirect) {
        //                         // ถ้าผู้ใช้เลือก OK ให้เปลี่ยนหน้าไปยัง "datatable_activity.php"
        //                         $('#myModal').modal('hide');
        //                     }
        //                 });
        //                 /////////////////////////////////
        //             } else if (save_json.status == 'none') {
        //                 // console.log('ซ้ำ')
        //                 Swal.fire(
        //                     'เกิดปัญหาในการบันทึก',
        //                     JSON.parse(response).message,
        //                     'error'
        //                 )
        //             } else {
        //                 Swal.fire(
        //                     'เกิดปัญหาในการบันทึก',
        //                     // response.message,
        //                     JSON.parse(response).message,
        //                     'error'
        //                 )
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.log('error')
        //             console.error(error);
        //         }
        //     });
        // }

        // ////////////////////////////////////////////////////////////// Modified //////////////////////////////////////////////////////////////
        // function ModifiedData() {
        //     $.ajax({
        //         url: encodedURL_Modifi,
        //         type: "POST",
        //         data: set_formdata('modified'),
        //         dataSrc: '',
        //         contentType: false,
        //         processData: false,
        //         cache: false,
        //         beforeSend: function() {},
        //         complete: function() {},
        //         success: function(response) {
        //             save_json = JSON.parse(response);
        //             if (save_json.status == 'success') {
        //                 console.log(save_json)
        //                 table.ajax.reload();
        //                 Swal.fire({
        //                     title: "บันทึกแล้ว",
        //                     text: "ข้อความที่คุณต้องการแสดง",
        //                     icon: "success",
        //                     buttons: ["OK"],
        //                     dangerMode: true,
        //                 }).then(function(willRedirect) {
        //                     // willRedirect คือค่า boolean ที่บอกว่าผู้ใช้เลือก OK (true) หรือยกเลิก (false)
        //                     if (willRedirect) {
        //                         // ถ้าผู้ใช้เลือก OK ให้เปลี่ยนหน้าไปยัง "datatable_activity.php"
        //                         $('#myModal').modal('hide');
        //                     }
        //                 });
        //                 /////////////////////////////////
        //             } else if (save_json.status == 'none') {
        //                 // console.log('ซ้ำ')
        //                 Swal.fire(
        //                     'เกิดปัญหาในการบันทึก',
        //                     JSON.parse(response).message,
        //                     'error'
        //                 )
        //             } else {
        //                 Swal.fire(
        //                     'เกิดปัญหาในการบันทึก',
        //                     // response.message,
        //                     JSON.parse(response).message,
        //                     'error'
        //                 )
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.log('error')
        //             console.error(error);
        //         }
        //     });
        // }

        // var modify = 'F';
        // var checknewvalue = '';
        ////////////////////////////////////////////////////////////// set_formdata //////////////////////////////////////////////////////////////
        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            // var dateValue = $('#date').val();
            /// id ,param ///
            paramhd = {
                recno: recno_edit,
                customer: $('#custname').val(),
                drawno: $('#drawno').val(),
                revno: $('#revno').val(),
                partname: $('#partname').val(),
                recdate: $('#date').val() ? moment($('#date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                remark: $('#remark').val(),
                createdby: $('#createuser').val(),
                modifiedby: $('#recuser').val(),
            };

            if (conditionsformdata == "select_draw") {
                formData.append('queryId001', 'SEL_DRAWING');
                formData.append('condition', '000');
                formData.append('tableData', JSON.stringify([]));
            } else if (conditionsformdata == "select") {
                formData.append('queryIdHD', 'EDSEL_DRAWING');
                formData.append('condition', 'RECNO000');
                formData.append('tableData', JSON.stringify([paramhd]));
            } else if (conditionsformdata == "save") {
                formData.append('queryId001', 'IND_DRAWING');
                formData.append('condition', '003_INDRAWING');
                formData.append('tableData', JSON.stringify([paramhd]));
            } else if (conditionsformdata == "update") {
                formData.append('queryIdHD', 'UPD_DRAWING');
            } else if (conditionsformdata == "modified") {
                formData.append('queryIdHD', 'MOUPD_DRAWING');
                formData.append('modifyIdHD', 'IND_DRAWING');
                formData.append('conditionmain', 'I_DRAW');
            } else {
                // กรณีอื่น ๆ
                // other cases
            }
            formData.append('checkData', 'CHECK_DRAWING');
            formData.append('checkCondition', 'CHECK_DRAWING');

            // formData.append('checkname', 'CHECK_DRAWING');
            // formData.append('checkvalue', 'T');
            // formData.append('checknewvalue', $('#drawno').val());
            // formData.append('checkoldvalue', checkoldvalue);
            // formData.append('queryIdDT', '');
            // formData.append('condition', 'NONE');
            // formData.append('uploadnamedb', 'drawing');
            // formData.append('uploadolddb', $uploadolddb);
            // formData.append('modify', modify);
            // formData.append('modifycondition', 'draw');
            // formData.append('paramhd', JSON.stringify(paramhd));
            ////////////////
            return formData;
        }

        ////////////////////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////////////
        class CRUDManager {
            constructor(url, action) {
                this.url = url;
                this.action = action;
            }

            async performCRUD() {
                try {
                    console.log('save')
                    await CRUDSQL(this.url, this.action);
                    $("#myModal").modal("hide");
                } catch (error) {
                    console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
                }
            }
        }

        function AlertSave() {
            Swal.fire({
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
            }).then((result) => {
                if (result.isConfirmed) {
                    let url_data
                    let action_data
                    if (datasave == "save") {
                        // SaveData();
                        url_data = "ajax/fecth_post_indrawing.php";
                        action_data = "save"
                    } else if (datasave == "update") {
                        UpdateData();
                    } else if (datasave == "delete") {
                        DeleteData();
                    } else if (datasave == "modified") {
                        ModifiedData();
                    } else {
                        // Handle other cases or show an error message
                    }
                    const crudManager = new CRUDManager(url_data, action_data)
                    crudManager.performCRUD();

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'ยกเลิก',
                        'ยังไม่มีการบันทึก',
                        'error'
                    )
                }
            })
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        var search_cont = 0;
        var checkoldvalue = '';

        function search_datalist(search_senddata) {
            console.log(search_senddata)
            $('#custname').val(search_senddata[0].CUSTOMER);
            $('#drawno').val(search_senddata[0].DRAWNO);
            checkoldvalue = search_senddata[0].DRAWNO;
            $('#revno').val(search_senddata[0].REVNO);
            $('#partname').val(search_senddata[0].PARTNAME);
            $('#date').val(moment(search_senddata[0].RECDATE).format('DD/MM/YYYY') !== 'Invalid date' ? moment(search_senddata[0].RECDATE).format('DD/MM/YYYY') : '');
            $('#remark').val(search_senddata[0].REMARK);

            $('#createuser').val(search_senddata[0].CREATEDBY);
            $('#recuser').val(search_senddata[0].MODIFIEDBY);
            // console.log(json_searchdatalist)
            // recno_edit = json_searchdatalist[0].RECNO
            // $('#code').val(json_searchdatalist[0].EMPNO)
            // $('#namereal').val(json_searchdatalist[0].EMPNAME)
            // $('#namenick').val(json_searchdatalist[0].EMPNICK)
            // $('#login').val(json_searchdatalist[0].LOGIN)
            // $('#password').val(json_searchdatalist[0].PASS)
            // $.ajax({
            //     url: encodedURL_Select,
            //     data: {
            //         queryId: 'EDSEL_DRAWING',
            //         params: {
            //             RECNO: search_senddata
            //         },
            //         condition: 'mix',
            //     },
            //     dataSrc: '',
            //     success: function(response) {
            //         json_searchdatalist = JSON.parse(response).data;

            //         recno_edit = json_searchdatalist[0].RECNO
            //         $('#custname').val(json_searchdatalist[0].CUSTOMER);
            //         $('#drawno').val(json_searchdatalist[0].DRAWNO);
            //         checkoldvalue = json_searchdatalist[0].DRAWNO;
            //         $('#revno').val(json_searchdatalist[0].REVNO);
            //         $('#partname').val(json_searchdatalist[0].PARTNAME);
            //         $('#date').val(moment(json_searchdatalist[0].RECDATE).format('DD/MM/YYYY') !== 'Invalid date' ? moment(json_searchdatalist[0].RECDATE).format('DD/MM/YYYY') : '');
            //         $('#remark').val(json_searchdatalist[0].REMARK);

            //         $('#createuser').val(json_searchdatalist[0].CREATEDBY);
            //         $('#recuser').val(json_searchdatalist[0].MODIFIEDBY);
            //         // console.log(json_searchdatalist)
            //         // recno_edit = json_searchdatalist[0].RECNO
            //         // $('#code').val(json_searchdatalist[0].EMPNO)
            //         // $('#namereal').val(json_searchdatalist[0].EMPNAME)
            //         // $('#namenick').val(json_searchdatalist[0].EMPNICK)
            //         // $('#login').val(json_searchdatalist[0].LOGIN)
            //         // $('#password').val(json_searchdatalist[0].PASS)

            //     },
            //     error: function(xhr, status, error) {
            //         console.error(error);
            //     }
            // });
        }


        const CRUDSQL = async (url, status_sql) => {
            const apiUrl = url;
            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    body: set_formdata(status_sql), // ใช้ FormData เป็นข้อมูลที่จะส่ง
                });

                if (!response.ok) {
                    throw new Error('เกิดข้อผิดพลาดในการส่งข้อมูล');
                }

                const data = await response.json();
                console.log(data)
                if (status_sql === 'save') {
                    console.log('save')
                    await Swal.fire({
                        title: "บันทึกแล้ว",
                        text: "ข้อมูลถูกบันทึก",
                        icon: "success",
                        buttons: ["OK"],
                        dangerMode: true,
                    });
                    await database_server();
                } else if (status_sql === 'select') {
                    await search_datalist(data.datamain);
                } else if (status_sql === 'update') {
                    await Swal.fire({
                        title: "แก้ไขแล้ว",
                        text: "ข้อมูลถูกแก้ไข",
                        icon: "success",
                        buttons: ["OK"],
                        dangerMode: true,
                    });
                    await database_server();
                }
            } catch (error) {
                // จัดการข้อผิดพลาด
                console.error(error);
            }
        };

        ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
        $('#backhis').click(function() {
            window.location = 'main.php';
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////


    });
</script>

</html>