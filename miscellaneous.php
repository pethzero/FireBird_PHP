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
  <!--
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/bootstrap-5.3.0.min.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/mypcu.css"> 
    -->
</head>

<body>
  <style>
    .btn-custom {
      background: linear-gradient(to right, #e8e8e8, #f1f1f1);
      color: #000000;
    }

    .card-img-top {
      height: 200px;
      /* Adjust the height to your desired value */
      object-fit: cover;
      /* This ensures the image fills the entire space while maintaining aspect ratio */
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
  <?php
  include("0_header.php");
  // include("0_breadcrumb.php"); 
  ?>


  <div class="section">
    <div class="container-fluid">

      <div class="row pt-3">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-2">
          <button id='backhis' type="button" class="btn btn-primary">กลับหน้าหลัก</button>
        </div>
      </div>

      <div class="row  pt-3">
        <h1>ดาวโหลดส่วนเสริม</h1>
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

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="input-group ">
            <span class="input-group-text">ประเภท</span>
            <select id='slcdata' class="form-select" aria-label="Default select example">
              <option value="0" selected>ใบเสนอราคา</option>
              <option value="1">ใบสั่งขาย</option>
              <option value="2">ใบส่งของสินค้า</option>
              <option value="3">ใบแจ้งหนี้</option>
            </select>
          </div>
        </div>
      </div>

      <div class="row pb-3">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="input-group ">
            <span class="input-group-text">ชื่อไฟล์</span>
            <input type="text" class="form-control" id="namelink" value="Excel_ใบเสนอราคา"  maxlength="125" placeholder="ใส่ชื่อ">
          </div>
        </div>
      </div>

      <div class="row pt-3">
        <div class="col-sm-12 col-md-4 col-lg-2">
          <button class="btn btn-success" id="downloadExcel">download excel</button>
        </div>
      </div>

    </div>
    <div class="loading" style="display: none;"></div>
  </div>

  <?php include("0_footer.php"); ?>
</body>
<?php
include("0_footerjs.php");
?>


<script>
  $(document).ready(function() {


    $("#slcdata").on("change", function() {
      var selectedValue = $('#slcdata').val();
      var namelink = "";
      switch (selectedValue) {
        case '0':
          namelink = 'Excel_ใบเสนอราคา';
          break;
        case '1':
          namelink = 'Excel_ใบสั่งขาย';
          break;
        case '2':
          namelink = 'Excel_ใบส่งของสินค้า';
          break;
        case '3':
          namelink = 'Excel_ใบแจ้งหนี้';
          break;
        default:
          namelink = '';
      }
      $('#namelink').val(namelink);
    });

    //  $('#namelink').val('')

    // หาวันที่ 1 ของเดือนนี้
    var firstDayOfMonth = moment().startOf('month').format('DD/MM/YYYY');
    // หาวันสุดท้ายของเดือนนี้
    var lastDayOfMonth = moment().endOf('month').format('DD/MM/YYYY');

    moment($('#datepickerbegin').val(firstDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')
    moment($('#datepickerend').val(lastDayOfMonth), 'DD/MM/YYYY').format('MM/DD/YYYY')

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

    const formatCurrency = (amount) => {
      if (amount === '') {
        return '';
      }
      let formattedAmount = parseFloat(amount).toFixed(2);
      formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      // formattedAmount += '฿';
      return formattedAmount;
    };


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


    $("#downloadExcel").click(function() {
      // ข้อมูลที่ต้องการส่งไปยัง PHP
      // ส่งข้อมูลไปยัง PHP โดยใช้ AJAX

      if ($('#namelink').val() !== '') {
        let beginDate = moment($('#datepickerbegin').val(), 'DD/MM/YYYY');
        let endDate = moment($('#datepickerend').val(), 'DD/MM/YYYY');
        let slcdata = $('#slcdata').val()

        const array_data = [{
            name: "qout",
            queryid: "EXCEL_CUSTOMERSALE",
          },
          {
            name: "oreder",
            queryid: "EXCEL_QOUT_ORDERHD",
          },
          {
            name: "delivery",
            queryid: "EXCEL_QOUT_DELYHD",
          },
          {
            name: "invoice",
            queryid: "EXCEL_QOUT_INVOICE",
          }
        ];
        if ($('#datepickerbegin').val() !== '' && $('#datepickerend').val() !== '') {
          console.log("ประมวลผลได้");
          if (endDate.isBefore(beginDate)) {
            Swal.fire(
              'มีการป้อนวันที่ผิดพลาด',
              'ไม่สามารถประมวลผลได้',
              'error'
            )
          } else if (endDate.isSame(beginDate)) {
            // ถ้า endDate เท่ากับ beginDate
            $('.loading').show();
            databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
            dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
            download_excel(array_data[parseInt(slcdata)], databegin, dateend)
          } else {
            // ถ้า endDate มากกว่า beginDate
            $('.loading').show();
            databegin = moment($('#datepickerbegin').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
            dateend = moment($('#datepickerend').val(), 'DD/MM/YYYY').format('DD.MM.YYYY');
            download_excel(array_data[parseInt(slcdata)], databegin, dateend)
          }
        } else {
          Swal.fire(
            'มีการป้อนวันที่ผิดพลาด',
            'ไม่สามารถประมวลผลได้',
            'error'
          )
        }
      } else {
        Swal.fire({
          title: 'ชื่อไฟล์ว่าง',
          html: '<img src="images/womanyellingcat.jpg"  width="150" height="150"  alt="รูปภาพ"><br><br><h4>ใส่ชื่อไฟล์ด้วย</h4>',
          icon: 'warning',
          confirmButtonText: 'OK'
        });
      }

    });

    async function download_excel(slcdata, data_begin, date_end) {
      var Param = [];
      var formData = new FormData();
      Param.push({
        datebegin: data_begin,
        dateend: date_end
      })
      formData.append('queryIdHD', slcdata.queryid);
      formData.append('queryIdExcel', slcdata.queryid);
      formData.append('Param', JSON.stringify(Param));
      formData.append('condition', 'DATEBE');

      try {
        // ดึงข้อมูล Excel จากเซิร์ฟเวอร์
        const jsonResponse = await fetch('ajax/process_dataeexcel.php', {
          method: 'POST',
          body: formData,
        });

        if (!jsonResponse.ok) {
          $('.loading').hide();
          throw new Error('Error sending data to server');
        }

        const jsonData = await jsonResponse.json();

        // เรียกใช้ฟังก์ชัน mapData สำหรับแปลงข้อมูล
        let TureTotalAmt = 0;
        const mappedData = mapData(jsonData.datasql, slcdata.queryid);
        // ใช้ reduce เพื่อคำนวณผลรวมของ TureTotalAmt
        // ใช้ forEach เพื่อคำนวณผลรวมของ TureTotalAmt
        mappedData.forEach((item) => {
          if (typeof item.TOTALAMT !== 'undefined') {
            const totalAmtAsFloat = parseFloat(item.TOTALAMT);
            if (!isNaN(totalAmtAsFloat)) {
              TureTotalAmt += totalAmtAsFloat;
            }
          }
        });

        ////////////////////
        formData.append('blobData', JSON.stringify(mappedData));
        formData.append('TureTotalAmt', JSON.stringify(TureTotalAmt));
        formData.append('condition_footer', 'T');

        const blobResponse = await fetch('export/excel_export.php', {
          method: 'POST',
          body: formData,
        });

        if (!blobResponse.ok) {
          throw new Error('Error sending data to server');
          $('.loading').hide();
        }

        const namelike = $('#namelink').val();
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

    function mapData(datamapsql, conditionmap) {
      const mappedData = datamapsql.map((item) => {
        if (conditionmap == 'EXCEL_CUSTOMERSALE') {
          return {
            // RECNO: item.RECNO,
            DOCDATE: formatDate(item.DOCDATE),
            DOCNO: item.DOCNO,
            REVISE: item.REVISE,
            CODE: item.CODE,
            SNAME: item.SNAME,
            NAME: item.NAME,
            CONTNAME: item.CONTNAME,
            DETAIL: item.DETAIL,
            EMPNAME: item.EMPNAME,
            CREDIT: item.CREDIT,
            REMARK: item.REMARK,
            QUAN: item.QUAN,
            UNITAMT: item.UNITAMT,
            TOTALAMT: item.TOTALAMT,
          };
        } else if (conditionmap == 'EXCEL_QOUT_ORDERHD') {
          return {
            // RECNO: item.RECNO,
            DOCDATE: formatDate(item.DOCDATE),
            DOCNO: item.DOCNO,
            CUSTORDERNO: item.CUSTORDERNO,
            CODE: item.CODE,
            SNAME: item.SNAME,
            NAME: item.NAME,
            CONTNAME: item.CONTNAME,
            EMPNAME: item.EMPNAME,
            DETAIL: item.DETAIL,
            QUAN: item.QUANDLY,
            UNITAMT: item.UNITAMT,
            TOTALAMT: item.TOTALAMT,
          };
        } else if (conditionmap == 'EXCEL_QOUT_DELYHD') {
          return {
            DOCDATE: formatDate(item.DOCDATE),
            DOCNO: item.DOCNO,
            ORDERHD: item.ORDERHD,
            CODE: item.CODE,
            SNAME: item.SNAME,
            NAME: item.NAME,
            DETAIL: item.DETAIL,
            QUAN: item.QUAN,
            UNITAMT: item.UNITAMT,
            TOTALAMT: item.TOTALAMT,
          };
        } else if (conditionmap == 'EXCEL_QOUT_INVOICE') {
          return {
            DOCDATE: formatDate(item.DOCDATE),
            DOCNO: item.DOCNO,
            ORDERNO: item.ORDERNO,
            CODE: item.CODE,
            SNAME: item.SNAME,
            NAME: item.NAME,
            CONTNAME: item.CONTNAME,
            EMPNAME: item.EMPNAME,
            DETAIL: item.DETAIL,
            QUAN: item.QUANDLY,
            UNITAMT: item.UNITAMT,
            TOTALAMT: item.TOTALAMT,
          };
        }

      });

      return mappedData;
    }




    $('#backhis').click(function() {
      window.location = 'main.php';
    });




  });
</script>

</html>