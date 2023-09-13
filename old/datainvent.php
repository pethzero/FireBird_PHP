<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
       session_start(); 
    if (!isset($_SESSION["RECNO"])) 
      {
        header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
        exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
      } 
     include("0_headcss.php"); ?>
    <link rel="preload" href="css/loader.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
    <link rel="stylesheet" href="css/loader.css">
    </noscript>

  </head>
  <body>
  <style>
    @media (max-width: 992px)
    {
      .chartMenu {
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
        width: 95%;
        height: 75%;
        padding: 20px;
        border-radius: 20px;
        border: solid 3px rgba(54, 162, 235, 1);
        background: white;
      }
    }
     
  </style>
  <?php 
    // session_start(); 
    // if (!isset($_SESSION["RECNO"])) 
    //   {
    //     header("Location: index.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
    //     exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    //   } 
      include("0_header.php"); 
      include("0_breadcrumb.php"); 
  ?>

    <section>
      <div class="container">
      <h2>STOCK</h2>
      <div class="row pb-3">
         <div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 ">
          <select name="typenamedata" id="typenamedata" class="form-control"></select>
        </div>
      </div>
        <div class="row">
              <table id="myTable" class="display nowrap table table-striped table-bordered"  width='100%'>
                <thead class="thead-light">
                  <tr>
                    <th>ลำดับ</th>
                    <th>รหัสสินค้า</th>
                    <th>ประเภทสินค้า</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคาต้นทุน</th>
                    <th>ราคาขาย</th>
                    <th>LASTIN</th>
                    <th>LASTOUT</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
          </table>
        </div>
      </div>
    </section>

    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-12">
            <h3 class="text-center">จำนวน STOCK</h3>
              <div class="chartCard">
                <div class="chartBox">
                  <canvas id="myChart"></canvas>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>

    
    <hr>
    <?php include("0_footer.php"); ?>
    <div class="loading">
  </body>
  <?php 
  // include("0_dtcolumn.php");
  ?>
  <?php 
  include("0_footerjs.php");
  
   ?>
    <script src="js/dtcolumn.js" rel="preload" as="script"></script>
  <script>
    $(document).ready(function() 
    {
    // สร้างตัวแปรสำหรับแผนภูมิและการตั้งค่า
  var data_quan = [];
  var data_array = [];
  var encodedURL = encodeURIComponent('ajax_data.php');
 
  var table = $('#myTable').DataTable({
  ajax: {
    url: encodedURL,
    data: function(d) {
      d.queryId = '0005'; // ส่งค่าเป็นพารามิเตอร์ queryId
      d.params = null;
    },
    dataSrc: function(json) {
      console.log(json.data)
      data_array['data_hd'] = json.data;
      return json.data;
    }
  },
  // "dom": '<"top"i>rt<"bottom"flp><"clear">',
  scrollX: true,
  columns: dtcolumn['datainvent'],
  columnDefs: [
    // { "visible": false, "targets": 2}
  ],
  initComplete: function( settings, json ) {
    $('.loading').hide();
      populateTypeNames(data_array['data_hd']);
      createChart(data_array['data_hd']);
  },
});



function populateTypeNames(dataArray){
  var typeNames = [...new Set(dataArray.map(item => item.TYPENAME))];
  $.each(typeNames, function (index, value) {
    $('#typenamedata').append('<option value="' + value + '">' + value + '</option>');
  });}

function createChart(data){
     var tophigh_QUAN = data
    .map(function(item) {
      return {
        PRODNAME: item.CODE+':'+item.PRODNAME,
        QUAN: item.QUAN
      };
    })
    .sort(function(a, b) {
      return b.QUAN - a.QUAN;
    })
    .slice(0, 10)
    .reduce(function(obj, item) {
      obj[item.PRODNAME] = item.QUAN;
      return obj;
    }, {});
  var toplow_QUAN = data
    .map(function(item) {
      return {
        PRODNAME: item.CODE+':'+item.PRODNAME,
        QUAN: item.QUAN
      };
    })
    .sort(function(a, b) {
      return a.QUAN - b.QUAN;
    })
    .slice(0, 10)
    .reduce(function(obj, item) {
      obj[item.PRODNAME] = item.QUAN;
      return obj;
    }, {});

  // Chart.defaults.font.size = 18;
  var topData = Object.values(tophigh_QUAN);
  var lowData = Object.values(toplow_QUAN);
  var topCode = Object.keys(tophigh_QUAN);
  var lowCode = Object.keys(toplow_QUAN);

  var topDataset = {
    label: 'จำนวนสินค้าสูงสุด',
    data: topData,
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1,
    fill: true
    // categoryPercentage: 1,
    // barPercentage: 0.8
  };

  var lowDataset = {
    label: 'จำนวนสินค้าต่ำสุด',
    data: lowData,
    backgroundColor: 'rgba(192, 75, 75, 0.2)',
    borderColor: 'rgba(192, 75, 75, 1)',
    borderWidth: 1,
    fill: true
    // categoryPercentage: 1,
    // barPercentage: 0.8
  };

  const config = {
      type: 'bar',
      data: {
        labels: ['TOP1', 'TOP2', 'TOP3', 'TOP4', 'TOP5','TOP6', 'TOP7', 'TOP8', 'TOP9', 'TOP10'],
        datasets: [topDataset, lowDataset],
      },
      options: {
        // maintainAspectRatio:false,
        scales:{
          y: {
            beginAtZero: true
          }
        },plugins: {
            tooltip: {
              callbacks: {
                label: function(context) {
                  let label = '';
                  if (context.parsed.y !== null) {
                    if (context.datasetIndex === 0) {
                      // Dataset 1 (topDataset)
                      label += topCode[context.dataIndex] + ':' + context.parsed.y;
                    } else if (context.datasetIndex === 1) {
                      // Dataset 2 (lowDataset)
                      label += lowCode[context.dataIndex] + ':' + context.parsed.y;
                    }
                  }
                  return label;
                }
              }
            }
          }
      }
    };
  const myChart = new Chart(
      document.getElementById('myChart'),
      config
    );
}
$('#typenamedata').on('change', function()
{
  const selectedValue = $(this).val(); // ค่าที่ถูกเลือกใน <select>
  $('#myTable').DataTable().column(2).search(selectedValue).draw();
  $('#mytablejump').val('');
});
});
    
  


    </script>
</html>