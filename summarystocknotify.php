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
    <!-- <link rel="preload" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
    <link rel="preload" href="css/fixedColumns.dataTables.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

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
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <form id="idForm" method="POST">
                    <section>
                        <div class="row pt-2 mb-2">
                            <div class="col-md-12">
                                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                    <div class="col p-4 d-flex flex-column position-static">


                                        <div class="row">
                                            <h3>รายงานใบสั่งผลิตใกล้ครบกำหนดส่งมอบภายใน 3 วัน</h3>


                                            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                                <div class="row pb-3">
                                                    <select class="form-select" id="peroid">
                                                        <option value="0">ทุกรายการ</option>
                                                        <option value="3" selected>3 วัน</option>
                                                        <option value="5">5 วัน</option>
                                                        <option value="7">7 วัน</option>
                                                        <option value="14">2 อาทิตย์</option>
                                                        <option value="30">1 เดือน</option>
                                                        <option value="60">2 เดือน</option>
                                                        <option value="90">3 เดือน</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-12">
                                                    <table id="table_datahd" class="nowrap table table-striped table-bordered    align-middle " width='100%'>
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th>ลำดับ</th>
                                                                <th> รหัสสินค้า </th>
                                                                <th> ชื่อสินค้า </th>
                                                                <th> คงเหลือ </th>
                                                                <th> ขั้นต่ำ</th>
                                                                <th> หน่วยนับ </th>
                                                                <th> ประเภทสินค้า </th>
                                                                <!-- <th> หมวดบัญชี </th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>
        </section>
        <div class="loading" style="display: none;"></div>
        </form>
        </main>
    </div>
</body>
<?php include("0_footerjs_piority.php"); ?>
<script src="js/systemdtcolum.js"></script>
<script src="js/dataTables.fixedColumns.min.js"></script>
<script>
    $(document).ready(function() {

        /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });
        $('.loading').show();

        var qid = 'STOCKNOTI'; //
        var condotion_id = 'TYPE'; //
        var datasave = '';


        //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
        var tabledatahd = $('#table_datahd').DataTable({
            // scrollCollapse: true,
            fixedColumns: true,
            scrollX: true,
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'CODE',
                },
                {
                    data: 'PRODNAME',
                },
                {
                    data: 'QUAN',
                },
                {
                    data: 'QTYMIN',
                },
                {
                    data: 'UNITNAME',
                },
                {
                    data: 'TYPENAME',
                },
            ],
            columnDefs: [{
                "visible": false,
                "targets": [0]
            }, ],
            // order: [
            //   [3, 'desc'],
            // ],
        });

       

        fecth_databased(3);
        async function fecth_databased(fdata) {
            Param = [];
            Param.push({
                type: fdata
                // datebegin: data_begin,
                // dateend: date_end
            })
            console.log(Param)
            var formData = new FormData();
            try {
                // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
                const jsonResponse = await fetch('ajax/post_fb_select_qt.php', {
                    method: 'POST',
                    body: set_formdata('select'),
                });

                if (!jsonResponse.ok) {
                    $('.loading').hide();
                    throw new Error('Error sending data to server');
                }
                jsonPush = []
                const jsonDataHD = await jsonResponse.json();
                // console.log(jsonDataHD.datasql)
                tabledatahd.clear().rows.add([]).draw();
                $('.loading').hide();
            } catch (error) {
                console.error(error);
            }
        }
        var Param;


        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            if (conditionsformdata == "select") {
                formData.append('queryIdHD', qid);
                formData.append('condition', condotion_id);
            } else {}
            formData.append('Param', JSON.stringify(Param));
            ////////////////
            return formData;
        }

        $('#idForm').on('submit', function(e) {
            e.preventDefault(); // ป้องกันการส่ง form ไปยังหน้าอื่น
            // ตรวจสอบว่าปุ่มที่ถูกคลิกคือ "save" หรือ "edit"
            let url = "";
            let status_sql = "";
            var clickedButtonName = e.originalEvent.submitter.name;
        });
        ////////////////////////////////////////////////// CHART  //////////////////////////////////////////////////
        $('#backhis').click(function() {
            window.location = 'main.php';
        });

        $('#detailhis').click(function() {
            window.location = 'datatable_invoice.php';
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////


    });
</script>



</html>