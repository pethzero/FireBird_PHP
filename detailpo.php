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
  <style>

  </style>
  <link href="dashboard.css" rel="stylesheet">
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
      <div class="row pt-2 mb-2">
  <div class="col-md-12">
    <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
<div class="row">
    <h1>สรุปแจงซื้อ(ใบแจ้งหนี้)</h1>
</div>

<div class="row pb-3">
    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
        <div class="input-group input-daterange">
            <span class="input-group-text">เริ่มต้น</span>
            <input type="text" class="form-control" id="datepickerbegin">
            <span class="input-group-text">จนถึง</span>
            <input type="text" class="form-control" id="datepickerend">
        </div>
    </div>
</div>
<div class="row pb-1">
    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
        <button id="refresh" type="button" class="btn btn-primary">ค้นหา</button>
    </div>

    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
        <button id="refreshall" type="button" class="btn btn-primary">ค้นหาทั้งหมด</button>
    </div>
</div>

<div class="row d-flex justify-content-between">
    <div class="col-sm-12 col-md-6 col-lg-6">
        <span id="excelmessage"></span>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <button type="button" id="downloadExcel" name='downloadExcel'  class=" btn btn-success float-right float-end">Download  <i class="fas fa-file-excel"></i></button>
    </div>
</div>

        </div>
    </div>
  </div>
</div>

<div class="row pt-1 table-responsive">
    <table id="detailtable" class="nowrap table table-striped table-bordered" width='100%'>
        <thead class="thead-light">
            <tr>
                <!-- <th>No.</th> -->
                <th>รหัส</th>
                <th>ผู้จำหน่าย</th>
                <th>ใบแจ้งหนี้</th>
                <th>เลขที่ใบส่งสินค้าผู้ขาย</th>
                <th>วันที่</th>
                <th>รายละเอียด</th>
                <th>จำนวนแจ้งหนี้</th>
                <th>จำนวนรับเข้า</th>
                <th>หน่วย</th>
                <th>หน่วละ</th>
                <th>ผลรวม</th>
                <th>เลขที่ใบสั่งขาย</th>
                <th>สั่งขายรายละเอียด</th>
                <th>จำนวน</th>
                <th>หน่วย</th>
                <th>หน่วละ</th>
                <th>ผลรวม</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

      </form>
      </main>
    </div>
  </div>
