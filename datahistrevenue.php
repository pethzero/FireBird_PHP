<!DOCTYPE html>
<html lang="en">
  <head>
    <?php 
    include("0_headcss.php"); 
    ?>
    <!-- <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/bootstrap-5.3.0.min.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/mypcu.css"> -->
  </head>
  <body>
  <style>
    .btn-custom {
    background: linear-gradient(to right, #e8e8e8, #f1f1f1);
    color: #000000;
  }
  /* .chartMenu {
        width: 100vw;
        height: 40px;
        background: #1A1A1A;
        color: rgba(54, 162, 235, 1);
      }
      .chartMenu p {
        padding: 10px;
        font-size: 20px;
      }
      .chartCard {
        width: 100vw;
        height: calc(100vh - 40px);
        background: rgba(54, 162, 235, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .chartBox {
        width: 700px;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(54, 162, 235, 1);
        background: white;
      } */
</style>

  <?php 
      session_start(); 
      if (!isset($_SESSION["RECNO"])) 
        {
          header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
          exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
        } 
      include("0_header.php"); 
      include("0_breadcrumb.php"); 
  ?>
    
<div class="section">
  <div class="container pt-2">

    <div class="row">
        <div class="col-12 col-lg-3"> <!-- กำหนดขนาดคอลัมน์เป็น 3 -->
            <select id="allyear" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
            </select>
        </div>
    </div>

    <div class="row">
      <div class="content-panel">
					<div class="content-line"></div>
           <span  id="myspan" class="content-tab"></span>
		  </div>
    </div>

    <div class="row">
      <table id="mytable" class="nowrap table table-striped table-bordered"  width='100%'> 
        <thead class="thead-light">
        
        </thead>
        <tbody>
          <!-- สร้างเนื้อตารางด้วย JavaScript -->
        </tbody>
        <tfoot>

        </tfoot>
      </table>
    </div>

    <div class="row">
      <div class="chartCard">
          <div class="chartBox">
            <canvas id="myChart"></canvas>
          </div>
      </div>
    </div>
   
  </div>
</div>


 <hr>

    <?php include("0_footer.php"); ?>
    <?php include("0_footerjs.php"); ?>
    <?php 
    // include("0_fuccart.php"); 
     ?>
    <script>
    
   

  $(document).ready(function()
  {

      // Setup
      let datachart = null; // Initialize data with null
      // Config
      const config = {
        type: 'line',
        datachart,
        options: {
          scales: {
            y: {
              beginAtZero: true,
              suggestedMax: 30000000
            }
          }
        }
      };
      // Render init block
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );


    $("#allyear").on("change", function() {
    Select_year($("#allyear").val())
    });
    var jsondata = 
    {
        MONTHSPAN: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        YEARSPAN: []
    }
    All_year()       
    function All_year()
    {
        $.ajax({
        url: 'ajax_data.php',
        data: {
          queryId: 'allyear',
          params: null,
          condition:'',
        },
        dataSrc:'',
        success: function(response){
          // console.log(response);
          var yeararray = JSON.parse(response).data; 
          // console.log(yeararray); // แสดงอาร์เรย์ที่ได้หลังจากแปลง
          var selectElement = $('#allyear'); // เลือกแท็ก <select> ด้วย ID
          for (var i = 0; i < yeararray.length; i++) 
          {
            var option = $('<option>').val(yeararray[i]['AYEAR']).text(yeararray[i]['AYEAR']);
            if (i === 0) {
                option.attr('selected', 'selected');
            }
            selectElement.append(option);
          }
          var max = Math.max.apply(null, yeararray.map(function(item)
          {
            return item['AYEAR'];
          }));
          Select_year(max)
        },
        error: function(xhr, status, error)
        {
          console.error(error);
        }
      });
    }

    function Select_year(selectdata)
    {
        $.ajax({
        url: 'ajax_data.php',
        data: {
          queryId: 'selectyear',
          params: {
            ABEGIN:selectdata-2,
            END:selectdata,
          },
          condition:'',
        },
        dataSrc:'',
        success: function(response)
        {
          var selectyeararray = JSON.parse(response).data; 
          jsondata.YEARSPAN = []; 
          for (var i = 0; i < selectyeararray.length; i++) {
            jsondata.YEARSPAN.push(selectyeararray[i].AYEAR);
          }
          // console.log(jsondata.YEARSPAN)
          SUM_DEPTOTAL_MONTH(jsondata.YEARSPAN.length)
          if(jsondata.YEARSPAN.length === 1)
          {
            $("#myspan").text("รายงานรายได้ 1 ปี");
          }
          else
          {
            var minYear = Math.min(...jsondata.YEARSPAN);
            var maxYear = Math.max(...jsondata.YEARSPAN);
            $("#myspan").text("รายงานเปรียบเทียบรายได้ย้อนหลัง: " + minYear + " - " + maxYear);
          }

        },
        error: function(xhr, status, error)
        {
          console.error(error);
        }
      });
    }
    
    function SUM_DEPTOTAL_MONTH(dyear)
    {
        $.ajax({
        url: 'ajax_data.php',
        data: {
          queryId: 'total',
          params: {
            datasend:JSON.stringify(jsondata),
          },
          condition:'Mouth',
          count:12,
          countyear:dyear,
        },
        dataSrc:'',
        success: function(response){
          // console.log(response);
          var responseObject = JSON.parse(response); // เปลี่ยนชื่อตัวแปรเป็น responseObject สำหรับความชัดเจน
          console.log(responseObject); // แสดงวัตถุ JSON ที่ได้หลังจากแปลง

          var dataArray = responseObject.data; // เข้าถึงข้อมูลที่อยู่ใน key 'data'
          console.log(dataArray); // แสดงอาร์เรย์ที่ได้หลังจากแปลง
          FuccategorizedData(dataArray)
          if ($.fn.DataTable.isDataTable('#mytable')) {
            $('#mytable').DataTable().destroy();
          }
          CreateTable()
          generateRandomData(categorizedData)
        },
        error: function(xhr, status, error)
        {
          console.error(error);
        }
      });
    }

  var categorizedData = {};

    function FuccategorizedData(dataArray)
      {
        // var data = dataArray;
        categorizedData = {};
        dataArray.forEach(item => 
        {
          const year = item["Year"];
          const month = item["Mouth"];
          const totalAmt = item["TOTALAMT"];

          if (!categorizedData[year])
          {
            categorizedData[year] = [];
          }

          categorizedData[year].push({ month, totalAmt });
        });
        console.log(categorizedData);
      }


  function CreateTable()
  {
    var tableHead = $("#mytable thead");
    tableHead.empty();
    var tableBody = $("#mytable tbody");
    tableBody.empty();
    var tableFoot = $("#mytable tfoot");
    tableFoot.empty();
    var headRow = $("<tr></tr>");
    var tablecheck = true;

    if (Object.keys(categorizedData).length === 0) {
      // ไม่มีข้อมูล
      tablecheck = false;
      headRow.append($("<th>ไม่มีข้อมูล</th>"));
    } else {
      headRow.append($("<th>ลำดับที่</th>"));
      headRow.append($("<th>เดือน</th>"));
      for (var year in categorizedData) {
        headRow.append($("<th>" + 'ปี' + year + "</th>"));
      }
    }

    tableHead.append(headRow);

    if (Object.keys(categorizedData).length === 0) {
      // ไม่มีข้อมูล
      var emptyRow = $("<tr></tr>");
      emptyRow.append($("<td>ไม่มีข้อมูล</td>"));
      tableBody.append(emptyRow);
    } else {
      // var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
      var months = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "พฤษภาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
      months.forEach((month, index) => {
        var bodyRow = $("<tr></tr>");
        bodyRow.append($("<td>" + (index + 1) + "</td>"));
        bodyRow.append($("<td>" + month + "</td>"));
        for (var year in categorizedData) {
          var yearData = categorizedData[year];
          var found = false;
          yearData.forEach(data => {
            if (data.month === (index + 1).toString()) {
              bodyRow.append($("<td class='text-end'>" + formatCurrency(data.totalAmt) + "</td>"));
              found = true;
            }
          });
          if (!found) {
            bodyRow.append($("<td></td>"));
          }
        }
        tableBody.append(bodyRow);
      });

      var totalRow = $("<tr class='table-success'></tr>"); // เพิ่มแถวผลรวม
      totalRow.append($("<td>รวม</td>")); // เพิ่มเซลล์รวมสำหรับ 2 คอลัมน์แรก
      totalRow.append($("<td>รวม</td>"));
      for (var year in categorizedData) {
        var yearData = categorizedData[year];
        var yearTotal = yearData.reduce(function (sum, data) {
          var totalAmt = parseFloat(data.totalAmt);
          if (!isNaN(totalAmt)) {
            return sum + totalAmt;
          }
          return sum;
        }, 0);
        totalRow.append($("<td class='text-end'>" + formatCurrency(yearTotal.toFixed(2)) + "</td>")); // เพิ่มเซลล์ผลรวมสำหรับแต่ละปี
      }
      tableFoot.append(totalRow);
    }
  
    if (tablecheck) 
    {
      // สร้าง DataTables ใหม่
      $('#mytable').DataTable({
        "dom": 'frtip',
        "pageLength": 13,
        "ordering": false,
        "paging": false,
        "info": false,
        "searching": false,
        scrollX: true,
        columnDefs: [{
        "visible": false,
        "targets": 0
      }],
      });
    } else {
      // สร้าง DataTables ใหม่
      $('#mytable').DataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "searching": false,
        "dom": 'Bfrltip', 
      });
    }
}


      function generateRandomData(datasetChart)
      { 
        const updatedDatasetChart = { ...datasetChart };
        for (const year in updatedDatasetChart) {
          updatedDatasetChart[year] = updatedDatasetChart[year].map(obj => {
            if (obj.totalAmt === '') {
              obj.totalAmt = null;
            }
            return obj;
          });
        }
        const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const datasets = [];
        var countchart = 0;
        for (const year in updatedDatasetChart)
        {
          const data = updatedDatasetChart[year].map(obj => obj.totalAmt);
          console.log(data)
          datasets.push({
            label: year,
            data: data,
            backgroundColor: generateRandomColors(countchart,0.2) ,
            borderColor: generateRandomColors(countchart,1) ,
            borderWidth: 1,
            skipNull: true  // Skip null values
          });
          countchart++;
       }
        datachart = {
          labels,
          datasets
        };
        myChart.data = datachart;
        myChart.update();
      }

      // Function to generate random colors
      function generateRandomColors(countchart,alpha)
      {
        const randomColors = [
        `rgba(255, 26, 104, ${alpha})`,
          `rgba(54, 162, 235, ${alpha})`,
          `rgba(255, 206, 86, ${alpha})`
        ];
        // const red = Math.floor(Math.random() * 256);
        // const green = Math.floor(Math.random() * 256);
        // const blue = Math.floor(Math.random() * 256);
        // randomColors.push(`rgba(${red}, ${green}, ${blue}, ${alpha})`);

        return randomColors[countchart];
      }

    
const formatCurrency = (amount) => {
  if (amount === '') {
    return '';
  }
  let formattedAmount = parseFloat(amount).toFixed(2);
  formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  // formattedAmount += '฿';
  return formattedAmount;
};

  });
</script>

  </body>
</html>