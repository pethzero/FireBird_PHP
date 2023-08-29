<?php
	session_start();

	if (isset($_POST["username"]))
	{
		include("connect_sql.php"); 
		$username = $_POST["username"];
		$password = $_POST["password"];
		$sql = "SELECT RECNO, EMPNO, EMPNAME, PASS, WEBMAN, WEBPD, WEBST, WEBHR,USERIMG FROM empl WHERE UPPER(LOGIN)=:LOGIN";
		//////////////////////////////////////
		$query = $pdo->prepare($sql);
		$query->bindParam(':LOGIN', $username, PDO::PARAM_STR);
		$query->execute();
		//////////////////////////////////////
		$row = $query->fetch(PDO::FETCH_ASSOC);
		if (empty($row) == false)
		{
			if ($row["PASS"] == $password)
			{
				if (($row["WEBMAN"] == 'T') or ($row["WEBPD"] == 'T') or ($row["WEBST"] == 'T') or ($row["WEBHR"] == 'T'))
				{
					$_SESSION["RECNO"] =   $row["RECNO"];
					$_SESSION["EMPNO"] =   $row["EMPNO"];
					$_SESSION["EMPNAME"] = $row["EMPNAME"];
					$_SESSION["PASS"] =    $row["PASS"];
					$_SESSION["WEBMAN"] =  $row["WEBMAN"];
					$_SESSION["WEBPD"] =   $row["WEBPD"];
					$_SESSION["WEBST"] =   $row["WEBST"];
					$_SESSION["WEBHR"] =   $row["WEBHR"];
					$base64Data = base64_encode($row["USERIMG"]);
					if ($base64Data) {
						$_SESSION["IMAGEEMPL"] = '<img src="data:image/jpeg;base64,' . $base64Data . '" width="40" height="40" class="rounded-circle">';
					} else {
						$_SESSION["IMAGEEMPL"] = '<img src="images/fox.jpg" width="40" height="40" class="rounded-circle">';
					}
	

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

