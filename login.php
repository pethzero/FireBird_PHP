<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=0.6">
		<link rel="stylesheet" href="css/login.css">
		<title>INDUSTRIAL LOGIC</title>
   
   		<?php
		?>

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
				value="komkrid"
				required>
				<label>Username</label>
			</div>

			<div class="field">
				<input type="password" name="password" 
				value="1234"
				required>
				<label>Password</label>
			</div>

			<div class="content">
				<div class="checkbox">
					<input type="checkbox" id="remember-me" name="remember">
					<label for="remember-me">Remember me</label>
				</div>
			</div>

			<div class="field">
				<input type="submit" value="Login">
			</div>
		</form>
	</div>
</body>
</html>
