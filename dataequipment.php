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
if ($size === 0) {
    $data_link = "add";
} else if ($size === 2) {
    $urlArray = $_GET;
    $data_link = "edit";
    // $data_message = "( แก้ไข )";
    if (count($urlArray) >= 2) {
        $firstParam = array_keys($urlArray)[0];
        $secondParam = array_keys($urlArray)[1];
        $recno = $_GET['recno'];
        if ($firstParam !== "edit" || $secondParam !== "recno") {
            header("Location: 404.php");
            exit;
        }
    } else {
        header("Location: 404.php");
        exit;
    }
} else {
    header("Location: 404.php");
    exit;
}
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

    <?php
    include("connect_sql.php");
    include("sql.php");
    // include("0_fselect.php");
    ?>

    <?php

    ?>

    <form id="idForm" method="POST">
        <section>
            <div class="container">
                <div class="row pb-3">
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
                        <button id='backhis' type="button" class="btn btn-primary">กลับดูอุปกรณ์</button>
                    </div>
                </div>

                <h2 id="dataoffset">อุปกรณ์ <span id='story' class="badge"></span></h2>
                <hr>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">ชื่ออุปกรณ์:</span>
                            <input type="text" class="form-control" id="name" placeholder="ชื่ออุปกรณ์" maxlength="255">

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">ประเภท:</span>
                            <input type="text" class="form-control" id="type" placeholder="ประเภท" maxlength="255">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">รหัส:</span>
                            <input type="text" class="form-control" id="code" placeholder="รหัส" maxlength="50">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">ยี่ห้อ:</span>
                            <input type="text" class="form-control" id="model" placeholder="ยี่ห้อ" maxlength="50">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">บริษัท:</span>
                            <input type="text" class="form-control" id="cust" placeholder="ซื้อกับบริษัท" maxlength="255">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">บุคคล:</span>
                            <input type="text" class="form-control" id="cont" placeholder="ติดต่อบุคคล" maxlength="255">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">โทรศัทพ์:</span>
                            <input type="text" class="form-control" id="phone" placeholder="โทรศัทพ์" maxlength="150">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">อีเมล:</span>
                            <input type="text" class="form-control" id="email" placeholder="อีเมล" maxlength="150">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">พื้นที่:</span>
                            <input type="text" class="form-control" id="area" placeholder="พื้นที่" maxlength="255">
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text c_activity">คู่มือ:</span>
                            <input type="text" class="form-control" id="docno" placeholder="คู่มือ" maxlength="255">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">สถานะ:</span>
                                    <select class="form-select" id="status">
                                        <option value="A" selected>ปกติ</option>
                                        <option value="P">ดูแล</option>
                                        <option value="E">เสียหาย</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ความสำคัญ:</span>
                                    <select class="form-select" id="priority">
                                        <option value="0" selected>เลือก...</option>
                                        <option value="H">สูง</option>
                                        <option value="N">ปกติ</option>
                                        <option value="L">ต่ำ</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">ประกัน:</span>
                                    <input type="number" class="form-control" id="warranty" min=0 placeholder="อายุประกัน" step="1">
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text c_activity">การบำรุง:</span>
                                    <input type="number" class="form-control" id="maintenance" min=0 placeholder="จำนวนการบำรุง" step="1">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="input-group">
                        <span class="input-group-text">รายละเอียด:</span>
                        <textarea id="detail" class="form-control h_textarea" rows="3" aria-label="textarea a"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group date mb-3" id="datepicker">
                            <span class="input-group-text c_activity">วันที่ซื้อ:</span>
                            <input type="text" class="form-control" id="date" placeholder="วันที่ซื้อสินค้า" />
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group date mb-3" id="datepicker_first">
                            <span class="input-group-text c_activity">วันที่เริ่มต้น:</span>
                            <input type="text" class="form-control" id="date_first" placeholder="วันที่เริ่มต้น" />
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group date mb-3" id="datepicker_last">
                            <span class="input-group-text c_activity">ดูแลล่าสุด:</span>
                            <input type="text" class="form-control" id="date_last" placeholder="วันที่ดูแลล่าสุด" />
                            <span class="input-group-append">
                                <span class="input-group-text bg-light d-block">
                                    <i class="fa fa-calendar"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="input-group mb-3">
                            <!-- <span class="input-group-text c_activity">ผู้บันทึก:</span> -->
                            <!-- <input type="number" class="form-control" id="warranty" min=0 placeholder="อายุประกัน" step="1"> -->
                            <span class="input-group-text ">ผู้บันทึก:</span>
                            <select class="form-select" id="owner">
                            </select>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">แนบเอกสาร</label>
                        <input class="form-control" type="file" id="fileToUpload">
                    </div>
                </div>
                <button id="ok" type="submit" class="btn btn-primary">บันทึก</button>
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
        <!-- <div class="loading"> -->
    </form>

