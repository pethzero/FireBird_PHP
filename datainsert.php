<!DOCTYPE html>
<html lang="en">
  <head>
    <?php
    // header("Content-Type: text/html; charset=UTF-8");
    // header("Content-Type: text/html; charset=TIS-620");
    ?>
    <meta charset="UTF-8">
    <!-- <meta charset="utf-8"> -->
    <!-- <meta http-equiv="Content-Language" content="th"> -->
    <!-- <meta http-equiv="content-Type" content="text/html; charset=window-874"> -->
    <!-- <meta http-equiv="content-Type" content="text/html; charset=TIS-620"> -->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web App</title>

    <?php include("0_headcss.php"); ?>
  </head>
  <body>
  <style>
    .container-layout 
    {
    margin-left: auto;
    margin-right: auto;
          /* padding-top: 20px;
      padding-bottom: 20px;
      margin-top: -20px;
      margin-bottom: -20px; */
    /* background-color: lightgray; */
  }

@media (min-width: 576px) {
  .container-layout {
    max-width: 540px;
  }
}

@media (min-width: 768px) {
  .container-layout {
    max-width: 720px;
    /* padding: 20px; */
  }
}

@media (min-width: 992px) {
  .container-layout {
    max-width: 960px;
    /* padding: 30px;
    margin: 0 auto; */
  }
}

@media (min-width: 1200px) {
  .container-layout {
    max-width: 1500px;
    padding-left: 40px;
    padding-right: 40px;
  
  }
}

    </style>
  <!-- <?php
	// session_start();
?> -->

    <?php
    //  include("header.php"); 
    //  include("connect.php");
    ?>
    <form id="myForm">
    <section>
      <div class=" text-center" style="background: url(images/blue-001.jpg) no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
        <div class="container">
          <div class="row pb-3">
            <div class="col-12" align="center">
              <!-- <h1><img src="images/mypcu_academy_logo_tp.png"  alt=""/></h1> -->
              <h1>ยินดีต้อนรับสู่ WEB APP</h1>
              <!-- <p></p>            -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <hr>


    <section>
  <div class="container-layout">
    <h2>Data INVENT</h2>
    <div class="row">
      <div class="col-md-3 col-12">
        <label for="recnodata">RECNO</label>
        <input type="number" class="form-control" id="recnodata" value=1 placeholder="RECNO input">
      </div>
      <div class="col-md-3 col-12">
        <label for="codedata">Code</label>
        <input type="text" class="form-control" id="codedata" placeholder="Code input">
      </div>
      <div class="col-md-3 col-12">
        <label for="unitdata">Unit</label>
        <input type="text" class="form-control" id="unitdata" placeholder="Unit input">
      </div>
      <div class="col-md-3 col-12">
        <label for="amtdata">Amt</label>
        <input type="text" class="form-control" id="amtdata" placeholder="Amt input">
      </div>
    </div>
    <button type="submit" id="submitButton" class="btn btn-primary mt-3 float-right">Submit</button>
  </div>
</section>

    <hr>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-12">
            <h3 class="text-center">&nbsp;</h3>
          </div>
          <div class="col-md-4 col-12">
            <h3 class="text-center">SAN Co.,Ltd.</h3>
            <address class="text-center">
            </address>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <footer class="text-center">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <p>Copyright ? SAN Co.,Ltd. All rights reserved.</p>
          </div>
        </div>
      </div>
    </footer>
    </form>

    <!-- <script src="js/columns.js" rel="preload" as="script"></script>
    <script src="js/chart-4.3.0.js" rel="preload" as="script"></script>
    <script src="js/jquery-3.5.1.js" rel="preload" as="script"></script>
    <script src="js/popper.min.js" rel="preload" as="script"></script>
    <script src="js/bootstrap-4.3.1.js" rel="preload" as="script"></script>
    <script src="js/jquery.dataTables.js" rel="preload" as="script"></script> -->
    <?php 
  include("0_footerjs.php");
   ?>
  </body>

  <script>
    $(document).ready(function() {
  // เมื่อกดปุ่ม Submit
  $('#submitButton').click(function(e) {
      e.preventDefault(); // ป้องกันการรีเฟรชหน้า


        $.ajax({
        url: 'ajax_dinsert.php',
        method: 'GET',
        data: {
          // queryId: '0003',
          queryId:'0003',
          condition:'I',
          params: { // อาร์เรย์ params ที่คุณต้องการส่ง
              RECNO:$('#recnodata').val(),
              CODE: $('#codedata').val()
            }
        },
  success: function(response) {
    if (response.status === 'success') {
      // การส่งข้อมูลสำเร็จ
      console.log(response.message);
      // ดำเนินการต่อตามต้องการ
    } else {
      // การส่งข้อมูลไม่สำเร็จ
      console.error(response.message);
      // ดำเนินการต่อตามต้องการหรือแสดงข้อความผิดพลาด
    }
  },
  error: function(xhr, status, error) {
    // จัดการข้อผิดพลาดที่เกิดขึ้น
    console.error(error);
  }
});


    });
  });

    </script>
</html>