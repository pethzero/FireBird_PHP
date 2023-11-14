<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    if (!isset($_SESSION["RECNO"])) {
        header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
        exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    }
    include("0_headcss.php");
    ?>
    <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
</head>
<?php
$data_link = "";
$data_message = "";
$size = count($_GET);
$recno = null;
?>

<body>
    <?php
    include("0_header.php");
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
            /* overflow-x: scroll; */
            white-space: nowrap;
            /* overflow-y: scroll; */
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

        /* #detailtable th.no-wrap {
            white-space: normal;
            width: auto;
        } */


        /* th.detail-tr {
            width: 3000px;
        } */

        @media (min-width: 768px) {
            .custom-input-pc {
                width: 450px;
            }

            .btn-input {
                width: 120px;
            }

            /* .company-input {
                width: 400px;
            }
            .detail-input {
                width: 500px;
            } */
            /* .remark-input {
                width: 200px;
            } */

            /* .detail-input {
                width: 700px;
            }
            .remark-input {
                width: 500px;
            } */

            /* th.detail-tr {
                width: 10000px;
            }

            th.date-tr {
                width: 10000px;
            } */
            .date-input {
                width: 140px;
            }
        }

        @media (max-width: 767px) {
            .custom-input-phone {
                width: 300px;
            }

            /* th.detail-tr {
                width: 3000px !important;
            } */
            .company-input {
                width: 250px;
            }

            .detail-input {
                width: 300px;
            }

            .remark-input {
                width: 200px;
            }

            /*
            tr th.date-input {
                width: 200px !important;
            } */
            .date-input {
                width: 120px;
            }
        }

        .table-custom {
            --bs-table-color: #000;
            --bs-table-bg: #4caf50;
            --bs-table-border-color: #bacbe6;
        }

        .table-postpone {
            --bs-table-color: #000;
            /* สีของข้อความในตาราง */
            --bs-table-bg: #ff980099;
            /* สีพื้นหลังของตาราง (สีส้ม) */
            --bs-table-border-color: #bacbe6;
            /* สีเส้นขอบของตาราง */
        }

        .bg-postpone {
            background-color: #ff6600;
        }
    </style>

    <form id="idForm" method="POST">
        <section>
            <div class="container-fluid">
                <div class="row pt-3">
                    <h2>ตารางนัดหมาย</h2>
                </div>
                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <button id="backcontent" type="button" class="  btn btn-primary">เพิ่มหน้านัดหมาย</button>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <button id="backhome" type="button" class=" btn btn-success  float-end me-3">กลับหน้าหลัก</button>
                    </div>
                </div>

        <hr>


            <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="input-group date mb-3">
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                            <input type="text" class="form-control" id="datesearch" readonly />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">สถานะ:</span>
                            <select class="form-select" id="statussearch">
                                <option value="" selected>เลือก...</option>
                                <option value="ยังไม่เริ่มดำเนินการ">ยังไม่เริ่มดำเนินการ</option>
                                <option value="อยู่ระหว่างดำเนินการ">อยู่ระหว่างดำเนินการ</option>
                                <option value="รอดำเนินการ">รอดำเนินการ</option>
                                <option value="ถูกเลื่อนออกไป">ถูกเลื่อนออกไป</option>
                                <option value="เสร็จสิ้น">เสร็จสิ้น</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                        <button id='search' type="button" class="btn btn-primary">ค้นหา</button>
                        <button id="cancelsearch" type="button" class="btn btn-danger">ยกเลิก</button>
                    </div>
                </div>
                <hr>
                <div class="row pt-2 table-responsive">
                    <table id="detailtable" class="nowrap table table-striped table-bordered" width='100%'>
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>ข้อมูล</th>
                                <th>สถานะ</th>
                                <th>ชื่อลูกค้า</th>
                                <th>สถานที่</th>
                                <th>รายละเอียด</th>
                                <th>หมายเหตุ</th>
                                <th>ผู้นัด</th>
                                <th>วันที่นัด</th>
                                <th>ระบบเแจ้ง</th>
                                <th>ลบ</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-md  modal-lg modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขลูกค้า</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ลูกค้า:</span>
                                    <input type="text" class="form-control" id="cust" placeholder="ลูกค้า" maxlength="250">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">สถานะ:</span>
                                    <select class="form-select" id="status">
                                        <option value="A" selected>ยังไม่เริ่มดำเนินการ</option>
                                        <option value="I">อยู่ระหว่างดำเนินการ</option>
                                        <option value="W">รอดำเนินการ</option>
                                        <option value="D">ถูกเลื่อนออกไป</option>
                                        <option value="C">ยกเลิก</option>
                                        <option value="F">เสร็จสิ้น</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group">
                                    <span class="input-group-text c_activity">รายละเอียด:</span>
                                    <textarea id="detail" class="form-control h_textarea" rows="3" aria-label="textarea a" maxlength="500"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group">
                                    <span class="input-group-text c_activity">สถานที่:</span>
                                    <textarea id="addr" class="form-control h_textarea" rows="3" aria-label="textarea a" maxlength="500"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group">
                                    <span class="input-group-text c_activity">หมายเหตุ:</span>
                                    <textarea id="remark" class="form-control h_textarea " rows="3" aria-label="textarea a" maxlength="500"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ผู้นัดหมาย:</span>
                                    <input type="text" class="form-control" id="owner" placeholder="ผู้นัดหมาย" maxlength="120">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group date mb-3" id="datepicker">
                                    <span class="input-group-text c_activity">วันที่นัด:</span>
                                    <input type="text" class="form-control" id="dateatc" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group date mb-3" id="datepicker_warn">
                                    <span class="input-group-text ">วันที่แจ้งเตือน:</span>
                                    <input type="text" class="form-control" id="datewarn" />
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-light d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- เนื้อหาของ modal ไปที่นี่ -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" name="editmodal" class="btn btn-primary">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>


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
    <!-- <div class="loading" ></div> -->
