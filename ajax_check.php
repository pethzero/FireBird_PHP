<?php
session_start();

if (isset($_POST["username"])) {
	include("connect_sql.php");
	$username = $_POST["username"];
	$password = $_POST["password"];
	$sql = "SELECT ID,RECNO, EMPNO, EMPNAME, PASS,IMG,USERLEVEL,PERMISSION FROM empl WHERE UPPER(LOGIN)=:LOGIN";
	//////////////////////////////////////
	$query = $pdo->prepare($sql);
	// ผูกค่าพารามิเตอร์
	$query->bindParam(':LOGIN', $username, PDO::PARAM_STR);
	$query->execute();
	//////////////////////////////////////
	$row = $query->fetch(PDO::FETCH_ASSOC);
	if (empty($row) == false) {
		if ($row["PASS"] == $password) {
			if (true) {
				if ($_POST["remember"]) { // ตรวจสอบว่าถูกติ๊กหรือไม่
					// สร้างคุกกี้เก็บข้อมูลเข้าสู่ระบบ
					setcookie("remember_username", $username, time() + 3600 * 24 * 30, "/");
					setcookie("remember_password", $password, time() + 3600 * 24 * 30, "/");
					setcookie("remember_check", $_POST["remember"], time() + 3600 * 24 * 30, "/");
				} else {
					// ลบคุกกี้เมื่อไม่เลือก Remember me
					setcookie("remember_username", "", time() - 3600, "/");
					setcookie("remember_password", "", time() - 3600, "/");
					setcookie("remember_check", "", time() - 3600, "/");
				}

				$_SESSION["ID"] =   $row["ID"];
				$_SESSION["RECNO"] =   $row["RECNO"];
				$_SESSION["EMPNO"] =   $row["EMPNO"];
				$_SESSION["EMPNAME"] = $row["EMPNAME"];
				$_SESSION["USERLEVEL"] =   $row["USERLEVEL"];
				$_SESSION["PASS"] =    $row["PASS"];
				$_SESSION["PERMISSION"] =  $row["PERMISSION"];

				if ($row["IMG"] != '') {
					$_SESSION["IMAGEEMPL"] = '<img src="images/' . $row["IMG"] . '" width="40" height="40" class="rounded-circle">';
				} else {
					$_SESSION["IMAGEEMPL"] = '<img src="images/fox.jpg" width="40" height="40" class="rounded-circle">';
				}
				// $_SESSION["WEBMAN"] =  $row["WEBMAN"];
				// $_SESSION["WEBPD"] =   $row["WEBPD"];
				// $_SESSION["WEBST"] =   $row["WEBST"];
				// $_SESSION["WEBHR"] =   $row["WEBHR"];
				// $base64Data = base64_encode($row["USERIMG"]);
				// if ($base64Data) {
				// 	$_SESSION["IMAGEEMPL"] = '<img src="data:image/jpeg;base64,' . $base64Data . '" width="40" height="40" class="rounded-circle">';
				// } else {
				// 	$_SESSION["IMAGEEMPL"] = '<img src="images/fox.jpg" width="40" height="40" class="rounded-circle">';
				// }


				header("Location: main.php");
			} else {
				echo "<script>";
				echo "alert(\" ท่านไม่ได้รับสิทธิเข้าใช้งานระบบ\");";
				echo "window.history.back()";
				echo "</script>";
			}
		} else {
			echo "<script>";
			echo "alert(\" password ไม่ถูกต้อง\");";
			echo "window.history.back()";
			echo "</script>";
		}
	} else {
		echo "<script>";
		echo "alert(\" user ไม่ถูกต้อง\");";
		echo "window.history.back()";
		echo "</script>";
	}
}