</body>
<?php include("0_footerjs_piority.php"); ?>
<script>
  $(document).ready(function() {
    /////////////////////////////////////////////////////////////// INITOPEATION /////////////////////////////////////////////////////////
    $(window).keydown(function(event) {
      if (event.keyCode == 13 && !$(event.target).is('textarea')) {
        event.preventDefault();
        return false;
      }
    });
 

    var userlevel = "<?php echo isset($_SESSION['USERLEVEL']) ? $_SESSION['USERLEVEL'] : ''; ?>";
        var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
        let lastDayOfMonth = moment().endOf('month').format('DD/MM/YYYY');

        moment($('#datepickerbegin').val(firstDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
        moment($('#datepickerend').val(lastDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
        $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + firstDayOfMonth + " ถึง " + lastDayOfMonth)

        $("#datepickerbegin").datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true,
            clearBtn: true
        });

        $("#datepickerend").datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            autoclose: true,
            clearBtn: true
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

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        var selectedRow = null;
        var detailtable = $('#detailtable').DataTable({
            "info": false,
            scrollX:true,
            order: [],
            columns: [{
                    data: 'SUPPCODE'
                },
                {
                    data: 'SUPPNAME'
                },
                {
                    data: 'DOCNO'
                },
                {
                    data: 'SUPPINVNO'
                },
                {
                    data: 'DOCDATE'
                },
                {
                    data: 'DETAIL'
                },
                {
                    data: 'QUAN'
                },
                {
                    data: 'QUANDLY'
                },
                {
                    data: 'UNITNO'
                },
                {
                    data: 'UNITAMT'
                },
                {
                    data: 'TOTALAMT'
                },
                {
                    data: 'PURCHDDOCNO'
                },
                {
                    data: 'PURCDETAIL'
                },
                {
                    data: 'PURCQUANORD'
                },
                {
                    data: 'PURCUNITNO'
                },
                {
                    data: 'PURCUNITAMT'
                },
                {
                    data: 'PURCTOTALAMT'
                },
            ],
            "columnDefs": [
                // {
                //     "orderable": false,
                //     "targets": [1]
                // },
                // {
                //     "visible": false,
                //     "targets": [0]
                // },
            ],
            rowCallback: function(row, data) {

            },
        });


        var selectdata;
        var Param = [];
        let listunit; // ประกาศตัวแปร listunit ให้มีขอบเขตทั่วโปรแกรม
        let datapo;
        var hasCalledResponse = false;
        getDataFromServer('select',moment(firstDayOfMonth, 'DD/MM/YYYY').format('DD.MM.YYYY'), moment(lastDayOfMonth, 'DD/MM/YYYY').format('DD.MM.YYYY'));
        async function getDataFromServer(dataQuery,date_begin, date_end) {
            Param = [];
            Param.push({
                datebegin: date_begin,
                dateend: date_end
            })
            try {
                const response1 = await fetch('ajax/pc_fb_select_po.php', {
                    method: 'POST',
                    body: set_formdata(dataQuery), // ใช้ FormData เป็นข้อมูลที่จะส่ง
                });
                if (!response1.ok) {
                    throw new Error('เกิดข้อผิดพลาดในการส่งข้อมูลเริ่มต้น');
                }
                const data1 = await response1.json(); // แปลงข้อมูล JSON จากการตอบกลับ
                // console.log(data1);
                if (!hasCalledResponse) {
                    const response2 = await fetch('ajax/get_fb_select_po.php', {
                        method: 'POST', // ใช้ HTTP GET request
                        body: set_formdata(dataQuery), // ใช้ FormData เป็นข้อมูลที่จะส่ง
                    });

                    if (!response2.ok) {
                        throw new Error('เกิดข้อผิดพลาดในการส่งข้อมูล response2');
                    }

                    const data2 = await response2.json(); // แปลงข้อมูล JSON จากการตอบกลับ
                    hasCalledResponse = true;
                    listunit = data2.datasql;
                    // console.log(data2);
                }

                // console.log(data1.datasql);
                const mappedData = mapData(data1.datasql);
                datapo = mappedData;
                detailtable.clear().rows.add(datapo).draw();
                $('.loading').hide();
            } catch (error) {
                // จัดการข้อผิดพลาด
                console.error(error);
                $('.loading').hide();
            }
        }



        function mapData(datamapsql) {
            const mappedData = datamapsql.map((item) => {
                const isSameUnit = getUnitNameByRecno(item.UNITNO) === getUnitNameByRecno(item.PURCUNITNO);
                const QUAN = item.QUAN !== null && item.QUAN !== undefined ? parseFloat(item.QUAN) : 0;
                const QUANDLY = item.QUANDLY !== null && item.QUANDLY !== undefined ? parseFloat(item.QUANDLY) : 0;
                const PURCQUANORD = item.PURCQUANORD !== null && item.PURCQUANORD !== undefined ? parseFloat(item.PURCQUANORD) : 0;
                const PURCUNITAMT = item.PURCUNITAMT !== null && item.PURCUNITAMT !== undefined ? parseFloat(item.PURCUNITAMT) : 0;
                const PURCTOTALAMT = item.PURCTOTALAMT !== null && item.PURCTOTALAMT !== undefined ? parseFloat(item.PURCTOTALAMT) : 0;
                let RealTotal = 0;

                if (!isSameUnit) {
                    RealTotal = QUAN * PURCQUANORD * PURCUNITAMT;
                } else {
                    RealTotal = PURCTOTALAMT;
                }


                return {
                    // RECNOSUP: item.RECNOSUP,
                    SUPPCODE: item.SUPPCODE, //รหัสผู้จำหน่าย
                    SUPPNAME: item.SUPPNAME, //ชื่อผู้จำหน่าย
                    DOCNO: item.DOCNO, //ใบแจ้งหนี้
                    SUPPINVNO: item.SUPPINVNO, //ใบเลขที่ใบส่งสินค้าผู้ขาย
                    DOCDATE: formatDate(item.DOCDATE), //วันที่
                    // RECNO: item.RECNO,
                    // STATUS: item.STATUS,
                    DETAIL: item.DETAIL, //รหัส
                    UNITNO: getUnitNameByRecno(item.UNITNO), //หน่วย
                    QUAN: QUAN.toFixed(2), //จำนวนแจ้งหนี้
                    QUANDLY: QUANDLY.toFixed(2), //จำนวนรับเข้า
                    UNITAMT: item.UNITAMT, //หน่วยละ
                    TOTALAMT: item.TOTALAMT, //ผลรวม
                    PURCHDDOCNO: item.PURCHDDOCNO, //ใบสั่งซื้อ
                    PURCDETAIL: item.PURCDETAIL, //รายละเอียด
                    PURCQUANORD: PURCQUANORD.toFixed(2), //จำนวน
                    PURCUNITNO: getUnitNameByRecno(item.PURCUNITNO), //หน่วย
                    PURCUNITAMT: PURCUNITAMT.toFixed(2), //หน่วยละ
                    PURCTOTALAMT: PURCTOTALAMT.toFixed(2), //ผลรวม
                    RealTotal: RealTotal.toFixed(2) //ผลรวมหน่วยต่าง
                };

            });
            return mappedData;
        }




        function getUnitNameByRecno(recno) {
            let data = listunit;
            for (let i = 0; i < data.length; i++) {
                if (data[i].RECNO === recno) {
                    return data[i].UNITNAME;
                }
            }
            // ถ้าไม่พบ RECNO ที่ตรงกับค่าที่ระบุ ให้คืนค่าว่างหรือค่าเริ่มต้นที่คุณต้องการ
            return null; // หรือค่าอื่น ๆ ตามที่คุณต้องการ
        }
        // เรียกใช้งานฟังก์ชัน getDataFromServer เพื่อดึงข้อมูลเมื่อคุณต้องการ
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            // Param.push({})
            if (conditionsformdata == "select") {
                formData.append('queryIdHD', 'PO_REPORT');
                formData.append('condition', 'DATEBE');
            } else {
                formData.append('queryIdHD', 'PO_REPORT_ALL');
                formData.append('condition', 'NULL');
                // กรณีอื่น ๆ
                // other
            }
            // tableData 
            formData.append('queryIdExcel', 'PO_REPORT');
            formData.append('condition_footer', 'F');
            formData.append('queryIdGET', 'LISTUNIT');
            formData.append('Param', JSON.stringify(Param));
            formData.append('blobData', JSON.stringify(datapo));
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
            var clickedButtonName = e.originalEvent.submitter.name;
            // if (clickedButtonName === 'editmodal') {
            //     let url = 'ajax/process_update.php';
            //     let status_sql = 'update';
            //     // console.log('save modal');
            //     // AlertSave(url, status_sql)
            // } else if (clickedButtonName === 'removerow') {
            //     let url = 'ajax/process_delete.php';
            //     let status_sql = 'delete';
            //     // AlertSave(url, status_sql)
            // }
        });
        var process = 'T';
        var tableData = [];
        //////////////////////////////////////////////////////////// CRUDSQL ////////////////////////////////////////////////////////////

        //////////////////////////////////////////////////////////// CLICK ////////////////////////////////////////////////////////////
        $("#downloadExcel").click(function() {
            const result = checkdate();
            if (result.status) {
                download_excel(result.databegin, result.dateend)
            }
        });

        $('#refresh').click(function() {
            const result = checkdate();
            if (result.status) {
                $('.loading').show();
                getDataFromServer('select',result.databegin, result.dateend) 
            }
            $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + moment( result.databegin, 'DD/MM/YYYY').format('DD/MM/YYYY')+ " ถึง " + moment( result.dateend, 'DD/MM/YYYY').format('DD/MM/YYYY') + "</h3>")
        });
        $('#refreshall').click(function() {
            const result = checkdate();
            if (result.status) {
                $('.loading').show();
                getDataFromServer('NULL',result.databegin, result.dateend)
            }
            $('#excelmessage').html("<h3>ข้อมูลโหลดทั้งหมด</h3>")
        });

        const checkdate = () => {
            const beginDateInput = $('#datepickerbegin').val();
            const endDateInput = $('#datepickerend').val();
            const result = {
                status: false,
                databegin: '',
                dateend: ''
            };
            if (beginDateInput === '' || endDateInput === '') {
                Swal.fire(
                    'มีการป้อนวันที่ผิดพลาด',
                    'ไม่สามารถประมวลผลได้',
                    'error'
                );
                return result;
            }
            const beginDate = moment(beginDateInput, 'DD/MM/YYYY');
            const endDate = moment(endDateInput, 'DD/MM/YYYY');
            if (endDate.isBefore(beginDate)) {
                Swal.fire(
                    'มีการป้อนวันที่ผิดพลาด',
                    'ไม่สามารถประมวลผลได้',
                    'error'
                );
                return result;
            }
            result.status = true;
            result.databegin = beginDate.format('DD.MM.YYYY');
            result.dateend = endDate.format('DD.MM.YYYY');
            return result;
        };
        async function download_excel(data_begin, date_end) {
            try {
                const blobResponse = await fetch('export/excel_export.php', {
                    method: 'POST',
                    body: set_formdata('select'),
                });

                if (!blobResponse.ok) {
                    throw new Error('Error sending data to server');
                    $('.loading').hide();
                }
                // const namelike = $('#namelink').val();
                const namelike = 'Excel_สรุปยอดแจงซื้อ';
                // ดาวน์โหลดข้อมูลเป็น Blob หรือทำอะไรกับ blobResponse ตามที่คุณต้องการ
                const blobData = await blobResponse.blob();
                const url = window.URL.createObjectURL(blobData);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = namelike + '.xlsx'; // ตั้งชื่อไฟล์ที่จะดาวน์โหลด
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                $('.loading').hide();
            } catch (error) {
                console.error(error);
            }
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