</body>
<?php include("0_footerjs_piority.php"); ?>


<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });

        var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";

        $("#datesearch").datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            todayHighlight: true,
            autoclose: true
        });

        $("#dateatc").datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            todayHighlight: true,
            autoclose: true
        });
        $("#datewarn").datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            todayHighlight: true,
            autoclose: true
        });


        $('#search').click(function() {
            console.log('wow')
            var dateValue = $('#datesearch').val();
            if (dateValue) {
                startd = moment($('#datesearch').val(), 'DD/MM/YYYY').format('DD/MM/YYYY')
            } else {
                startd = '';
            }
            $('#detailtable').DataTable().column(8).search(startd).draw();
            $('#detailtable').DataTable().column(2).search($('#statussearch').val()).draw();
        })

        $('#cancelsearch').click(function() {
            $('#detailtable').DataTable().column(8).search('').draw();
            $('#detailtable').DataTable().column(2).search('').draw();
        })

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        const formatDate = (data) => {
            if (!data || data === '0000-00-00 00:00:00' || data === '0000-00-00') {
                return '00/00/0000'; // ถ้าค่าว่างหรือไม่ถูกต้อง ส่งค่าว่างกลับไป
            }
            const dateObj = new Date(data);
            const day = dateObj.getDate();
            const month = dateObj.getMonth() + 1;
            const year = dateObj.getFullYear();
            const formattedDate = `${(day < 10 ? '0' + day : day)}/${(month < 10 ? '0' + month : month)}/${year}`;
            return formattedDate;
        };
        const customButtonEdit = (data, type, row, istatus) => {
            let divele = "";
            // if (data['STATUS'] == "F") {
            //     if (istatus == "S") {
            //         divele = `<button class="btn btn-warning btn-sm edit-row"><i class="far fa-edit"></i></button>`;
            //     } else {
            //         divele = `<button class="btn btn-primary btn-sm view"><i class="far fa-eye"></i></button>`;
            //     }
            // } else {
            //     divele = `<button type="button" class="btn btn-warning btn-sm edit-row" ><i class="far fa-edit"></i></button>`;
            // }
            divele = `<button type="button" class="btn btn-warning btn-sm edit-row" ><i class="far fa-edit"></i></button>`;
            return divele;
        };

        const customButtonRemove = (data, type, row, istatus) => {
            let divele = "";
            // if (data['STATUS'] == "F") {
            //     if (istatus == "S") {
            //         divele = `<button class="btn btn-danger btn-sm removerow"><i class="fa fa-trash"></i></button>`;
            //     } else {
            //         divele = `<button class="btn btn-primary btn-sm view"><i class="far fa-eye"></i></button>`;
            //     }
            // } else {
            //     divele = `<button type="sumbit" class="btn btn-danger btn-sm removerow" ><i class="fa fa-trash"></i></button>`;
            // }
            divele = `<button   type="submit" id="removerow" name='removerow' value="removerow"  class="btn btn-danger btn-sm removerow" ><i class="fa fa-trash"></i></button>`;
            return divele;
        };
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        var selectedRow = null;
        var detailtable = $('#detailtable').DataTable({
            "info": false,
            order: [],
            columns: [{
                    data: 'RECNO'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return customButtonEdit(data, type, row, userlevel);
                    }
                },
                {
                    data: 'STATUS',
                    render: function(data) {
                        if (data == 'A') {
                            return '<span class="badge bg-secondary" style="font-size: 15px;">ยังไม่เริ่มดำเนินการ</span>'
                        } else if (data == 'I') {
                            return '<span class="badge bg-info  text-dark" style="font-size: 15px;">อยู่ระหว่างดำเนินการ</span>';
                        } else if (data == 'W') {
                            return '<span class="badge bg-warning  text-dark" style="font-size: 15px;">รอดำเนินการ</span>';
                        } else if (data == 'D') {
                            return '<span class="badge bg-postpone " style="font-size: 15px;">ถูกเลื่อนออกไป</span>';
                        } else if (data == 'C') {
                            return '<span class="badge bg-danger " style="font-size: 15px;">ยกเลิก</span>';
                        } else if (data == 'F') {
                            return '<span class="badge bg-success" style="font-size: 15px;">เสร็จสิ้น</span>'
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'CUSTNAME'
                },
                {
                    data: 'ADDR'
                },
                {
                    data: 'DETAIL',
                    render: function(data, type, row) {
                        if (type === 'display' && data) {
                            return data.replace(/\n/g, '<br>');
                        }
                        return data;
                    }
                },
                {
                    data: 'REMARK'
                },
                {
                    data: 'OWNERNAME'
                },
                {
                    data: 'STARTD',
                    render: formatDate
                },
                {
                    data: 'WARND',
                    render: formatDate
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return customButtonRemove(data, type, row, userlevel);
                    }
                },
            ],
            "columnDefs": [{
                    "orderable": false,
                    "targets": [1]
                },
                {
                    "visible": false,
                    "targets": [0]
                },
                {
                    "width": "3%",
                    "targets": [1]
                },
                {
                    className: 'dt-center text-center align-middle',
                    targets: [2]
                },
                // {
                //     "width": "8%",
                //     "targets": [6, 7]
                // },
                // {
                //     "width": "12%",
                //     "targets": [4]
                // },
                // {
                //     "width": "3%",
                //     "targets": [8]
                // },
                // {
                //     type: 'th_date',
                //     targets: [6, 7]
                // }
            ],
            rowCallback: function(row, data) {
                var api = this.api();
                api.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    var data = this.data();
                    var variableT = data.STATUS; // แทน yourVariable ด้วยชื่อตัวแปรที่คุณต้องการตรวจสอบ
                    var row = api.row(rowIdx).node();
                    //   $(row).addClass('table-secondary'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว

                    if (variableT === 'F') {
                        $(row).addClass('table-success'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
                    } else if (variableT === 'C') {
                        $(row).addClass('table-danger'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
                    } else if (variableT === 'D') {
                        $(row).addClass('table-postpone'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
                    }
                });
            },
        });


        var selectdata;
        // สร้างฟังก์ชันสำหรับดึงข้อมูลจากแหล่งข้อมูล
        function getDataFromServer() {
            // กำหนด URL ของแหล่งข้อมูลที่ต้องการดึงข้อมูลฃ
            fetch('ajax/process_select.php', {
                    method: 'POST',
                    body: set_formdata('select'), // ใช้ FormData เป็นข้อมูลที่จะส่ง
                })
                .then((response) => {
                    // ทำงานเมื่อรับการตอบกลับจากเซิร์ฟเวอร์
                    if (response.ok) {
                        return response.json(); // แปลงข้อมูล JSON จากการตอบกลับ
                    } else {
                        throw new Error('เกิดข้อผิดพลาดในการส่งข้อมูล');
                    }
                })
                .then((data) => {
                    detailtable.clear().rows.add(data.datasql).draw();
                    $('.loading').hide();
                })
                .catch((error) => {
                    // จัดการข้อผิดพลาด
                    console.error(error);
                });
        }
        // เรียกใช้งานฟังก์ชัน getDataFromServer เพื่อดึงข้อมูลเมื่อคุณต้องการ
        getDataFromServer();
        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        // ฟังก์ชันที่ใช้ในการดึงข้อมูล

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        $('#createtable').on('click', '.delete-row', function() {
            counter--;
            createtable.row($(this).closest('tr')).remove().draw();
            createtable.column(0).nodes().each(function(cell, i) {
                var cellData = createtable.cell(cell).data();
                createtable.cell(cell).data(i + 1).draw();
            });
        });

        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            /// id ,param ///
            paramhd = {};
            if (conditionsformdata == "update") {
                formData.append('queryIdHD', 'UPD_APPPOINTMENT_NEW');
                formData.append('condition', '002_UPAPP');
            } else if (conditionsformdata == "delete") {
                formData.append('queryIdHD', 'DLT_APPPOINTMENT');
                formData.append('condition', 'RECNO000');
            } else if (conditionsformdata == "select") {
                formData.append('queryIdHD', 'SELECT_APPPOINTMENT');
                formData.append('condition', 'NULL');
                ////////////////////////////////////////////////////
                formData.append('queryDropDown', 'SELECT_CUST');
            }

            formData.append('checkRecno', 'CHK_APPPOINTMENT');
            formData.append('checkCondition', 'RECNO000');
            formData.append('tableData', JSON.stringify(tableData));
            formData.append('DataEdit', JSON.stringify(DataEdit));
            formData.append('DataRemove', JSON.stringify(DataRemove));
            formData.append('paramhd', JSON.stringify(paramhd));
            ////////////////
            return formData;
        }


        // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
        $(".modal .btn-secondary, .modal .btn-close").click(function() {
            $("#myModal").modal("hide"); // ปิดกล่องโมดอล
        });


        $('#idForm').on('submit', function(e) {
            e.preventDefault(); // ป้องกันการส่ง form ไปยังหน้าอื่น
            // ตรวจสอบว่าปุ่มที่ถูกคลิกคือ "save" หรือ "edit"
            let url = "";
            let status_sql = "";
            console.log(e.originalEvent.submitter)

            var clickedButtonName = e.originalEvent.submitter.name;
            if (clickedButtonName === 'editmodal') {

                let url = 'ajax/process_update.php';
                let status_sql = 'update';
                DataEditValue()
                console.log(DataEdit)
                AlertSave(url, status_sql)

            } else if (clickedButtonName === 'removerow') {
                let url = 'ajax/process_delete.php';
                let status_sql = 'delete';
                AlertSave(url, status_sql)
            }
        });

        var process = 'T';
        var tableData = [];


        //////////////////////////////////////////////////////////// CRUDSQL ////////////////////////////////////////////////////////////
        const CRUDSQL = (url, status_sql) => {
            const apiUrl = url;
            fetch(apiUrl, {
                    method: 'POST',
                    body: set_formdata(status_sql), // ใช้ FormData เป็นข้อมูลที่จะส่ง
                })
                .then((response) => {
                    // ทำงานเมื่อรับการตอบกลับจากเซิร์ฟเวอร์
                    if (response.ok) {
                        return response.json(); // แปลงข้อมูล JSON จากการตอบกลับ
                    } else {
                        throw new Error('เกิดข้อผิดพลาดในการส่งข้อมูล');
                    }
                })
                .then((data) => {
                    // ทำอะไรกับข้อมูลที่ได้รับหลังจาก POST สำเร็จ
                    console.log(data)
                    if (status_sql == 'update') {
                        if (data.status === "success") {
                            getDataFromServer();

                            Swal.fire({
                                title: "แก้ไขแล้ว",
                                text: "ข้อมูลถูกแก้ไขเรียบร้อย",
                                icon: "success",
                                buttons: ["OK"],
                                dangerMode: true,
                            }).then(function(willRedirect) {
                                $("#myModal").modal("hide"); // ปิดกล่องโมดอล
                            });


                        } else if (data.status === "warning") {
                            getDataFromServer();
                            Swal.fire({
                                title: 'ตรวจพบความขัดข้อง',
                                html: '<img src="doc/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>ข้อมูลมีคนลบไปแล้ว</h4>',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            $("#myModal").modal("hide"); // ปิดกล่องโมดอล
                        }

                    } else if (status_sql == 'delete') {
                        if (data.status === "success") {
                            // RemoveRowTable();
                            getDataFromServer();
                            Swal.fire({
                                title: "ข้อมูลถูกลบแล้ว",
                                text: "ข้อมูลถูกลบเรียบร้อย",
                                icon: "success",
                                buttons: ["OK"],
                                dangerMode: true,
                            }).then(function(willRedirect) {

                            });
                        } else if (data.status === "warning") {
                            getDataFromServer();
                            Swal.fire({
                                title: 'ตรวจพบความขัดข้อง',
                                html: '<img src="doc/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>ข้อมูลมีคนลบไปแล้ว</h4>',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            $("#myModal").modal("hide"); // ปิดกล่องโมดอล
                        }
                    }
                })
                .catch((error) => {
                    // จัดการข้อผิดพลาด
                    console.error(error);
                });
        };
        var message_alert = "คุณจะเปลี่ยนกลับไม่ได้!";
        //////////////////////////////////////////////////////////// AlertSave ////////////////////////////////////////////////////////////
        function AlertSave(url, status_sql) {
            Swal.fire({
                title: 'คุณแน่ใจแล้วใช่ไหม',
                text: message_alert,
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
                    $('.loading').show();
                    CRUDSQL(url, status_sql);
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'ยกเลิก',
                        'ยังไม่มีการบันทึก',
                        'error'
                    )
                }
            })
        }
        //////////////////////////////////////////////////////////// CLICK ////////////////////////////////////////////////////////////
        var DataEdit = [];
        var recno_data;
        $('#detailtable').on('click', '.edit-row', function() {
            let rowData = $('#detailtable').DataTable().row($(this).closest('tr')).data();
            recno_data = rowData.RECNO
            $('#cust').val(rowData.CUSTNAME);
            $('#status').val(rowData.STATUS);
            $('#detail').val(rowData.DETAIL);
            $('#addr').val(rowData.ADDR);
            $('#remark').val(rowData.REMARK);
            $('#owner').val(rowData.OWNERNAME);
            $('#dateatc').val(moment(rowData.STARTD, 'YYYY-MM-DD').isValid() ? moment(rowData.STARTD, 'YYYY-MM-DD').format('DD/MM/YYYY') : '');
            $('#datewarn').val(moment(rowData.WARND, 'YYYY-MM-DD').isValid() ? moment(rowData.WARND, 'YYYY-MM-DD').format('DD/MM/YYYY') : '');
            $("#myModal").modal("show");
        });

        function DataEditValue() {
            DataEdit = [];
            let companyValue = $('#cust').val();
            let statusValue = $('#status').val();
            let detailValue = $('#detail').val();
            let addrValue = $('#addr').val();
            let remarkValue = $('#remark').val();
            let OwnerValue = $('#owner').val();
            let dateActValue = $('#dateatc').val();
            let dateWarnValue = $('#datewarn').val();

            DataEdit.push({
                recno: recno_data,
                name: companyValue,
                status: statusValue,
                detail: detailValue,
                address: addrValue,
                remark: remarkValue,
                dateAct: dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                dateWarn: dateWarnValue ? moment(dateWarnValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                ownername: OwnerValue
            });
            console.log(dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00')
        }



        var select_tr = null;
        var DataRemove
        $('#detailtable').on('click', '.removerow', function() {
            DataRemove = [];
            let row = $(this).closest('tr');
            let rowData = $('#detailtable').DataTable().row($(this).closest('tr')).data();
            select_tr = row
            DataRemove.push({
                recno: rowData.RECNO,
            });
            // RemoveRowTable()
        });


        // แปลงและแสดงผลข้อมูลในคอลัมน์วันที่นัด
        function RemoveRowTable() {
            $('#detailtable').DataTable().row(select_tr).remove().draw();
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////////  SELECT 2  ////////////////////////////////////////////////////
        function createSelect2(selector, data, gettextselect) {
            return $(selector).select2({
                data: data,
                theme: 'bootstrap-5',
                dropdownParent: $('#myModal .modal-content'),
                // dropdownParent: $(this).parent(),
                matcher: matchCustom_ajax,
                templateSelection: function(selected) {
                    if (selected.id !== '') {
                        if (selected.id == 0) {
                            return gettextselect;
                        }
                        return selected.text;
                    }
                    return '';
                },
                templateResult: function(result) {
                    if (!result.id) {
                        return result.text;
                    }
                    var $result = $('<span></span>');
                    $result.text("รหัส" + result.title + ":" + result.text);
                    if (result.id == 0) {
                        $result.text(gettextselect);
                        return $result;
                    } else {
                        return $result;
                    }
                }
            });
        }

        $('#backhome').on('click', function() {
            // $("#myModal").modal("show");
            window.location = 'main.php';
        });

        $('#backcontent').on('click', function() {
            // $("#myModal").modal("show");
            window.location = 'appointment_create.php';
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>

</html>