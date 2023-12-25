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
    <link href="dashboard.css" rel="stylesheet">
</head>

<body>
    <?php include("0_dbheader.php"); ?>
    <div class="container- ">
        <div class="row">
            <?php include("0_sidebar.php"); ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <form id="idForm" method="POST">
                    <section>
                        <div class="row pt-2 mb-2">
                            <div class="col-md-12">
                                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                    <div class="col p-4 d-flex flex-column position-static">
                                        <div class="row">
                                            <h3>สแกนรายการ</h3>
                                        </div>
                                        <hr>
                                        <h3>สรุปผล</h3>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text c_activity">รหัส:</span>
                                                    <input type="number" class="form-control inputreadonly" id="recno" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text c_activity">ชื่อ:</span>
                                                    <input type="text" class="form-control inputreadonly" id="name" placeholder="ชื่อ" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text ">จำนวนเหลือ:</span>
                                                    <input type="number" class="form-control inputreadonly" id="qaun" placeholder="ป้อนจำนวน" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                                    <label class="form-check-label" for="inlineRadio1">เบิกสินค้า</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                                                    <label class="form-check-label" for="inlineRadio2">คืนสินค้า</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row  mb-2">
                            <div class="col-md-12">
                                <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                                    <div class="col p-4 d-flex flex-column position-static">
                                        <div class="row">
                                            <h3>รายการสินค้า</h3>
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
                    </section>
                </form>
            </main>
        </div>
    </div>
</body>
<div class="loading" style="display: none;"></div>
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
        ////////////////////////////////////////////////////
        // var Param = [{
        //     recno: -1,
        // }];

        var Param = [{
            recno: -1,
        }];


        //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
        var tabledatahd = $('#table_datahd').DataTable({
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
        });

        class DataFetcher {
            constructor() {

            }
            async ProssParamCustomize(status) {
                try {
                    if (true == status) {
                        const recnoValue = getRecnoFromURL();
                        Param[0].recno = recnoValue;
                        $('#recno').val(recnoValue);
                    }
                    // ทำสิ่งที่คุณต้องการทำหลังจาก ProssParamCustomize เสร็จ
                } catch (error) {
                    console.error(error);
                }
            }
            async fetchData(url, section, status) {
                try {
                    // ดึงข้อมูล  จากเซิร์ฟเวอร์
                    await this.ProssParamCustomize(status);
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


        // ใช้งาน class
        // ใช้งาน class
        const dataFetcher = new DataFetcher();
        dataFetcher.fetchData('ajax/new_fecth_oitem_fb.php', 'select', true).then(async (jsonDataHD) => {
            // ในที่นี้คุณสามารถใช้ jsonDataHD ได้
            // console.log(jsonDataHD.data[0][0]);
            await search_datalist(jsonDataHD.data[0][0]);
            await tabledatahd.clear().rows.add([]).draw();
        }).catch((error) => {
            console.error(error);
        }).finally(() => {
            $('.loading').hide();
        });


        // ดึงค่า recno จาก URL
        function getRecnoFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('recno');
        }


        apidata = [{
            method: null,
            queryID: null,
            condition: null,
            listdata: null
        }]

        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            if (conditionsformdata == "select") {
                apidata[0].method = "GET";
                apidata[0].queryID = "IDSEL_INVENT";
                apidata[0].condition = "RECNO000";
                apidata[0].listdata = Param;
                // formData.append('apidata', "SEL_INVENT_DR");
                // formData.append('condition', "RECNO000");
            } else {}
            formData.append('apidata', JSON.stringify(apidata));
            console.log(apidata)
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
        function search_datalist(data) {
            console.log(data)
            const fieldMappings = {
                name: 'PRODNAME',
                qaun: 'QUAN',
            };

            const data_list = data;
            Object.entries(fieldMappings).forEach(([elementId, fieldName]) => {
                // ถ้า data_list[fieldName] เป็น null หรือ undefined ให้กำหนดค่าเป็น ''
                const fieldValue = data_list[fieldName] ?? '';
                $(`#${elementId}`).val(fieldValue);
            });
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////


    });
</script>

</html>