<?php
	session_start();

	if (isset($_POST["username"]))
	{
		include('sysutils.php');
        include("connect.php");  
		
		$username = $_POST["username"];
		$password = $_POST["password"];
		$sql = "SELECT RECNO, EMPNO, EMPNAME, PASS, WEBMAN, WEBPD, WEBST, WEBHR FROM EMPL WHERE UPPER(LOGIN)=:LOGIN";
		$query = $pdo->prepare($sql);
		$query->execute(array(strtoupper($username)));
		$row = $query->fetch();
		if (empty($row) == false)
		{
			if (iconv('TIS-620', 'UTF-8//TRANSLIT//IGNORE', $row["PASS"]) == $password)
			{
				if (($row["WEBMAN"] == 'T') or ($row["WEBPD"] == 'T') or ($row["WEBST"] == 'T') or ($row["WEBHR"] == 'T'))
				{
					$_SESSION["RECNO"] = textutf8($row["RECNO"]);
					$_SESSION["EMPNO"] = textutf8($row["EMPNO"]);
					$_SESSION["EMPNAME"] = textutf8($row["EMPNAME"]);
					$_SESSION["PASS"] =   textutf8($row["PASS"]);
					$_SESSION["WEBMAN"] = textutf8($row["WEBMAN"]);
					$_SESSION["WEBPD"] = textutf8($row["WEBPD"]);
					$_SESSION["WEBST"] = textutf8($row["WEBST"]);
					$_SESSION["WEBHR"] = textutf8($row["WEBHR"]);
					// $_SESSION["RECNO"] =   $row["RECNO"];
					// $_SESSION["EMPNO"] =   $row["EMPNO"];
					// $_SESSION["EMPNAME"] = $row["EMPNAME"];
					// $_SESSION["PASS"] =    $row["PASS"];
					// $_SESSION["WEBMAN"] =  $row["WEBMAN"];
					// $_SESSION["WEBPD"] =   $row["WEBPD"];
					// $_SESSION["WEBST"] =   $row["WEBST"];
					// $_SESSION["WEBHR"] =   $row["WEBHR"];

					header("Location: main.php");
				}
				else
				{
					echo "<script>";
					echo "alert(\" ท่านไม่ได้รับสิทธิเข้าใช้งานระบบ\");"; 
					echo "window.history.back()";
					echo "</script>";
				}					
			}
			else
			{
				echo "<script>";
				echo "alert(\" password ไม่ถูกต้อง\");"; 
				echo "window.history.back()";
				echo "</script>";
			}
		}
		else
		{
			echo "<script>";
			echo "alert(\" user ไม่ถูกต้อง\");"; 
			echo "window.history.back()";
			echo "</script>";
		}
	}
?>

