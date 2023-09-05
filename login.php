<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=0.6">
		<link rel="stylesheet" href="css/login.css">
		<title>INDUSTRIAL LOGIC</title>
   		<?php
		?>
<link rel="stylesheet" href="css/bootstrap-5.3.0.min.css">

</head>

<?php 
session_start(); 
if (isset($_SESSION["RECNO"])) 
{
  header("Location: main.php"); // ตัวอย่างการเด้งไปยังหน้า login.php
  exit(); // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
}
?>
<body>
	<div class="wrapper">
	<div class="title">
		INDUSTRIAL LOGIC
	</div>

		<form name="formlogin" action="ajax_check.php" method="post" id="login">

			<div class="field">
				<input type="text" name="username" 
				value="<?php echo isset($_COOKIE['remember_username']) ? $_COOKIE['remember_username'] : ''; ?>"
				required>
				<label>Username</label>
			</div>

			<div class="field">
				<input type="password" name="password" 
				value="<?php echo isset($_COOKIE['remember_password']) ? $_COOKIE['remember_password'] : ''; ?>"
				required>
				<label>Password</label>
			</div>

			<div class="content">
				<div class="checkbox">
				<input type="checkbox" id="remember-me"
				<?php echo isset($_COOKIE['remember_check']) ? 'checked' : ''; ?>
				name="remember">
					<label for="remember-me">Remember me</label>
				</div>
			
			</div>

			<div class="content">
				<div class="link">
				<a id="forgotPasswordLink" href="#">Forgot Password?</a>
				</div>
			</div>

			

			<div class="field">
				<input type="submit" value="Login">
			</div>
		</form>
	</div>
</body>
<script src="js/jquery-3.6.0.min.js" rel="preload" as="script"></script>
<script src="js/bootstrap.bundle.min.js" rel="preload" as="script"></script>
<script src="js/sweetalert2.all.min.js" rel="preload" as="script"></script>

<script>
        // Example: Show SweetAlert when Forgot Password link is clicked
		document.getElementById('forgotPasswordLink').addEventListener('click', function(event) {
			event.preventDefault(); // ป้องกันการเปลี่ยนหน้าเว็บ

			// เพิ่มการใช้งาน SweetAlert หรือปรับแต่งตามที่คุณต้องการ
			// ตัวอย่าง: แสดง SweetAlert เมื่อคลิกที่ลิงก์
			Swal.fire({
				title: 'ลืมรหัสผ่าน',
				text: 'ตอนนี้ กดได้ เฉยๆ ยังไม่มีอะไรหลอก',
				icon: 'info',
				confirmButtonText: 'OK'
			});
		});
    </script>
</html>
