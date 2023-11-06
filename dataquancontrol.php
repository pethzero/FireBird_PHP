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

        <div class="row  pt-3">
    <h1>ประเมินคุณภาพสินค้า</h1>
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
        <button type="button" id="downloadExcel" name='downloadExcel' class=" btn btn-success float-right float-end">Download <i class="fas fa-file-excel"></i></button>
    </div>
</div>

        </div>
    </div>
  </div>
</div>





<hr>
<div class="row pt-2 table-responsive">
    <table id="detailtable" class="nowrap table table-striped table-bordered" width='100%'>
        <thead class="thead-light">
            <tr>
                <th>รหัส</th>
                <th>เลขที่ใบสั่งซื้อ</th>
                <th>สถานะ</th>
                <th>จำนวนทั้งหมด</th>
                <th>Q'ty NG</th>
                <th>คะแนนคุณภาพ</th>
                <th>ประเภทสั่งซื้อ</th>
                <th>งวดเดือน</th>
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

        const formatQuan  = (amount) => {
            if (amount === '') {
                return '';
            }
            let formattedQuan = parseFloat(amount).toFixed(0);
            formattedQuan = formattedQuan.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            return formattedQuan;
        };

        const convertToThaiDate = (inputDate) => {
            const dateParts = inputDate.split('-');
            const year = parseInt(dateParts[0]);
            const month = parseInt(dateParts[1]);
            const day = parseInt(dateParts[2]);
            const thaiMonths = ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
            const thaiDate = `${thaiMonths[month - 1]} ${year + 543}`;
            return thaiDate;
        }
        const checkDoctype = (value) => {
            if (value === 1 || value === null) {
                return "ทั่วไป";
            } else if (value === 0) {
                return "วัตถุดิบ";
            } else if (value === 2) {
                return "OUT";
            }
        }
        const checkDocStatus = (value) => {
            if (value === 'A') {
                return "";
            } else if (value === 'C') {
                return "ยกเลิก";
            } else if (value === 'D') {
                return "รับแล้ว";
            } else if (value === 'P') {
                return "ค้างรับ";
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        var selectedRow = null;
        var detailtable = $('#detailtable').DataTable({
            "info": false,
            scrollX: true,
            order: [],
            columns: [{
                    data: 'RECNO'
                },
                {
                    data: 'DOCNO'
                },
                {
                    data: 'STATUS',
                    render: function(data, type, row, meta) {
                        return checkDocStatus(data);
                    }
                },
                {
                    data: 'QTYITEM',
                    render: function(data, type, row, meta) {
                        return formatQuan(data);
                    }
                },
                {
                    data: 'QTYNG',
                    render: function(data, type, row, meta) {
                        return formatQuan(data);
                    }
                },
                {
                    data: 'QPOINT'
                },
                {
                    data: 'DOCTYPE',
                    render: function(data, type, row, meta) {
                        return checkDoctype(data);
                    }
                },
                {
                    data: 'DOCDATE',
                    render: function(data, type, row, meta) {
                        return convertToThaiDate(data);
                    }
                },
            ],
            "columnDefs": [
                // {
                //     "orderable": false,
                //     "targets": [1]
                // },
                {
                    "visible": false,
                    "targets": [0]
                },
            ],
            rowCallback: function(row, data) {

            },
        });


        var selectdata;
        var Param = [];
        let listunit; // ประกาศตัวแปร listunit ให้มีขอบเขตทั่วโปรแกรม
        var dataexcel;
        let datapo;
        var hasCalledResponse = false;
        getDataFromServer('select', moment(firstDayOfMonth, 'DD/MM/YYYY').format('DD.MM.YYYY'), moment(lastDayOfMonth, 'DD/MM/YYYY').format('DD.MM.YYYY'));
        async function getDataFromServer(dataQuery, date_begin, date_end) {
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
                dataexcel = data1.datasql
                // console.log(data1.datasql);

                detailtable.clear().rows.add(data1.datasql).draw();
                $('.loading').hide();
            } catch (error) {
                // จัดการข้อผิดพลาด
                console.error(error);
                $('.loading').hide();
            }
        }



        function mapData(datamapsql) {
            const mappedData = datamapsql.map((item) => {
                return {
                    DOCNO: item.DOCNO,
                    STATUS: checkDocStatus(item.STATUS),
                    QTYITEM: formatQuan(item.QTYITEM),
                    QTYNG: formatQuan(item.QTYNG),
                    QPOINT: item.QPOINT,
                    DOCTYPE: checkDoctype(item.DOCTYPE),
                    DOCDATE: convertToThaiDate(item.DOCDATE)
                };

            });
            return mappedData;
        }

        // เรียกใช้งานฟังก์ชัน getDataFromServer เพื่อดึงข้อมูลเมื่อคุณต้องการ
        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        function set_formdata(conditionsformdata) {
            var formData = new FormData();
            // Param.push({})
            if (conditionsformdata == "select") {
                formData.append('queryIdHD', 'SELECT_POQC');
                formData.append('condition', 'DATEBE');
            } else {
                formData.append('queryIdHD', 'SELECT_POQC_ALL');
                formData.append('condition', 'NULL');
                // กรณีอื่น ๆ
                // other
            }
            // tableData 
            formData.append('queryIdExcel', 'SELECT_POQC');
            formData.append('condition_footer', 'F');
            // formData.append('queryIdGET', 'LISTUNIT');
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
            $('.loading').show();
            if (result.status) {
                download_excel(result.databegin, result.dateend)
            }
        });

        $('#refresh').click(function() {
            const result = checkdate();
            if (result.status) {
                $('.loading').show();
                getDataFromServer('select', result.databegin, result.dateend)
            }
            $('#excelmessage').html("<h3>ข้อมูลโหลด ณ วันที่ " + moment(result.databegin, 'DD/MM/YYYY').format('DD/MM/YYYY') + " ถึง " + moment(result.dateend, 'DD/MM/YYYY').format('DD/MM/YYYY') + "</h3>")
        });
        $('#refreshall').click(function() {
            const result = checkdate();
            if (result.status) {
                $('.loading').show();
                getDataFromServer('NULL', result.databegin, result.dateend)
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

                const mappedData = mapData(dataexcel);
                datapo = mappedData;
                const blobResponse = await fetch('export/excel_export.php', {
                    method: 'POST',
                    body: set_formdata('select'),
                });

                if (!blobResponse.ok) {
                    throw new Error('Error sending data to server');
                    $('.loading').hide();
                }
                // const namelike = $('#namelink').val();
                const namelike = 'Excel_ประเมินคุณภาพสินค้า';
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

  });
</script>
</html>