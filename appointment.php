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
    </style>

    <form id="idForm" method="POST">
        <section>
            <div class="container-fluid">
                <div class="row pt-3">
                    <h2>ตารางนัดหมาย</h2>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12-sm col-md-6 col-lg-6">
                        <div class="mb-3">
                            <button id="addtable" type="button" class="btn btn-primary">เพิ่ม</button>
                        </div>
                    </div>

                    <div class="col-sm-12-sm col-md-6 col-lg-6">
                        <div class="mb-3">
                            <button id="sumall" type="button" class="btn btn-primary">สรุปตาราง</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12-sm col-md-6 col-lg-6">
                        <div class="mb-3">
                            <button id="save" type="submit" class="btn btn-primary">save</button>
                        </div>
                    </div>

                    <div class="col-sm-12-sm col-md-6 col-lg-6">
                        <div class="mb-3">
                            <button id="clear" type="button" class="btn btn-primary">ลบออกหมด</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <table id="detailtable" class="nowrap table table-striped table-bordered" width='100%'>
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <!-- <th>RECNO</th> -->
                                <th>ชื่อบริษัท</th>
                                <th>ผู้ติดต่อ</th>
                                <th width='13%'>เบอร์โทร</th>
                                <th>รายละเอียด</th>
                                <th width='8%'>วันที่นัด</th>
                                <th width='8%'>วันที่แจ้ง</th>
                                <th>ลบ</th>
                                <!-- <th width='8%'>วันที่นัด</th>
                                <th width='8%'>วันที่แจ้ง</th>
                                <th width='3%'>ลบ</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- สร้างเนื้อตารางด้วย JavaScript -->
                        </tbody>
                    </table>
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

    </form>

</body>
<?php include("0_footerjs.php"); ?>
<!-- <script src="js/dtcolumn.js"></script> -->


