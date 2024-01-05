<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="assets/js/color-modes.js"></script>

    <?php
    // session_start();
    // if (!isset($_SESSION["RECNO"])) {
    //     header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    //     exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    // }
    include("0_headcss.php");
    ?>
    <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
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
    <?php
    include("0_dbheader.php");
    ?>
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
                                            <h2>สแกนรายการ</h2>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selectradio" id="withdraw" value="O">
                                                    <label class="form-check-label" for="withdraw">เบิกสินค้า</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selectradio" id="receive" value="I">
                                                    <label class="form-check-label" for="receive">รับสินค้า</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pt-2">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group input-daterange">
                                                    <span class="input-group-text">เริ่มต้น</span>
                                                    <input type="text" class="form-control" id="datedocno">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pt-2">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text ">เลขที่ใบสินค้า:</span>
                                                    <input type="text" class="form-control" id="docno" placeholder="">
                                                </div>
                                            </div>
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
                                                    <span class="input-group-text c_activity">ราคาต้น:</span>
                                                    <input type="text" class="form-control inputreadonly" id="psell" placeholder="0.00" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text c_activity">ราคาขาย:</span>
                                                    <input type="text" class="form-control inputreadonly" id="pcost" placeholder="0.00" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text ">จำนวนเหลือ:</span>
                                                    <input type="number" class="form-control inputreadonly" id="constqaun" placeholder="ป้อนจำนวน" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text ">จำนวนขอ:</span>
                                                    <input type="number" class="form-control " id="qaunreq" placeholder="ใส่จำนวน" value="1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text ">ยอดเบิก/รับ:</span>
                                                    <input type="number" class="form-control " id="qauntotal" placeholder="ใส่จำนวน" value="1">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- <div class="row  mb-2">
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
                        </div> -->
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
        var datasave = '';
        ////////////////////////////////////////////////////
        var ParamHead = [{
            recno: -1,
            status: -1,
            io: "",
            reqtype: 0,
            docno: "",
            docdate: "",
        }];
        var ParamDetail = [{
            recno: -1,
            status: "",
            corp: 1,
            invreqhd: 0,
            reqtype: 0,
            io: "",
            refdochd: "",
            refdocdt: "",
            lineno: 0,
            itemno: 1,
            invent: -1,
            quanord: 0,
            quandly: 0,
            listunit: ""
        }];
        var ParamInvent;
        var sqlinvent = '';
        var  max_on;
        ////////////////////////////////////////////////////
        $('input[type=radio][name=selectradio]').change(function() {
            ParamDetail[0].io = ParamHead[0].io = this.value;
            if (this.value == 'I') {
                ParamHead[0].reqtype = ParamDetail[0].reqtype = 104;
                max_on = max_data['doc_i'];
                ParamHead[0].docno = max_on;
                $('#docno').val(max_on);
                sqlinvent = 'IAD_INVENT';
            } else if (this.value == 'O') {
                ParamHead[0].reqtype = ParamDetail[0].reqtype = 4;
                max_on = max_data['doc_o'];
                ParamHead[0].docno = max_on;
                $('#docno').val(max_on);
                sqlinvent = 'IDE_INVENT';
            }
        });

        function proessendcontinue(data){
            let max_no;
            if(data == 'I'){
                max_data.doc_i = incrementFraction(max_data.doc_i);
                max_no = max_data.doc_i;
                ParamHead[0].docno = max_no;
            } else 
            {
                max_data.doc_o = incrementFraction(max_data.doc_o);
                max_no = max_data.doc_o;
                ParamHead[0].docno = max_no;
            }
            $("#docno").val(max_no);
            $("#qaunreq").val(0);
            $("#qauntotal").val(0);
        }

        $("#datedocno").datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true,
            clearBtn: true
        }).datepicker("setDate", 'now');

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        class DataFetcher {
            constructor() {

            }
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
                    let message = '';
                    if ($('#datedocno').val() === "") {
                        message = 'กรุณากรอกวันหยุด';
                        Swal.fire('ยกเลิก', message, 'error');
                        return false;
                    }
                    if (ParamHead[0].io === undefined || ParamHead[0].io === "") {
                        message = 'กรุณาเลือกการเบิก/รับสินค้า';
                        Swal.fire('ยกเลิก', message, 'error');
                        return false;
                    }

                    if (isNaN(ParamDetail[0].quanord) || isNaN(ParamDetail[0].quandly) || ParamDetail[0].quanord === 0 || ParamDetail[0].quandly === 0) {
                        message = 'กรุณากรอกจำนวน';
                        Swal.fire('ยกเลิก', message, 'error');
                        return false;
                    } else if (ParamDetail[0].quanord < ParamDetail[0].quandly) {
                        message = 'กรุณากรอกจำนวนขอมากกว่ายอดรับ';
                        Swal.fire('ยกเลิก', message, 'error');
                        return false;
                    }


                    return true;
                } catch (error) {
                    console.error(error);
                }
            }

            async ParamCustomize() {
                try {
                    const recnoValue = getRecnoFromURL();
                    $('#recno').val(recnoValue);
                    ParamHead[0].recno = parseInt(recnoValue);
                    ParamHead[0].docdate = moment($('#datedocno').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');

                    ParamDetail[0].quanord = parseInt($('#qaunreq').val());
                    ParamDetail[0].quandly = parseInt($('#qauntotal').val());

                    if (ParamDetail[0].quanord === ParamDetail[0].quandly) {
                        ParamHead[0].status = ParamDetail[0].status = 'D';
                    } else {
                        ParamHead[0].status = ParamDetail[0].status = 'A';
                    }
                    ////////////////
                    ParamInvent = ParamDetail.map(function(item) {
                        return {
                            recno: item.invent,
                            quan: item.quandly,
                        }
                    });

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
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#idForm").submit(function(e) {
            event.preventDefault();
            var clickedButtonName = e.originalEvent.submitter.name;

            dataFetcher.ParamCustomize()
                .then(async () => {
                    set_formdata('add')
                    processstatus = await dataFetcher.ProcessAlert();
                    if (processstatus) {
                        const crudstatus = await dataFetcher.AlertSave();
                        if (crudstatus) {
                            $('.loading').show();
                            let prosscessdata = await dataFetcher.fetchData('ajax/new_fecth_fbdata.php', 'add', true);
                            await proessendcontinue(ParamHead[0].io);
                        }
                    }
                })
                .catch((error) => {
                    console.error(error);
                })
                .finally(() => {
                    $('.loading').hide();
                });


        });

        //////////////////////////////////////////////////////////////// TABLE  ////////////////////////////////////////////////////////////////
        // var tabledatahd = $('#table_datahd').DataTable({
        //     fixedColumns: true,
        //     scrollX: true,
        //     columns: [{
        //             data: null,
        //             render: function(data, type, row, meta) {
        //                 return meta.row + 1;
        //             }
        //         },
        //         {
        //             data: 'CODE',
        //         },
        //         {
        //             data: 'PRODNAME',
        //         },
        //         {
        //             data: 'QUAN',
        //         },
        //         {
        //             data: 'QTYMIN',
        //         },
        //         {
        //             data: 'UNITNAME',
        //         },
        //         {
        //             data: 'TYPENAME',
        //         },
        //     ],
        //     columnDefs: [{
        //         "visible": false,
        //         "targets": [0]
        //     }, ],
        // });


        // ใช้งาน class
        var max_data;
        const dataFetcher = new DataFetcher();
        dataFetcher.ParamCustomize().then(async (processstatus) => {
            const jsonDataHD = await dataFetcher.fetchData('ajax/new_fecth_oitem_fb.php', 'select', true);
            await search_datalist(jsonDataHD.data[0][0]);
            max_data = {
                doc_i: incrementFraction(jsonDataHD.data[1][0]['DOCNO_I']),
                doc_o: incrementFraction(jsonDataHD.data[1][0]['DOCNO_O']),
            }
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



        function createNewApidata() {
            return [{
                method: null,
                queryID: null,
                condition: null,
                tbanme: null,
                listdata: null
            }];
        }

        var apidata;

        function set_formdata(conditionsformdata) {
            apidata = createNewApidata();

            var formData = new FormData();
            if (conditionsformdata == "select") {

                apidata[0].method = "GET";
                apidata[0].queryID = "IDSEL_INVENT";
                apidata[0].condition = "RECNO000";
                apidata[0].tbanme = "0000";
                apidata[0].listdata = ParamHead;

                apidata.push({
                    method: "GET",
                    queryID: "SELMAX_INVREQHD",
                    condition: "0000",
                    tbanme: "0000",
                    listdata: [null]
                });

            } else if (conditionsformdata == "add") {
                apidata[0].method = "POSTHEAD1";
                apidata[0].queryID = "IND_INVREQHD";
                apidata[0].condition = "001_INVREQHD";
                apidata[0].tbanme = "0088";
                apidata[0].listdata = ParamHead;

                apidata.push({
                    method: "POSTHEAD2",
                    queryID: "IND_INVREQDT",
                    condition: "001_INVREQDT",
                    tbanme: "0089",
                    listdata: ParamDetail
                });

                apidata.push({
                    method: "UPDATA",
                    queryID: sqlinvent, // sqlinvent
                    condition: "001_QUAN",
                    tbanme: "0000",
                    listdata: ParamInvent
                });

            } else {}
            formData.append('apidata', JSON.stringify(apidata));
            console.log(apidata);
            ////////////////
            return formData;
        }

        ////////////////////////////////////////////////// miscellaneous //////////////////////////////////////////////////
        function search_datalist(data) {
            console.log(data)
            const fieldMappings = {
                name: 'PRODNAME',
                constqaun: 'QUAN',
                pcost: 'COSTAMT',
                psell: 'SALEAMT'
            };

            // ParamHead[1].invent = parseInt(recnoValue);
            const data_list = data;
            Object.entries(fieldMappings).forEach(([elementId, fieldName]) => {
                const fieldValue = data_list[fieldName] ?? '';
                $(`#${elementId}`).val(fieldValue);

            });

            const ParamDetailMappings = {
                invent: 'RECNO',
                listunit: 'LISTUNIT',
            };
            Object.keys(ParamDetailMappings).forEach(field => {
                ParamDetail[0][field] = data[ParamDetailMappings[field]];
            });
        }

        function incrementFraction(fraction) {
            const [numerator, denominator] = fraction.split('/').map(Number);
            // const incrementedNumerator = numerator + 1;
            const incrementedDenominator = denominator + 1;
            const result = `${numerator}/${incrementedDenominator}`;
            return result;
        }

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>

</html>