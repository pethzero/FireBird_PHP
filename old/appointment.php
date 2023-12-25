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
    </style>

    <form id="idForm" method="POST">
        <section>
            <div class="container-fluid">
                <div class="row pt-3">
                    <h2>ตารางนัดหมาย</h2>
                </div>
                <hr>
                <div class="createdata">
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
                                <span class="input-group-text c_activity">วันที่นัด:</span>
                                <input type="text" class="form-control" id="dateatc" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="input-group date mb-3">
                                <span class="input-group-text ">ระบบแจ้งเตือน :</span>
                                <input type="text" class="form-control" id="datewarn" />
                                <span class="input-group-append">
                                    <span class="input-group-text bg-light d-block">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
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
                                    <!-- <th>วันที่นัด</th>
                                    <th>ระบบเแจ้ง</th> -->
                                    <th>ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row pt-2 table-responsive">
                    <table id="detailtable" class="nowrap table table-striped table-bordered" width='100%'>
                        <thead class="thead-light">
                            <tr>
                                <th>No.</th>
                                <th>ข้อมูล</th>
                                <th>ชื่อลูกค้า</th>
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


<script>
    $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });

        var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";


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
            // "scrollX": true,
            // order: [],
            "columnDefs": [{
                    "width": "3%",
                    "targets": [0]
                    // "targets": [0, 6]
                },
                // {
                //     "width": "8%",
                //     "targets": [4, 5]
                // },
                // {
                //     "width": "12%",
                //     "targets": [3]
                // },
            ],
            // rowCallback: function(row, data) {},
        });

        var selectedRow = null;
        var detailtable = $('#detailtable').DataTable({
            "info": false,
           
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
                    data: 'CUSTNAME'
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
                    "width": "6%",
                    "targets": [1]
                },
                {
                    "width": "8%",
                    "targets": [6, 7]
                },
                {
                    "width": "12%",
                    "targets": [4]
                },
                {
                    "width": "3%",
                    "targets": [8]
                },
                {
                    "orderable": false,
                    "targets": [1]
                },
                {
                    "visible": false,
                    "targets": [0]
                },
                {
                    type: 'th_date',
                    targets: [6, 7]
                },
               
            ],
            order: [[6, 'desc']],
            rowCallback: function(row, data) {
                // var api = this.api();
                // api.rows().every(function(rowIdx, tableLoop, rowLoop)
                // {
                // //   var data = this.data();
                // //   var variableT = data.STATUS; // แทน yourVariable ด้วยชื่อตัวแปรที่คุณต้องการตรวจสอบ
                //   var row = api.row(rowIdx).node();
                // //   $(row).addClass('table-secondary'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
                

                // //   if (variableT === 'A') {
                // //     $(row).addClass('table-secondary'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
                // //   }
                // //   else{
                // //     $(row).addClass('table-danger'); // แทน your-class ด้วยชื่อคลาสที่คุณต้องการเพิ่มให้กับแถว
                // //   }
                // });
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
                    // ทำอะไรกับข้อมูลที่ได้รับหลังจาก POST สำเร็จ
                    // console.log(data)
                    selectdata = data.datdropdown
                    console.log(selectdata);
                    // // เรียกใช้ Select2 บนฟิลด์ที่มีคลาส 'select2'
                    // const select2Inputs = $('.select2');

                    // // วนลูปผ่านทุกฟิลด์ Select2 และเติมข้อมูลลงในแต่ละฟิลด์
                    // select2Inputs.each(function(index) {
                    //     const select2Input = select2Inputs[index];

                    //     // เติมข้อมูลใน Select2
                    //     datdropdown.forEach(item => {
                    //         $(select2Input).append(new Option(item.text, item.id, false, false));
                    //     });

                    //     // อัพเดท Select2 เพื่อให้ข้อมูลแสดงผลให้เห็น
                    //     $(select2Input).trigger('change');
                    // });



                    detailtable.clear().rows.add(data.datasql).draw();
                })
                .catch((error) => {
                    // จัดการข้อผิดพลาด
                    console.error(error);
                });
        }
        // เรียกใช้งานฟังก์ชัน getDataFromServer เพื่อดึงข้อมูลเมื่อคุณต้องการ
        getDataFromServer();
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        var counter = 0;
        const TableAdd = () => {
            counter++;
            const newRow = createtable.row.add([
                counter,
                `<input type="text" class="company-input form-control" maxlength="250" />`,
                // `<select class="company-input form-control select2" maxlength="250"></select>`,
                ` <textarea class="form-control detail-input" maxlength="500"  rows="2" ></textarea>`,
                ` <textarea class="form-control remark-input" maxlength="500" rows="2" ></textarea>`,
                // `<div class="date datepicker_get" >
                //     <input type="text" class="form-control date-input"/>
                //     <span class="input-group-append">
                //     </span>
                // </div>`,
                // `<div class="date  datepicker_get" >
                //     <input type="text" class="form-control date-input" />
                //     <span class="input-group-append">
                //     </span>
                // </div>`,
                `<button type="button" class="btn btn-danger delete-row ">ลบ</button>`
            ]).draw(false).node();
            $(newRow).attr('id', `row${counter}`); //tr


            // เรียกใช้ Select2 บนฟิลด์ที่มีคลาส 'select2'
            $(newRow).find('.select2').select2();

            $(newRow).find('.datepicker_get').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                todayHighlight: true,
                autoclose: true
            });
        };
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        // ฟังก์ชันที่ใช้ในการดึงข้อมูล
        // function fetchDataAndPopulateSelect2() {
        //     // ดึงข้อมูลโดยใช้ fetch (สมมติว่า API ของคุณอยู่ที่ /api/data)
        //     fetch('/api/data')
        //         .then(response => response.json())
        //         .then(data => 
        //         {
        //             // เรียกใช้ Select2 บนฟิลด์ที่มีคลาส 'select2'
        //             const select2Inputs = $('.select2');

        //             // วนลูปผ่านทุกฟิลด์ Select2 และเติมข้อมูลลงในแต่ละฟิลด์
        //             select2Inputs.each(function(index) {
        //                 const select2Input = select2Inputs[index];

        //                 // เติมข้อมูลใน Select2
        //                 data.forEach(item => {
        //                     $(select2Input).append(new Option(item.text, item.id, false, false));
        //                 });

        //                 // อัพเดท Select2 เพื่อให้ข้อมูลแสดงผลให้เห็น
        //                 $(select2Input).trigger('change');
        //             });
        //         });
        // }
        // เรียกใช้ฟังก์ชัน fetchDataAndPopulateSelect2 เมื่อต้องการดึงและเติมข้อมูล
        // fetchDataAndPopulateSelect2();


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
                formData.append('queryIdHD', 'IND_APPPOINTMENT');
                formData.append('condition', '001');
            } else if (conditionsformdata == "delete") {
                formData.append('queryIdHD', 'DLT_APPPOINTMENT');
                formData.append('condition', 'RECNO000');
            } else if (conditionsformdata == "update") {
                formData.append('queryIdHD', 'UPD_APPPOINTMENT');
                formData.append('condition', '002');
            } else if (conditionsformdata == "modified") {
                formData.append('queryIdHD', 'MOUPD_DRAWING');
                formData.append('modifyIdHD', 'IND_DRAWING');
                formData.append('condition', 'I_DRAW');
            } else if (conditionsformdata == "select") {
                formData.append('queryIdHD', 'SELECT_APPPOINTMENT');
                formData.append('condition', 'NULL');
                ////////////////////////////////////////////////////
                formData.append('queryDropDown', 'SELECT_CUST');
            } else {
                // กรณีอื่น ๆ
                // other
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

        $('#canceltable').on('click', function() {
            if (counter > 0) {
                clearTable(); // เรียกใช้ฟังก์ชันเพื่อล้างข้อมูล
            }
        });


        $('#companyadd').on('click', function() {
            $("#myModal").modal("show");
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
            // ตรวจสอบว่าปุ่มที่ถูกคลิกคือ "save" หรือ "edit"
            // var saveButton = $('#save');
            // var editButton = $('#edit');
            let url = "";
            let status_sql = "";
            console.log(e.originalEvent.submitter)

            var clickedButtonName = e.originalEvent.submitter.name;

            if (clickedButtonName === 'save') {
                let url = 'ajax/process_insert.php';
                let status_sql = 'save';
                datatable_generetor();
                if (process == 'T') {
                    AlertSave(url, status_sql)
                }
            } else if (clickedButtonName === 'editsave') {
                // saveRemoveButton() 
                let url = 'ajax/process_update.php';
                let status_sql = 'update';
                AlertSave(url, status_sql)
            } else if (clickedButtonName === 'removerow') {
                // saveRemoveButton() 
                let url = 'ajax/process_delete.php';
                let status_sql = 'delete';
                AlertSave(url, status_sql)
                // console.log('remove')
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
                    let companyValue = $(this).find('td:eq(1) .company-input').val();
                    let detailValue = $(this).find('td:eq(2) .detail-input').val(); // คอลัมน์ที่ 2
                    let remarkValue = $(this).find('td:eq(3) .remark-input').val(); // คอลัมน์ที่ 3
                    // let dateActValue = $(this).find('td:eq(4) .date-input').val(); // คอลัมน์ที่ 4
                    // let dateWarnValue = $(this).find('td:eq(5) .date-input').val(); // คอลัมน์ที่ 5

                    let dateActValue = $('#dateatc').val();
                    let dateWarnValue = $('#datewarn').val();
                    let ownername = $('#ownername').val();

                    tableData.push({
                        name: companyValue,
                        detail: detailValue,
                        remark: remarkValue,
                        dateAct: dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                        dateWarn: dateWarnValue ? moment(dateWarnValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                        ownername: ownername
                    });
                    // let statusValue = $(this).find('td:eq(4)').text();
                    // if (statusValue.trim() === 'T') {
                    //     process = 'F';
                    // }
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
                console.log('ตารางว่าง');
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
                    console.log(data)
                    if (status_sql == 'save') {
                        clearTable();
                        getDataFromServer();
                        Swal.fire({
                            title: "บันทึกแล้ว",
                            text: "ข้อมูลถูกบันทึก",
                            icon: "success",
                            buttons: ["OK"],
                            dangerMode: true,
                        }).then(function(willRedirect) {

                        });
                    } else if (status_sql == 'update') {
                        if (data.status === "success") {
                            clearTable();
                            saveRemoveButton();
                            Swal.fire({
                                title: "แก้ไขแล้ว",
                                text: "ข้อมูลถูกแก้ไขเรียบร้อย",
                                icon: "success",
                                buttons: ["OK"],
                                dangerMode: true,
                            }).then(function(willRedirect) {

                            });
                        } else if (data.status === "warning") {
                            clearTable();
                            getDataFromServer();
                            Swal.fire({
                                title: 'ตรวจพบความขัดข้อง',
                                html: '<img src="doc/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>ข้อมูลมีคนลบไปแล้ว</h4>',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        }

                    } else if (status_sql == 'delete') {
                        // clearTable();
                        // RemoveRowTable()
                        if (data.status === "success") {
                            clearTable();
                            RemoveRowTable();
                            Swal.fire({
                                title: "ข้อมูลถูกลบแล้ว",
                                text: "ข้อมูลถูกลบเรียบร้อย",
                                icon: "success",
                                buttons: ["OK"],
                                dangerMode: true,
                            }).then(function(willRedirect) {

                            });
                        } else if (data.status === "warning") {
                            clearTable();
                            getDataFromServer();
                            Swal.fire({
                                title: 'ตรวจพบความขัดข้อง',
                                html: '<img src="doc/nopermission.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>ข้อมูลมีคนลบไปแล้ว</h4>',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
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
        $('#detailtable').on('click', '.edit-row', function() {
            let row = $(this).closest('tr');
            let companyCell = row.find('td:eq(1)');
            let detailCell = row.find('td:eq(2)');
            let remarkCell = row.find('td:eq(3)');
            //
            let OwnerCell = row.find('td:eq(4)');

            let dateActCell = row.find('td:eq(5)');
            let dateWarnCell = row.find('td:eq(6)');
            let companyValue = companyCell.text();
            let detailValue = detailCell.html(); // เราใช้ .html() เพื่อรับ HTML แบบที่มี <br>
            let remarkValue = remarkCell.html(); // เราใช้ .html() เพื่อรับ HTML แบบที่มี <br>

            let OwnerValue = OwnerCell.html(); // เราใช้ .html() เพื่อรับ HTML แบบที่มี <br>

            let dateActValue = dateActCell.text() === "00/00/0000" ? '' : dateActCell.text();
            let dateWarnValue = dateWarnCell.text() === "00/00/0000" ? '' : dateWarnCell.text();
            // เปลี่ยน <br> เป็น \n
            detailValue = detailValue.replace(/<br>/g, "\n");
            remarkValue = remarkValue.replace(/<br>/g, "\n");
            // สร้าง input && textarea สำหรับแก้ไขข้อมูล
            let companyInput = '<input type="text" class="company-input form-control" value="' + companyValue + '" />';
            let detailTextarea = '<textarea class="form-control detail-input" maxlength="500" >' + detailValue + '</textarea>';
            let remarkTextarea = '<textarea class="form-control remark-input" maxlength="500" >' + remarkValue + '</textarea>';

            let OwnerInput = '<input type="text" class="owner-input form-control" value="' + OwnerValue + '" />';

            let dateActInput = `<div class="date datepicker_get" >
                    <input type="text" class="form-control date-input"  value="${dateActValue}"  />
                    <span class="input-group-append">
                    </span>
                </div>`;
            let dateWarnInput = `<div class="date datepicker_get" >
                    <input type="text" class="form-control date-input"  value="${dateWarnValue}"  />
                    <span class="input-group-append">
                    </span>
                </div>`;
            // คำนวณความยาวของข้อความที่แสดงผล
            let detailTextLines = detailValue.split(/\n/).length;
            let remarkTextLines = remarkValue.split(/\n/).length;
            // กำหนดความยาวของ textarea ให้เท่ากับจำนวนบรรทัดของข้อความ
            detailTextarea = $(detailTextarea).attr('rows', detailTextLines);
            remarkTextarea = $(remarkTextarea).attr('rows', remarkTextLines);
            // แทนที่ข้อมูลใน cell ด้วย textarea
            OwnerCell.html(OwnerInput);
            companyCell.html(companyInput);
            detailCell.html(detailTextarea);
            remarkCell.html(remarkTextarea);
            dateActCell.html(dateActInput);
            dateWarnCell.html(dateWarnInput);
            // ทำลายปุ่ม "แก้ไข"
            row.find('.edit-row').remove();
            // สร้างปุ่ม "บันทึก" และ "ยกเลิก"
            var saveButton = '<button type="sumbit" name="editsave" class="btn btn-success btn-sm save-row me-2"><i class="fa-solid fa-check"></i></button>';
            var cancelButton = '<button type="button" class="btn btn-danger btn-sm cancel-edit"><i class="fa-solid fa-x"></i></button>';
            row.find('td:eq(0)').html(saveButton + ' ' + cancelButton);
            $(row).find('.datepicker_get').datepicker({
                format: "dd/mm/yyyy",
                clearBtn: true,
                todayHighlight: true,
                autoclose: true
            });
        });


        $('#detailtable').on('click', '.cancel-edit', function() {
            let row = $(this).closest('tr');
            let companyValue = row.find('td:eq(1) .company-input').val();
            let detailValue = row.find('td:eq(2) .detail-input').val(); // คอลัมน์ที่ 2
            let remarkValue = row.find('td:eq(3) .remark-input').val(); // คอลัมน์ที่ 3

            let OwnerValue = row.find('td:eq(4) .owner-input').val(); // คอลัมน์ที่ 3

            let dateActValue = row.find('td:eq(5) .date-input').val(); // คอลัมน์ที่ 4
            let dateWarnValue = row.find('td:eq(6) .date-input').val(); // คอลัมน์ที่ 5
            // detailValue.replace(/<br>/g, "\n");
            // console.log(detailValue)
            detailValue = detailValue.replace(/\n/g, '<br>');
            row.find('td:eq(1)').html(companyValue);
            row.find('td:eq(2)').html(detailValue);
            row.find('td:eq(3)').html(remarkValue);
            row.find('td:eq(4)').html(OwnerValue);
            row.find('td:eq(5)').html(dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('DD/MM/YYYY') : '00/00/0000');
            row.find('td:eq(6)').html(dateWarnValue ? moment(dateWarnValue, 'DD/MM/YYYY').format('DD/MM/YYYY') : '00/00/0000');
            // ทำลายปุ่ม "บันทึก" และ "ยกเลิก"
            row.find('.save-row .cancel-edit').remove();
            // สร้างปุ่ม "แก้ไข" 
            let editButton = '<button type="button" class="btn btn-warning btn-sm edit-row" ><i class="far fa-edit"></i></button>'
            row.find('td:eq(0)').html(editButton);
        });

        var select_tr = null;
        $('#detailtable').on('click', '.save-row', function() {
            DataEdit = [];
            let row = $(this).closest('tr');
            let rowData = $('#detailtable').DataTable().row($(this).closest('tr')).data();
            console.log(rowData.RECNO)
            // console.log(row)
            select_tr = row
            let companyValue = row.find('td:eq(1) .company-input').val();
            let detailValue = row.find('td:eq(2) .detail-input').val(); // คอลัมน์ที่ 2
            let remarkValue = row.find('td:eq(3) .remark-input').val(); // คอลัมน์ที่ 3

            let OwnerValue = row.find('td:eq(4) .owner-input').val(); // คอลัมน์ที่ 4

            let dateActValue = row.find('td:eq(5) .date-input').val(); // คอลัมน์ที่ 4
            let dateWarnValue = row.find('td:eq(6) .date-input').val(); // คอลัมน์ที่ 5
            DataEdit.push({
                recno: rowData.RECNO,
                name: companyValue,
                detail: detailValue,
                remark: remarkValue,
                dateAct: dateActValue ? moment(dateActValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                dateWarn: dateWarnValue ? moment(dateWarnValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                ownername: OwnerValue
            });
        });

        var DataRemove
        $('#detailtable').on('click', '.removerow', function() {
            DataRemove = [];
            let row = $(this).closest('tr');
            let rowData = $('#detailtable').DataTable().row($(this).closest('tr')).data();
            console.log(rowData.RECNO)
            // console.log(row)
            select_tr = row
            DataRemove.push({
                recno: rowData.RECNO,
            });
            // RemoveRowTable()
        });


        // แปลงและแสดงผลข้อมูลในคอลัมน์วันที่นัด
        function saveRemoveButton() {
            DataEdit[0].detail = DataEdit[0].detail.replace(/\n/g, '<br>')
            select_tr.find('td:eq(1)').html(DataEdit[0].name);
            select_tr.find('td:eq(2)').html(DataEdit[0].detail);
            select_tr.find('td:eq(3)').html(DataEdit[0].remark);
            select_tr.find('td:eq(4)').html(DataEdit[0].ownername);
            if (DataEdit[0].dateAct === '0000-00-00') {
                select_tr.find('td:eq(5)').html('00/00/0000');
            } else {
                select_tr.find('td:eq(5)').html(moment(DataEdit[0].dateAct, 'YYYY-MM-DD').format('DD/MM/YYYY'));
            }
            if (DataEdit[0].dateWarn === '0000-00-00') {
                select_tr.find('td:eq(6)').html('00/00/0000');
            } else {
                select_tr.find('td:eq(6)').html(moment(DataEdit[0].dateWarn, 'YYYY-MM-DD').format('DD/MM/YYYY'));
            }
            select_tr.find('.save-row .cancel-edit').remove();
            // สร้างปุ่ม "แก้ไข" 
            let editButton = '<button type="button" class="btn btn-warning btn-sm edit-row" ><i class="far fa-edit"></i></button>'
            select_tr.find('td:eq(0)').html(editButton);
        }

        function RemoveRowTable() {
            // let row = $(this).closest('tr');
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
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>

</html>