</body>
<?php include("0_footerjs.php"); ?>
<script src="js/dtcolumn.js"></script>


<script>
    $(document).ready(function() {

        var encodedURL_Select = encodeURIComponent('ajax_select_sql_mysql.php');
        var encodedURL_Insert = 'ajax/ajaxinsertnew.php';
        var encodedURL_Update = 'ajax/ajaxdbupdatemysql.php';

        $(window).keydown(function(event) {
            if (event.keyCode == 13 && !$(event.target).is('textarea')) {
                event.preventDefault();
                return false;
            }
        });

        $(function() {
            $("#datepicker").datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });

            $("#datepicker_first").datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });

            $("#datepicker_last").datepicker({
                format: "dd/mm/yyyy",
                todayHighlight: true,
                autoclose: true
            });
        });

        function matchCustom(params, data) {
            var inputText = $.trim(params.term).toLowerCase().replace(/\s/g, '');
            var optionText = data.text.toLowerCase().replace(/\s/g, '');
            if (inputText === '') {
                return data;
            }
            if (typeof data.text === 'undefined') {
                return null;
            }
            if (optionText.indexOf(inputText) > -1) {
                var modifiedData = $.extend({}, data, true);
                return modifiedData;
            }
            return null;
        }

        function matchCustom_ajax(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }
            var inputText = params.term.toLowerCase().replace(/\s/g, '');
            var optionText = data.text.toLowerCase().replace(/\s/g, '');

            var optionTitle = data.title.toLowerCase().replace(/\s/g, '');
            if (typeof data.value === 'string') {
                // ทำสิ่งที่คุณต้องการเมื่อ data.value เป็น string
                var optionValue = data.value.toLowerCase().replace(/\s/g, '');
                if (optionText.indexOf(inputText) > -1 || optionValue.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
                    return data;
                }
            } else {
                if (optionText.indexOf(inputText) > -1 || optionTitle.indexOf(inputText) > -1) {
                    return data;
                }
                // ทำสิ่งที่คุณต้องการเมื่อ data.value ไม่ใช่ string
            }

            return null;
        }
        /////////////////////////////////// INITOPEATION ///////////////////////////////////
        // var recno_cust = -1;
        // var name_cust = "";
        // var recno_cont = -1;
        // var name_cont = "";
        // var recno_tel = "";
        // var recno_email = "";
        // var recno_owner = -1;
        // var recno_nowner = "";
        // var con_list;
        // var contact;
        // var targetEmail = '';
        // var targetTel = '';


        /////////// SELECT2 VAR ////////////////
        var recno_owner = -1;
        var recno_nowner = "";
        var owner_list;
        var data_owner_name = [];
        ////////////////////////////////////////

        var recno_edit = "<?php echo $recno; ?>"
        var link = "<?php echo $data_link; ?>"
        // var recno_get = <?php echo  isset($recno) ? $recno : -1; ?>;
        Operation(link)
        //////////////////////////////////////////////////////////////////////////////////////////////
        function Operation(optdata) {
            if (optdata == "add") {
                // cust_change_process = 0
                // cust_list()
                // createSelect_contact('#cont', data_cont_name);
                select2_owner_list()
                // $('#date').val(moment(new Date()).format('DD/MM/YYYY'));
                $('#story').removeClass('bg-danger').addClass('bg-secondary').text('เพิ่ม');
            } else {
                // cust_change_process = 1
                // DataEdit(recno_edit)
                $('#story').removeClass('bg-secondary').addClass('bg-danger').text('แก้ไข');
            }
        }

        ////////////////////////////////////////////////// SAVE /////////////////////////////////////////////

        $("#idForm").submit(function(event) {
            event.preventDefault();
            AlertSave()
       
            // if (link == "edit") {
            //     AlertSave()
            // } else {
            //     AlertSave()
            // }
        });

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
                    if (link == 'edit') {
                        UpdateData()
                    } else {
                        SaveData()
                    }

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
        ///////////////////////////////////////////////////////////////// SELECT DATA //////////////////////////////////////////////////////////////////////////////////////////
        function select2_owner_list() {
            $.ajax({
                url: encodedURL_Select,
                data: {
                    queryId: 'EMPL_LIST',
                    params: null,
                    condition: 'mix',
                },
                dataSrc: '',
                success: function(response) {
                    // console.log(response)
                    owner_list = JSON.parse(response).data;
                    data_owner_name = data_json(owner_list, 'RECNO', 'EMPNO', 'EMPNAME','เลือกชื่อผู้รับผิดชอบงาน...'); // กำหนดค่าใหม่ให้กับ data_owner_name
                    createSelect2('#owner', data_owner_name,'เลือกชื่อผู้รับผิดชอบงาน...')
                    owner_process = 1;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function createSelect2(selector, data,gettextselect) {
            return $(selector).select2({
                data: data,
                theme: 'bootstrap-5',
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

        function data_json(data_list, recno_key, code_key, name_key,gettextselect) {
            var target_list = [{
                "id": 0,
                "text": gettextselect,
                "value": "0",
                "title": ""
            }];
            var existingCodes = {};
            for (var i = 0; i < data_list.length; i++) {
                var select2_recno = data_list[i][recno_key];
                var select2_code = data_list[i][code_key];
                var select2_name = data_list[i][name_key];
                if (select2_name != '') {
                    if (!existingCodes[select2_code]) {
                        if (link == "edit" && recno_owner == select2_recno) {
                            target_list.push({
                                // "id": target_list.length + 1,
                                "id": parseInt(select2_recno),
                                "text": select2_name,
                                "value": select2_recno,
                                "title": select2_code,
                                "selected": true
                            });
                        } else {
                            target_list.push({
                                // "id": target_list.length + 1,
                                "id": parseInt(select2_recno),
                                "text": select2_name,
                                "value": select2_recno,
                                "title": select2_code,
                            });
                        }

                        existingCodes[select2_code] = true;
                    }
                }
            }
            return target_list; // คืนค่า target_list กลับไป
        }

        //////////////////////////////////////////////////////////////// CHANGE //////////////////////////////////////////////////////////////// 
        var owner_process = 0;
        $("#owner").change(function() {
            // console.log($(this).select2('data')[0].value)
            if (owner_process != 0) {
                recno_owner = $(this).select2('data')[0].value;
            }
            if (recno_owner == -1) {
                recno_nowner = '';
            } else {
                recno_nowner = $(this).select2('data')[0].text;
            }
        });

        /////////////////////////////////////////////////////////////// INSERT AND UPDATE ///////////////////////////////////////////////////////////
        function SaveData() {
            $.ajax({
                url: encodedURL_Insert,
                type: "POST",
                data: set_formdata(),
                dataSrc: '',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {},
                complete: function() {},
                success: function(response) {
                    console.log(response);
                    // save_json = JSON.parse(response);
                    save_json = JSON.parse(response).status;
                    console.log(save_json);
                    if (JSON.parse(response).status == 'success') {
                        // console.log('success')
                        Swal.fire({
                            title: "บันทึกแล้ว",
                            text: "ข้อความที่คุณต้องการแสดง",
                            icon: "success",
                            buttons: ["OK"],
                            dangerMode: true,
                        }).then(function(willRedirect) {
                            // willRedirect คือค่า boolean ที่บอกว่าผู้ใช้เลือก OK (true) หรือยกเลิก (false)
                            if (willRedirect) {
                                // ถ้าผู้ใช้เลือก OK ให้เปลี่ยนหน้าไปยัง "datatable_activity.php"
                                location.href = "datatable_equipment.php";
                            }
                        });
                        setTimeout(function() {
                            swal.close(); // ปิด SweetAlert
                            location.href = "datatable_equipment.php"; // เปลี่ยนหน้าไปยัง "datatable_activity.php"
                        }, 2000);
                        /////////////////////////////////
                    } else {
                        Swal.fire(
                            'เกิดปัญหาในการบันทึก',
                            // response.message,
                            JSON.parse(response).message,
                            'error'
                        )
                    }
                },
                error: function(xhr, status, error) {
                    console.log('error')
                    console.error(error);
                }
            });
        }


        function UpdateData() {
            recno_location = $("input[name='location']:checked").val();
            $.ajax({
                type: "POST",
                // url: encodedURL_Update,
                url: 'ajax/ajaxdbupdatemysql.php',
                data: {
                    queryIdHD: 'UPD_ACTIVITYHD',
                    queryIdDT: '',
                    genIdHD: 'GEN_ACTIVITYHD',
                    genIdDT: '',
                    condition: 'UHD',
                    paramhd: { // อาร์เรย์ params ที่คุณต้องการส่ง
                        RECNO: <?php echo  isset($recno) ? $recno : -1; ?>,
                        STATUS: $('#status').val(),
                        CUSTNAME: name_cust,
                        CONTNAME: $('#contname').val(),
                        CUST: recno_cust,
                        CONT: recno_cont,
                        TEL: $('#tel').val(),
                        EMAIL: $('#email').val(),
                        ADDR: $('#addr').val(),
                        LOCATION: recno_location,
                        SUBJECT: $('#subject').val(),
                        DETAIL: $('#detail').val(),
                        REF: $('#ref').val(),
                        PRIORITY: $('#priority').val(),
                        TIMED: $('#timed').val(),
                        TIMEH: $('#timeh').val(),
                        TIMEM: $('#timem').val(),
                        // STARTD: moment($('#date').val(), 'DD/MM/YYYY').format('MM/DD/YYYY'), // FIRDBIRD
                        STARTD: moment($('#date').val(), 'DD/MM/YYYY').format('YYYY-MM-DD'),
                        PRICECOST: $('#pcost').val(),
                        PRICEPWITHDRAW: $('#pwithdraw').val(),
                        OWNER_NUM: recno_owner,
                        OWNERNAME_STR: recno_nowner,
                    },
                    paramdt: { // อาร์เรย์ params ที่คุณต้องการส่ง
                        datanull: '',
                    },
                    paramlist: {
                        datanull: '',
                    },
                    DataJSON: null
                },
                dataSrc: '',
                beforeSend: function() {},
                complete: function() {},
                success: function(response) {
                    // console.log(response)
                    if (response.status == 'success') {
                        // console.log('success')
                        Swal.fire({
                            title: "บันทึกแล้ว",
                            text: "ข้อมูลได้ถูกอัทเดท",
                            icon: "success",
                            buttons: ["OK"],
                            dangerMode: true,
                        }).then(function(willRedirect) {
                            // willRedirect คือค่า boolean ที่บอกว่าผู้ใช้เลือก OK (true) หรือยกเลิก (false)
                            if (willRedirect) {
                                // ถ้าผู้ใช้เลือก OK ให้เปลี่ยนหน้าไปยัง "datatable_activity.php"
                                location.href = "datatable_activity.php";
                            }
                        });

                        setTimeout(function() {
                            swal.close(); // ปิด SweetAlert
                            location.href = "datatable_activity.php"; // เปลี่ยนหน้าไปยัง "datatable_activity.php"
                        }, 2000);
                        /////////////////////////////////
                    } else {
                        Swal.fire(
                            'เกิดปัญหาในการบันทึก',
                            response.message,
                            'error'
                        )
                    }
                },
                error: function(xhr, status, error) {
                    console.log('error')
                    console.error(error);
                }
            });
        }
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        var edit_recno_cust;
        var edti_recno_cont;
        ////////////////////////////////////////////// EDIT AJAX /////////////////////////////////////////////////
        function DataEdit(recno_edit) {
            $.ajax({
                url: encodedURL_Select,
                data: {
                    queryId: 'EDSEL_ACTIVITYHD',
                    params: {
                        RECNO: recno_edit
                    },
                    condition: 'mix',
                },
                dataSrc: '',
                success: function(response) {

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        function set_formdata() {
            var formData = new FormData();
            formData.append('name', $('#name').val());

            /// upload ///
            var selectedFile = $('#fileToUpload')[0].files[0];
            if (selectedFile) {
                formData.append('fileToUpload', selectedFile);
            }
            /////////////

            var purchaseValue = $('#date').val();
            var firstUsageValue = $('#date_first').val();
            var lastUsageValue = $('#date_last').val();

            console.log(firstUsageValue ? moment(firstUsageValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : null);
            /// id ,param ///
            var paramhd = {
                NAME: $('#name').val(),
                TYPE: $('#type').val(),
                CODE: $('#code').val(),
                MODEL: $('#model').val(),
                CUSTNAME: $('#cust').val(),
                CONTNAME: $('#cont').val(),
                PHONE: $('#phone').val(),
                EMAIL: $('#email').val(),
                AREA: $('#area').val(),
                DOCINFO: $('#docno').val(),
                STATUS: $('#status').val(),
                PRIORITY: $('#priority').val(),
                WARRANTY: $('#warranty').val(),
                MAINTENANCETIMES: $('#maintenance').val(),
                BROKENTIMES: '',
                DETAILS: $('#detail').val(),
                PURCHASEDATE: purchaseValue ? moment(purchaseValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                FIRSTUSAGE: firstUsageValue ? moment(firstUsageValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                LASTUSAGE: lastUsageValue ? moment(lastUsageValue, 'DD/MM/YYYY').format('YYYY-MM-DD') : '0000-00-00',
                // FIRSTUSAGE: moment($('#date_first').val(), 'DD/MM/YYYY').format('YYYY-MM-DD'),
                RECORDERNO: recno_owner,
                RECORDERNAME: recno_nowner,
            };
            // console.log(paramhd);
            // var paramhd = null;
            // เพิ่มอาร์เรย์ paramhd เข้าไปใน FormData และแปลงเป็น JSON ก่อน
            formData.append('queryIdHD', 'EQUIPMENT');
            formData.append('queryIdDT', '');
            formData.append('condition', 'IHD');


            formData.append('paramhd', JSON.stringify(paramhd));
            ////////////////
            return formData;
        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////// MISCELLANEOUS /////////////////////////////////////////////////
        $('html, body').animate({
            scrollTop: $('#dataoffset').offset().top
        }, 100); // ค่าความเร็วในการเลื่อน (มิลลิวินาที)

        $('#backhis').click(function() {
            window.location = 'datatable_equipment.php';
        });
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
    });
</script>

</html>