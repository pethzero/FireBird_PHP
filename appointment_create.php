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
    <link href="css/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_red.css">

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

        /* .datepicker {
            border: 1px solid black;
        } */



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
    </style>

    <form id="idForm" method="POST">
        <section>
            <div class="container-fluid">
                <div class="row pt-3">
                    <h2>ตารางนัดหมาย</h2>
                </div>
                <hr>

                <!-- <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="input-group date mb-3">
                        <span class="input-group-text ">วันที่นัด :</span>
                        <input type="text" id="datepicker" class="form-control" placeholder="เลือกวันที่">
                            <span class="input-group-text bg-light d-block">
                                <i class="fa fa-calendar" id="calendar-icon"></i>
                            </span>
                        <span class="input-group-text bg-light d-block">
                                <i class="far fa-times-circle" style="color: #e10505;" id="clear-icon"></i>
                            </span>
                    </div>
                </div> -->

                <!---->

                <!-- <input type="text" id="timepicker" class="form-control" placeholder="เลือกเวลา"> -->

                <div class="createdata">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <button id="backcontent" type="button" class="  btn btn-primary">ดูนัดหมาย</button>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <button id="backhome" type="button" class=" btn btn-success  float-end me-3">กลับหน้าหลัก</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <button id="addtable" type="button" class="btn-input btn btn-primary me-3">เพิ่ม</button>
                                <button id="canceltable" type="button" class="btn-input  btn btn-danger">ยกเลิก</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group date mb-3">
                                <span class="input-group-text ">วันที่นัด :</span>
                                <input type="text" id="dateatc" class="form-control" placeholder="เลือกวันที่">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar" id="calendar-icon-dateatc"></i>
                                </span>
                                <span class="input-group-text bg-light d-block">
                                    <i class="far fa-times-circle" style="color: #e10505;" id="clear-icon-dateatc"></i>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group date mb-3">
                                <span class="input-group-text ">วันที่นัด :</span>
                                <input type="text" id="datewarn" class="form-control" placeholder="เลือกวันที่">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar" id="calendar-icon-datewarn"></i>
                                </span>
                                <span class="input-group-text bg-light d-block">
                                    <i class="far fa-times-circle" style="color: #e10505;" id="clear-icon-datewarn"></i>
                                </span>
                            </div>
                        </div>
                        <!-- <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group date mb-3">
                                <span class="input-group-text c_activity">วันที่นัด:</span>
                                <input type="text" class="form-control" id="dateatc" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div> -->

                        <!-- <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group date mb-3">
                                <span class="input-group-text ">ระบบแจ้งเตือน :</span>
                                <input type="text" class="form-control" id="datewarn" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div> -->

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text">ผู้นัด</span>
                                <input type="text" class="form-control" id="ownername" maxlength="120" value="<?php echo $_SESSION["EMPNAME"] ?>" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-end">
                        <div class="col-sm-6 col-md-4 col-lg-2">
                            <button type="submit" id="save" name='save' value="save" class="btn-input btn btn-primary float-right float-end">save</button>
                        </div>
                    </div>
                    <div class="row pt-2 table-responsive">
                        <table id="createtable" class="nowrap table table-striped table-bordered" width='100%'>
                            <thead class="thead-light">
                                <tr>
                                    <th>No.</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>รายละเอียด</th>
                                    <th>หมายเหตุ</th>
                                    <th>สถานที่นัดหมาย</th>
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>


        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-md  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">เพิ่มลูกค้า</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- เนื้อหาของ modal ไปที่นี่ -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary">บันทึก</button>
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
<script src="js/flatpickr-4.6.13.js"></script>
<script src="js/flatpickr-th.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.th.js"></script>
<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });

        var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";


        // สร้าง Flatpickr
        const commonOptions = {
            enableTime: false,
            locale: "th",
            clickOpens: true,
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
        };

        const datePicker1 = flatpickr("#dateatc", {
            ...commonOptions,
            onChange: function(selectedDates, dateStr, instance) {
                // ทำสิ่งที่คุณต้องการเมื่อเลือกวันที่ใน datePicker1
                console.log("Selected Date in datePicker1:", dateStr);
            },
        });

        const datePicker2 = flatpickr("#datewarn", {
            ...commonOptions,
            onChange: function(selectedDates, dateStr, instance) {
                // ทำสิ่งที่คุณต้องการเมื่อเลือกวันที่ใน datePicker2
                console.log("Selected Date in datePicker2:", dateStr);
            },
        });


        function setupDatePicker(datePicker, calendarIconId, clearIconId) {
            $(`#${calendarIconId}`).click(function() {
                datePicker.open();
            });

            $(`#${clearIconId}`).click(function() {
                datePicker.clear();
            });
        }
        setupDatePicker(datePicker1, "calendar-icon-dateatc", "clear-icon-dateatc");
        setupDatePicker(datePicker2, "calendar-icon-datewarn", "clear-icon-datewarn");
        //  // เพิ่มการคลิกไอคอน calendar เพื่อเปิด datepicker
        //  $("#calendar-icon-dateatc").click(function() {
        //     datePicker1.open();
        // });

        // // เพิ่มการคลิกไอคอนเคลียร์วันที่เพื่อลบค่าใน datepicker
        // $("#clear-icon-dateatc").click(function() {
        //     datePicker1.clear();
        // });

        // // เพิ่มการคลิกไอคอน calendar เพื่อเปิด datepicker
        // $("#calendar-icon-datewarn").click(function() {
        //     datePicker2.open();
        // });

        // // เพิ่มการคลิกไอคอนเคลียร์วันที่เพื่อลบค่าใน datepicker
        // $("#clear-icon-datewarn").click(function() {
        //     datePicker2.clear();
        // });



        const TimePicker = flatpickr("#timepicker", {
            enableTime: true, // เปิดใช้งานการเลือกเวลา
            noCalendar: true, // ไม่แสดงปฏิทิน
            dateFormat: "H:i", // รูปแบบวันที่และเวลาเฉพาะชั่วโมงและนาที
            time_24hr: true, // ใช้รูปแบบเวลา 24 ชั่วโมง
        });



        // $("#dateatc").datepicker({
        //     format: "dd/mm/yyyy",
        //     clearBtn: true,
        //     todayHighlight: true,
        //     autoclose: true
        // });
        // $("#datewarn").datepicker({
        //     format: "dd/mm/yyyy",
        //     clearBtn: true,
        //     todayHighlight: true,
        //     autoclose: true
        // });
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        const formatDate = (data) => {
            if (!data || data === '0000-00-00') {
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
            if (data['STATUS'] == "F") {
                if (istatus == "S") {
                    divele = `<button class="btn btn-warning btn-sm edit-row"><i class="far fa-edit"></i></button>`;
                } else {
                    divele = `<button class="btn btn-primary btn-sm view"><i class="far fa-eye"></i></button>`;
                }
            } else {
                divele = `<button type="button" class="btn btn-warning btn-sm edit-row" ><i class="far fa-edit"></i></button>`;
            }
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
        var createtable = $('#createtable').DataTable({
            "paging": false,
            "info": false,
            "searching": false,
            "ordering": false,
            "columnDefs": [{
                "width": "3%",
                "targets": [0]
                // "targets": [0, 6]
            }, ],
        });

        var selectedRow = null;
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
                    selectdata = data.datdropdown
                    console.log(selectdata);
                })
                .catch((error) => {
                    console.error(error);
                });
        }
        // getDataFromServer();
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        var counter = 0;
        const TableAdd = () => {
            counter++;
            const newRow = createtable.row.add([
                counter,
                `<input type="text" class="company-input form-control" maxlength="250" />`,
                `<textarea class="form-control detail-input" maxlength="500"  rows="1" ></textarea>`,
                ` <textarea class="form-control remark-input" maxlength="500" rows="1" ></textarea>`,
                ` <textarea class="form-control location-input" maxlength="500" rows="1" ></textarea>`,
                `<button type="button" class="btn btn-danger delete-row ">ลบ</button>`
            ]).draw(false).node();
            $(newRow).attr('id', `row${counter}`); //tr


            // เรียกใช้ Select2 บนฟิลด์ที่มีคลาส 'select2'
            // $(newRow).find('.select2').select2();

            // $(newRow).find('.datepicker_get').datepicker({
            //     format: "dd/mm/yyyy",
            //     clearBtn: true,
            //     todayHighlight: true,
            //     autoclose: true
            // });
        };
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
            // var paramhd = null;
            // เพิ่มอาร์เรย์ paramhd เข้าไปใน FormData และแปลงเป็น JSON ก่อน
            if (conditionsformdata == "save") {
                formData.append('queryIdHD', 'IND_APPPOINTMENT_NEW');
                formData.append('condition', '001_NEW');
            }
            formData.append('checkRecno', 'CHK_APPPOINTMENT');
            formData.append('checkCondition', 'DT000');
            formData.append('tableData', JSON.stringify(tableData));
            formData.append('DataEdit', JSON.stringify(DataEdit));
            formData.append('DataRemove', JSON.stringify(DataRemove));
            formData.append('paramhd', JSON.stringify(paramhd));
            ////////////////
            return formData;
        }

        $('#canceltable').on('click', function() {
            if (counter > 0) {
                clearTable(); // เรียกใช้ฟังก์ชันเพื่อล้างข้อมูล
            }
        });

        $('#companyadd').on('click', function() {
            $("#myModal").modal("show");
        });

        $('#backhome').on('click', function() {
            // $("#myModal").modal("show");
            window.location = 'main.php';
        });

        $('#backcontent').on('click', function() {
            // $("#myModal").modal("show");
            window.location = 'appointment_up.php';
        });

        // คลิกที่ปุ่ม "ยกเลิก" หรือปุ่มปิดของกล่องโมดอล
        $(".modal .btn-secondary, .modal .btn-close").click(function() {
            $("#myModal").modal("hide"); // ปิดกล่องโมดอล
        });



        const clearTable = () => {
            createtable.clear().draw();
            counter = 0; // รีเซ็ตค่า counter
        };

        // สร้างฟังก์ชันเพื่อลบแถวสุดท้าย
        const deleteLastRow = () => {
            const rowCount = createtable.rows().count();
            if (rowCount > 0) {
                createtable.row(rowCount - 1).remove().draw();
                counter--;
            }
        };


        $('#idForm').on('submit', function(e) {
            e.preventDefault(); // ป้องกันการส่ง form ไปยังหน้าอื่น
            let url = "";
            let status_sql = "";
            let clickedButtonName = e.originalEvent.submitter.name;

            if (clickedButtonName === 'save') {
                url = 'ajax/process_insert.php';
                status_sql = 'save';
                // console.log( $('#dateatc').val() ? $('#dateatc').val() : '0000-00-00')
                datatable_generetor();
                if (process == 'T') {
                    AlertSave(url, status_sql)
                }
            }
        });
        $('#addtable').click(function() {
            TableAdd()
        });
        var process = 'F';
        var tableData = [];

        function datatable_generetor() {
            tableData = [];
            process = 'T';
            if (createtable.rows().count() > 0) {
                $('#createtable tbody tr').each(function() {
                    const companyValue = $(this).find('td:eq(1) .company-input').val();
                    const detailValue = $(this).find('td:eq(2) .detail-input').val(); // คอลัมน์ที่ 2
                    const remarkValue = $(this).find('td:eq(3) .remark-input').val(); // คอลัมน์ที่ 3
                    // const locationValue = $(this).find('td:eq(4) .location-input').val();
                    const locationValue = $(this).find('td:eq(4) .location-input').val();

                    const dateActValue = $('#dateatc').val() ? $('#dateatc').val() : '0000-00-00';
                    const dateWarnValue =$('#datewarn').val() ? $('#datewarn').val() : '0000-00-00';
                    const ownername = $('#ownername').val();

                    tableData.push({
                        name: companyValue,
                        detail: detailValue,
                        remark: remarkValue,
                        // dateAct: dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00' ,
                        // dateWarn: dateWarnValue ? moment(dateWarnValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00' ,
                        dateAct: dateActValue,
                        dateWarn: dateWarnValue,
                        ownername: ownername,
                        location: locationValue
                    });
                    // console.log(tableData)
                });
            } else {
                process = 'F'
                tableData = [];
                Swal.fire({
                    title: 'ตารางว่าง',
                    html: '<img src="doc/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>แกไม่มีสิทธ์บันทึกข้อมูล</h4>',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        }
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
                    // console.log(data)
                    if (status_sql == 'save') {
                        clearTable();
                        Swal.fire({
                            title: "บันทึกแล้ว",
                            text: "ข้อมูลถูกบันทึก",
                            icon: "success",
                            buttons: ["OK"],
                            dangerMode: true,
                        }).then(function(willRedirect) {

                        });
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
                    CRUDSQL(url, status_sql);
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
        //////////////////////////////////////////////////////////// CLICK ////////////////////////////////////////////////////////////
        var DataEdit = [];
        var select_tr = null;
        var DataRemove
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
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>



</html>