<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });



        var detailtable = $('#detailtable').DataTable({

            "paging": false,
            "info": false,
            "searching": false,
            "ordering": false,
            scrollX: true,
            order: [
                // [3, 'desc'],
            ],
            "columnDefs": [{
                    "width": "3%",
                    "targets": [0, 7]
                }, // คอลัมน์ที่ 0 (No.)
                {
                    "width": "15%",
                    "targets": 3
                }, // คอลัมน์ที่ 3 (เบอร์โทร)
            ],
            rowCallback: function(row, data) {},
        });

        var counter = 0;
        const TableAdd = () => {
            counter++;
            const newRow = detailtable.row.add([
                counter,
                // `<input type="text" class="company-input form-control align-middle" required/>`,
                `<input type="text" class="company-input form-control align-middle" />`,
                `<input type="text" class="contact-input form-control align-middle" />`,
                `<input type="text" class="tel-input form-control align-middle"  />`,
                ` <textarea class="form-control detail-input" style="width: 450px;" rows="1" ></textarea>`,
                `     <div class="date datepicker_get" >
                    <input type="text" class="form-control date-input" style="width: 140px;" />
                    <span class="input-group-append">
                    </span>
                </div>`,
                `     <div class="date  datepicker_get" >
                    <input type="text" class="form-control date-input"  style="width: 140px;"  />
                    <span class="input-group-append">
                    </span>
                </div>`,

                `<button type="button" class="btn btn-danger delete-row ">ลบ</button>`
            ]).draw(false).node();

            $(newRow).attr('id', `row${counter}`); //tr

            // console.log(newRow)
            $(newRow).find('.datepicker_get').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                todayHighlight: true,
                autoclose: true
            });
        };

        $('#detailtable').on('click', '.delete-row', function() {
            counter--;
            detailtable.row($(this).closest('tr')).remove().draw();
            detailtable.column(0).nodes().each(function(cell, i) {
                var cellData = detailtable.cell(cell).data();
                detailtable.cell(cell).data(i + 1).draw();
            });
        });


        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            formData.append('name', $('#name').val());
            /// upload ///

            formData.append('fileToUpload', '');
            $uploadolddb = '';
            /////////////

            var dateValue = $('#date').val();
            /// id ,param ///
            paramhd = {};
            // var paramhd = null;
            // เพิ่มอาร์เรย์ paramhd เข้าไปใน FormData และแปลงเป็น JSON ก่อน

            if (conditionsformdata == "save") {
                // ประมวลผลเพิ่มข้อมูล
                // process to insert data
                formData.append('queryIdHD', 'IND_APPPOINTMENT');
            } else if (conditionsformdata == "delete") {
                // ประมวลผลลบข้อมูล
                // process to delete data
                formData.append('queryIdHD', 'XXXXX');
            } else if (conditionsformdata == "update") {
                // ประมวลผลอัพเดทข้อมูล
                // process to update data
                formData.append('queryIdHD', 'UPD_DRAWING');
            } else if (conditionsformdata == "modified") {
                // ประมวลผลอัพเดทข้อมูล
                // process to update data
                formData.append('queryIdHD', 'MOUPD_DRAWING');
                formData.append('modifyIdHD', 'IND_DRAWING');
                formData.append('conditionmain', 'I_DRAW');
            } else {
                // กรณีอื่น ๆ
                // other
            }


            // let exam = [
            //     {name: "123"},
            //     {name: "bbb"}
            // ];
            // let exam = [{NAME: "dddd"},[ HEE: "dddd"]];
            // ////////////// CHECK //////////////
            // formData.append('checkname', 'CHECK_DRAWING');
            // formData.append('checkvalue', 'T');
            // formData.append('checknewvalue', $('#drawno').val());
            // formData.append('checkoldvalue', checkoldvalue);
            // ////////////// CHECK //////////////

            // formData.append('queryIdDT', '');
            // formData.append('condition', 'I_DOC');
            // formData.append('uploadnamedb', 'activityhd');
            // formData.append('uploadolddb', $uploadolddb);
            // formData.append('modify', modify);
            console.log(JSON.stringify(tableData))
            formData.append('tableData', JSON.stringify(tableData));
            formData.append('paramhd', JSON.stringify(paramhd));
            ////////////////
            return formData;
        }


        $('#clear').on('click', function() {
            // ทำงานเพิ่มโค้ดเพิ่มเติมหลังจากล้างตาราง (ถ้ามี)
            // เช่น บันทึกข้อมูลหรือการประมวลผลเพิ่มเติม
            if (counter > 0) {
                deleteLastRow();
                // clearTable(); // เรียกใช้ฟังก์ชันเพื่อล้างข้อมูล
            }
        });
        const clearTable = () => {
            detailtable.clear().draw();
            counter = 0; // รีเซ็ตค่า counter
        };

        // สร้างฟังก์ชันเพื่อลบแถวสุดท้าย
        const deleteLastRow = () => {
            const rowCount = detailtable.rows().count();
            if (rowCount > 0) {
                detailtable.row(rowCount - 1).remove().draw();
                counter--;
            }
        };

        $("#idForm").submit(function(event) {
            event.preventDefault();
            datatable_generetor();
            let url = 'ajax/crud_insert.php'
            if (process == 'T') {
                AlertSave(url)
            }
        });



        // $('#save').click(function() {

        //     $("#idForm").submit();
        // });
        $('#sumall').click(function() {
            datatable_generetor();
            console.log(tableData)
        });

        $('#addtable').click(function() {
            TableAdd()
        });

        // var tableData = [];
        // var row = [];




        var process = 'F';
        var tableData = [];

        function datatable_generetor() {
            tableData = [];
            process = 'T';
            if (detailtable.rows().count() > 0) {

                $('#detailtable tbody tr').each(function() {
                    let CompanyValue = $(this).find('td:eq(1) .company-input').val();
                    let contactValue = $(this).find('td:eq(2) .contact-input').val(); // คอลัมน์ที่ 2
                    let telValue = $(this).find('td:eq(3) .tel-input').val(); // คอลัมน์ที่ 3
                    let detailValue = $(this).find('td:eq(4) .detail-input').val(); // คอลัมน์ที่ 4
                    let dateActValue = $(this).find('td:eq(5) .date-input').val(); // คอลัมน์ที่ 5
                    let dateWarnValue = $(this).find('td:eq(6) .date-input').val(); // คอลัมน์ที่ 6
                    // tableData.push([CompanyValue, contactValue, telValue]);

                    // tableData.push([
                    //     CompanyValue,
                    //     contactValue,
                    //     telValue,
                    //     detailValue,
                    //     dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                    //     dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                    // ]);

                    tableData.push({
                        name: CompanyValue,
                        contact: contactValue,
                        tel: telValue,
                        detail: detailValue,
                        dateAct: dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                        dateWarn: dateWarnValue ? moment(dateWarnValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                    });


                    let statusValue = $(this).find('td:eq(4)').text();
                    if (statusValue.trim() === 'T') {
                        process = 'F';
                    }

                });
            } else {
                // ถ้าตารางว่าง
                process = 'F'
                tableData = [];
                // Swal.fire({
                //     title: 'ตารางว่าง',
                //     html: '<img src="doc/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>แกไม่มีสิทธ์ลงข้อมูล</h4>',
                //     // text: 'ตอนนี้ กดได้ เฉยๆ ยังไม่มีอะไรหลอก',
                //     icon: 'warning',
                //     confirmButtonText: 'OK'
                // });
                console.log('ตารางว่าง');
            }
        }
        // $(function() {

        // });

        //////////////////////////////////////////////////////////// INSERT ////////////////////////////////////////////////////////////
        const IUDSQL = (url) => {
            const apiUrl = 'ajax/crud_insert.php';

            fetch(apiUrl, {
                    method: 'POST',
                    body: set_formdata('save'), // ใช้ FormData เป็นข้อมูลที่จะส่ง
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
                    console.log(data);
                })
                .catch((error) => {
                    // จัดการข้อผิดพลาด
                    console.error(error);
                    alert('error');
                });
        };

        var message_alert = "คุณจะเปลี่ยนกลับไม่ได้!";
        //////////////////////////////////////////////////////////// AlertSave ////////////////////////////////////////////////////////////
        function AlertSave(url) {
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
                    IUDSQL(url);
                    // if (datasave == "save") {
                    //     SaveData();
                    // } else if (datasave == "update") {
                    //     UpdateData();
                    // } else if (datasave == "delete") {
                    //     DeleteData();
                    // } else {
                    //     // Handle other cases or show an error message
                    // }
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

        // $('#detailtable').on('click', '.edit-row', function() {
        //     var row = $(this).closest('tr');
        //     var nameCell = row.find('td:eq(2)');
        //     var callCell = row.find('td:eq(3)');
        //     var contactValue = nameCell.text();
        //     var telValue = callCell.text();


        //     nameCell.html('<input type="text" class="name-input form-control" value="' + contactValue + '" />');
        //     callCell.html('<input type="text" class="call-input form-control" value="' + telValue + '" />');

        //     row.find('td:eq(4)').html('T');

        //     // ทำลายปุ่ม "แก้ไข"
        //     row.find('.edit-row').remove();

        //     // สร้างปุ่ม "บันทึก" และ "ยกเลิก"
        //     var saveButton = '<button type="button" class="btn btn-success save-row">บันทึก</button>';
        //     var cancelButton = '<button type="button" class="btn btn-danger cancel-edit">ยกเลิก</button>';
        //     row.find('td:eq(5)').html(saveButton + ' ' + cancelButton);
        // });

        // $('#detailtable').on('click', '.save-row', function() {
        //     var row = $(this).closest('tr');
        //     var contactValue = row.find('.name-input').val();
        //     var telValue = row.find('.call-input').val();

        //     // ทำการบันทึกข้อมูลในแถวนี้ (อาจต้องใช้ AJAX เพื่อบันทึกข้อมูลลงในฐานข้อมูล)
        //     // ในตัวอย่างนี้เราจะแสดงข้อมูลใน input fields เหมือนเดิม
        //     row.find('td:eq(2)').html(contactValue);
        //     row.find('td:eq(3)').html(telValue);

        //     row.find('td:eq(4)').html('F');

        //     console.log(row.find('td:eq(1)').html())
        //     console.log(row.find('td:eq(2)').html())
        //     console.log(row.find('td:eq(3)').html())
        //     // // กลับมาแสดงปุ่ม "แก้ไข" และซ่อนปุ่ม "บันทึก" และ "ยกเลิก"
        //     // row.find('.edit-row').show();
        //     // row.find('.save-row, .cancel-edit').hide();

        //     // ทำลายปุ่ม "บันทึก" และ "ยกเลิก"
        //     row.find('.save-row .cancel-edit').remove();

        //     // สร้างปุ่ม "แก้ไข" 
        //     var editButton = '<button type="button"  class="btn btn-warning edit-row">แก้ไข</button>'
        //     row.find('td:eq(5)').html(editButton);

        // });

        // $('#detailtable').on('click', '.cancel-edit', function() {
        //     var row = $(this).closest('tr');

        //     var contactValue = row.find('.name-input').val();
        //     var telValue = row.find('.call-input').val();

        //     row.find('td:eq(4)').html('F');

        //     row.find('td:eq(2)').html(contactValue);
        //     row.find('td:eq(3)').html(telValue);
        //     // // ยกเลิกการแก้ไขและแสดงข้อมูลเดิม
        //     // row.find('.name-input').val(row.find('td:eq(2)').text());
        //     // row.find('.call-input').val(row.find('td:eq(3)').text());

        //     // ทำลายปุ่ม "บันทึก" และ "ยกเลิก"
        //     row.find('.save-row .cancel-edit').remove();

        //     // สร้างปุ่ม "แก้ไข" 
        //     var editButton = '<button type="button"  class="btn btn-warning edit-row">แก้ไข</button>'
        //     row.find('td:eq(5)').html(editButton);
        // });


        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>

</html>