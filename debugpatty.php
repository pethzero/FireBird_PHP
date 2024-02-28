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
    if ($_SESSION["USERLEVEL"] !== "S") {
        if ($_SESSION["PERMISSION"] === "T") {
            include("systempermisson.php");
            webpermissions($_SESSION["EMPNO"], 'account');
        } else {
            header("Location: 404.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
            exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
        }
    }
    include("0_headcss.php");
    ?>
    <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <style>
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
            <div class="loading" style="display: none;"></div>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <form id="idForm" method="POST">
                    <div class="row mb-2 pt-2">
                        <div class="col-md-12">
                            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                <div class="col p-4 d-flex flex-column position-static">
                                    <section>
                                        <h2>ยกยอด (เฉพาะเบิกเงิน)</h2>
                                        <div class="row">
                                            <div class="col-12">
                                                <table id="table_datahd" class="nowrap table table-striped table-bordered align-middle " width='100%'>
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>ลำดับ</th>
                                                            <th>ข้อ</th>
                                                            <th>วันที่</th>
                                                            <th>เงินรับเข้า</th>
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
                                            <div class="modal-dialog modal-sm modal-md modal-lg ">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">แก้ไขเบิกเงินสด<span id='story' class="badge"></span></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text c_activity">จำนวนเงิน:</span>
                                                                        <input type="number" class="form-control" id="addamt" placeholder="ป้อนจำนวน"  >
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="modal-footer">
                                                                <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                                            </div>
                                                        </div>
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
<?php include("0_footerjs_piority.php"); ?>
<script src="js/systemdtcolum.js"></script>
<script src="js/system_components.js"></script>
<script>
    $(document).ready(function() {
        /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });

        var recno = null;
        var tablejsondata;
        var selectedRow = null;
        var selectedRecno = null;
        var datasave = '';
        var recno_edit;

        database_server()
        async function database_server() {
            try {
                $('.loading').show();
                const jsonResponse = await fetch('ajax/fecth_one_fbitem.php', {
                    method: 'POST',
                    body: set_formdata('select_all'),
                });
                if (!jsonResponse.ok) {
                    $('.loading').hide();
                    throw new Error('Error sending data to server');
                }
                const jsonDataMain = await jsonResponse.json();
                // console.log(jsonDataMain.datasql)
                await detailtable.clear().rows.add(jsonDataMain.datasql).draw();
                // await detailtable.clear().rows.add([]).draw();

                $('.loading').hide();
            } catch (error) {
                console.error(error);
            }
        }
        //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
        var data_array = [];
        var detailtable = $('#table_datahd').DataTable({
            scrollX: true,
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                }, {
                    data: null,
                    render: function(data, type, row) {
                        return customButtonEdit(data, type, row, 'edit', 'แก้ไข');
                    }
                },
                {
                    data: 'DOCDATE',
                    render: function(data, type, row) {
                        return formatDate(data);
                    }
                },
                // {
                // data: 'DOCDATE',
                // },
                {
                    data: 'ADDAMT',
                },
            ],
            columnDefs: [{
                    "visible": false,
                    "targets": 0
                },
                {
                    type: 'th_date',
                    targets: 2
                }
            ],
            order: [
                [0, 'desc'],
            ],
            dom: 'frtip',
            buttons: [],
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
                    if (selectedRecno !== data.RECNO) {
                        selectedRecno = data.RECNO;
                    }
                });
            },
        });
        $('#table_datahd').on('click', '.edit', function() {
            var rowData = $('#table_datahd').DataTable().row($(this).closest('tr')).data();
            $('#ok').removeClass('btn-primary').addClass('btn-danger').text('บันทึกแก้ไข');
            $('#story').removeClass('bg-secondary').addClass('bg-danger').text('แก้ไข');
            //
            datasave = 'update';
            recno_edit = rowData.RECNO;
            CRUDSQL('ajax/fecth_one_fbitem.php', 'select')
                .then(() => {
                    $("#myModal").modal("show");
                })
                .catch(error => {
                    console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
                });

        });
        // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
        $(".modal .btn-secondary, .modal .btn-close").click(function() {
            $("#myModal").modal("hide"); // ปิดกล่องโมดอล
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////
        $("#idForm").submit(function(event) {
            event.preventDefault();
            let url;
            if (datasave == "update") {
                url = "ajax/fecth_update_fbstandard.php";
            }
            AlertSave(url, datasave)
        });

        var paramhd;
        /////////////////////////////////////////////////////////////// INSERT AND UPDATE ///////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////// SAVE //////////////////////////////////////////////////////////////
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
                if (status_sql === 'select') {
                    await search_data(data.datasql);
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
        // ////////////////////////////////////////////////////////////// UPDATE //////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////// set_formdata //////////////////////////////////////////////////////////////
        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            formData.append('name', $('#name').val());
            paramhd = {
                recno: recno_edit,
                addamt: $('#addamt').val(),
            };
            if (conditionsformdata == "select_all") {
                formData.append('queryId001', 'PTYCASH_LIST');
                formData.append('condition', '000');
                formData.append('tableData', JSON.stringify([{}]));
            } else if (conditionsformdata == "select") {
                formData.append('queryId001', 'ID_PTYCASH_LIST');
                formData.append('condition', 'RECNO000');
                formData.append('tableData', JSON.stringify([paramhd]));
            } else if (conditionsformdata == "update") {
                formData.append('queryIdHD', 'PTYCASH_UP');
                formData.append('condition', 'ADDAMT');
                formData.append('tableData', JSON.stringify([paramhd]));
            } else {
                formData.append('queryIdHD', 'UPD_NOTIMAINTEN');
            }
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
                    await CRUDSQL(this.url, this.action);
                    $("#myModal").modal("hide");
                } catch (error) {
                    console.error('เกิดข้อผิดพลาดใน CRUDSQL:', error);
                }
            }
        }

        function AlertSave(url, datasave) {
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
                    const crudManager = new CRUDManager(url, datasave);
                    crudManager.performCRUD();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'ยกเลิก',
                        'ยังไม่มีการบันทึก',
                        'error'
                    );
                }
            });
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function search_data(json_search) {
            recno_edit = json_search[0].RECNO;
            $('#addamt').val(json_search[0].ADDAMT);
            // $('#status').val(json_search[0].STATUS);
        }


        ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////


        /////////////////////////////////////////////////////////////////////////////////////////////////////////


    });
</script>

</html>