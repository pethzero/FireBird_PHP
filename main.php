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
    include("0_headcss.php"); 
    ?>
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
    height: 200px; /* Adjust the height to your desired value */
    object-fit: cover; /* This ensures the image fills the entire space while maintaining aspect ratio */
  }
</style>
  <?php 

      include("0_header.php"); 
      include("0_breadcrumb.php"); 
  ?>
    
    <div class="section">
      <div class="container">
        <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
             <h2 class="card-title">ฝ่ายขาย</h2>
             <p class="card-text">
             <ul>
              <li><a href="dataqoud.php" >ใบเสนอราคา</a></li>
              <li><a href="datatable_activity.php" >ตารางหนัดหมาย</a></li>
              <li><a href="dataactivity.php" >เพิ่มตารางหนัดหมาย</a></li>
            </ul>
             </p>
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
             <h2 class="card-title">ฝ่ายจัดซื้อ</h2>
             <p class="card-text">
                  <ul>
                     <li><a href="datapurc.php" >ใบสั่งซื้อ</a></li>
                  </ul>
             </p>
              <!-- <a class="click-me-btn btn btn-primary" data-number="3" class="btn btn-primary"></a> -->
            </div>
          </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
             <h2 class="card-title">ผลิต</h2>
             <p class="card-text">
              <ul>
                <li><a href="datatablemachine.php">เครื่องจักร(กำลังพัฒนา)</a></li>
              </ul>
             </p>
              <!-- <a class="click-me-btn btn btn-primary" data-number="2" class="btn btn-primary">LINK</a> -->
            </div>
          </div>
        </div>

    

        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
          <div class="card">
            <img class="card-img-top img-thumbnail" src="doc/pr.jpg" alt="Card image cap">
            <div class="card-body">
             <h2 class="card-title">สโตร์</h2>
             <p class="card-text">
              <ul>
                <li><a href="datainvent.php" >ดูสินค้า</a></li>
                <li><a href="datastock.php" >ใบเบิกสินค้า</a></li>
              </ul>
             </p>
              <!-- <a class="click-me-btn btn btn-primary" data-number="4" class="btn btn-primary">LINK</a> -->
            </div>
          </div>
        </div>
          
        </div>
      </div>
    </div>
 <hr>
    <div class="section">
      <div class="container pt-2">
        <h1> NEW FEATURE</h1>
        <div class="row" id='subweb'>
        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
             <button class="btn btn-primary" onclick="window.location='datatable_activity.php';">ดูตารางนัดหมาย</button>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
             <button class="btn btn-primary" onclick="window.location='datatable_activity.php';">สร้างตารางนัดหมาย</button>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 pt-2">
             <button class="btn btn-primary" onclick="window.location='datargdrawing.php';">ลงทะเบียน DRAWING</button>
        </div>

        </div>
      </div>
    </div>
 <!-- <hr> -->
    


    <?php include("0_footer.php"); ?>
  </body>
  <?php 
  include("0_footerjs.php"); 
  ?>


<script>
    $(document).ready(function() {
    //   var data = [
    //   {
    //     type: "ฝ่าย",
    //     name: "ใบเสนอราคา",
    //     link: "dataqoud.php",
    //   },
    //   {
    //     type: "ผลิต",
    //     name: "ชื่อผลิตภัณฑ์ 1",
    //     link: "link_product_1.php",
    //   },
    //   {
    //     type: "ผลิต",
    //     name: "ชื่อผลิตภัณฑ์ 2",
    //     link: "link_product_2.php",
    //   },
    //   {
    //     type: "บริหาร",
    //     name: "หัวหน้าบริหาร",
    //     link: "link_management.php",
    //   },
    // ];

    //   $(".click-me-btn").click(function() {
    //     var number = $(this).data("number");
    //     myFunction(number);
    //   });

    //   function myFunction(number) {
    //     // Clear the existing cards
    //     $("#subweb").empty();

    //     // Filter the data based on the selected number
    //     var filteredData = data.filter(function(item) {
    //     return item.type === (number === 1 ? "ฝ่าย" : number === 2 ? "ผลิต" : number === 3 ? "บริหาร" : "สโตร์");
    //   });

    //     // Generate HTML for each item in the filtered data
    //     $.each(filteredData, function(index, item) {
    //       var newCardHTML = `
    //       <div class="col-md-12 mb-4">
    //            <a href="${item.link}" class="btn btn-custom">${item.name}</a>
    //        </div>
    //       `;
    //       $("#subweb").append(newCardHTML);
    //     });
    //   }
    });
  </script>

</html>
