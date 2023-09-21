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

        /* textarea {
      overflow-y: scroll;
    } */

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
                            <button id="save" type="button" class="btn btn-primary">save</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <table id="detailtable" class="nowrap table table-striped table-bordered" width='100%'>
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>RECNO</th>
                                <th>ชื่อ</th>
                                <th>เบอร์โทร</th>
                                <th>Modify</th>
                                <th>แก้ไข</th>
                                <th>ลบ</th>
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
<script src="js/dtcolumn.js"></script>


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
            scrollX: true,
            rowCallback: function(row, data) {},
        });

        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            formData.append('name', $('#name').val());
            /// upload ///

            formData.append('fileToUpload', '');
            $uploadolddb = '';
            /////////////

            var dateValue = $('#date').val();

            console.log()
            /// id ,param ///
            paramhd = {};
            // var paramhd = null;
            // เพิ่มอาร์เรย์ paramhd เข้าไปใน FormData และแปลงเป็น JSON ก่อน

            if (conditionsformdata == "save") {
                // ประมวลผลเพิ่มข้อมูล
                // process to insert data
                formData.append('queryIdHD', 'IND_DRAWING');
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
            } else{
                // กรณีอื่น ๆ
                // other
            }


            ////////////// CHECK //////////////
            formData.append('checkname', 'CHECK_DRAWING');
            formData.append('checkvalue', 'T');
            formData.append('checknewvalue', $('#drawno').val());
            formData.append('checkoldvalue', checkoldvalue);
            ////////////// CHECK //////////////

            formData.append('queryIdDT', '');
            formData.append('condition', 'I_DOC');
            formData.append('uploadnamedb', 'activityhd');
            formData.append('uploadolddb', $uploadolddb);
            formData.append('modify', modify);

            formData.append('paramhd', JSON.stringify(paramhd));
            ////////////////
            return formData;
        }

        $('#save').click(function() {
        });

        $('#addtable').click(function() {
            TableAdd(1, 'name', '00000000000')
        });

        // var tableData = [];
        // var row = [];

        var process = 'T';
        $('#sumall').click(function() {
            var columnData = [];
            process = 'T';

            if (detailtable.rows().count() > 0) {

                $('#detailtable tbody tr').each(function() {
                    var nameValue = $(this).find('td:eq(2)').text(); // คอลัมน์ที่ 2
                    var callValue = $(this).find('td:eq(3)').text(); // คอลัมน์ที่ 3
                    columnData.push([nameValue, callValue]);

                    // var statusCell = $(this).find('td:eq(4)');
                    // var statusValue = statusCell.text();
                    var statusValue = $(this).find('td:eq(4)').text();
                    if (statusValue.trim() === 'T') {
                        // statusCell.text('Yes');
                        process = 'F';
                    }

                });


                if (process == 'T') {
                    console.log('SYSTEM ON');
                } else {
                    console.log('SYSTEM OFF');
                }
                console.log(columnData);
            } else {
                // ถ้าตารางว่าง
                columnData = [];
                console.log('ตารางว่าง');
            }
        });



        // $(function() {

        // });


        var counter = 0;
        const TableAdd = (TRECNO, TNAME, TCALL) => {
            counter++;
            const newRow = detailtable.row.add([
                counter,
                TRECNO,
                TNAME + counter,
                TCALL,
                'F',
                `<button type="button" class="btn btn-warning edit-row">แก้ไข</button>`,
                `<button type="button" class="btn btn-danger delete-row">ลบ</button>`
            ]).draw(false).node();

            $(newRow).attr('id', `row${counter}`);
        };


        // function TableAdd(TRECNO, TNAME, TCALL) {
        //     counter++;
        //     var newRow = detailtable.row.add([
        //         counter,
        //         TRECNO,
        //         TNAME + counter,
        //         TCALL,
        //         'F',
        //         `<button type="button"  class="btn btn-warning edit-row">แก้ไข</button>`,
        //         '<button type="button"  class="btn btn-danger delete-row">ลบ</button>'
        //     ]).draw(false).node();

        //     $(newRow).attr('id', 'row' + counter);
        // }

        $('#detailtable').on('click', '.delete-row', function() {
            counter--;
            detailtable.row($(this).closest('tr')).remove().draw();
            detailtable.column(0).nodes().each(function(cell, i) {
                var cellData = detailtable.cell(cell).data();
                detailtable.cell(cell).data(i + 1).draw();
            });
        });


        $('#detailtable').on('click', '.edit-row', function() {
            var row = $(this).closest('tr');
            var nameCell = row.find('td:eq(2)');
            var callCell = row.find('td:eq(3)');
            var nameValue = nameCell.text();
            var callValue = callCell.text();


            nameCell.html('<input type="text" class="name-input form-control" value="' + nameValue + '" />');
            callCell.html('<input type="text" class="call-input form-control" value="' + callValue + '" />');

            row.find('td:eq(4)').html('T');

            // ทำลายปุ่ม "แก้ไข"
            row.find('.edit-row').remove();

            // สร้างปุ่ม "บันทึก" และ "ยกเลิก"
            var saveButton = '<button type="button" class="btn btn-success save-row">บันทึก</button>';
            var cancelButton = '<button type="button" class="btn btn-danger cancel-edit">ยกเลิก</button>';
            row.find('td:eq(5)').html(saveButton + ' ' + cancelButton);
        });

        $('#detailtable').on('click', '.save-row', function() {
            var row = $(this).closest('tr');
            var nameValue = row.find('.name-input').val();
            var callValue = row.find('.call-input').val();

            // ทำการบันทึกข้อมูลในแถวนี้ (อาจต้องใช้ AJAX เพื่อบันทึกข้อมูลลงในฐานข้อมูล)
            // ในตัวอย่างนี้เราจะแสดงข้อมูลใน input fields เหมือนเดิม
            row.find('td:eq(2)').html(nameValue);
            row.find('td:eq(3)').html(callValue);

            row.find('td:eq(4)').html('F');

            console.log(row.find('td:eq(1)').html())
            console.log(row.find('td:eq(2)').html())
            console.log(row.find('td:eq(3)').html())
            // // กลับมาแสดงปุ่ม "แก้ไข" และซ่อนปุ่ม "บันทึก" และ "ยกเลิก"
            // row.find('.edit-row').show();
            // row.find('.save-row, .cancel-edit').hide();

            // ทำลายปุ่ม "บันทึก" และ "ยกเลิก"
            row.find('.save-row .cancel-edit').remove();

            // สร้างปุ่ม "แก้ไข" 
            var editButton = '<button type="button"  class="btn btn-warning edit-row">แก้ไข</button>'
            row.find('td:eq(5)').html(editButton);

        });

        $('#detailtable').on('click', '.cancel-edit', function() {
            var row = $(this).closest('tr');

            var nameValue = row.find('.name-input').val();
            var callValue = row.find('.call-input').val();

            row.find('td:eq(4)').html('F');

            row.find('td:eq(2)').html(nameValue);
            row.find('td:eq(3)').html(callValue);
            // // ยกเลิกการแก้ไขและแสดงข้อมูลเดิม
            // row.find('.name-input').val(row.find('td:eq(2)').text());
            // row.find('.call-input').val(row.find('td:eq(3)').text());

            // ทำลายปุ่ม "บันทึก" และ "ยกเลิก"
            row.find('.save-row .cancel-edit').remove();

            // สร้างปุ่ม "แก้ไข" 
            var editButton = '<button type="button"  class="btn btn-warning edit-row">แก้ไข</button>'
            row.find('td:eq(5)').html(editButton);
        });


        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>

</html>