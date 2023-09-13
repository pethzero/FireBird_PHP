<?php
	session_start();

	if (isset($_POST["username"]))
	{
		include('sysutils.php');
         include("connect_sql.php");  
		
		$username = texttis620($_POST["username"]);
		$password = texttis620($_POST["password"]);
		$sql = "SELECT RECNO, EMPNO, EMPNAME, PASS, WEBMAN, WEBPD, WEBST, WEBHR,USERIMG FROM EMPL WHERE UPPER(LOGIN)=:LOGIN";
		// echo $username;
		// echo $sql; 
		// echo array(strtoupper($username));
		
		//////////////////////////////////////
		$query = $pdo->prepare($sql);
		// ผูกค่าพารามิเตอร์
		$query->bindParam(':LOGIN', $username, PDO::PARAM_STR);
		// หรือถ้าคุณใช้ bindValue ก็ได้
		// $stmt->bindValue(':LOGIN', $login, PDO::PARAM_STR);
		// ทำการ execute คำสั่ง
		$query->execute();

		// $query->execute(array(':LOGIN' => strtoupper($username)));
		// ดึงข้อมูลออกมาด้วย FETCH_ASSOC
		// while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
		// 	// ดำเนินการกับข้อมูลที่ได้ตามต้องการ
		// 	// $row['RECNO'], $row['EMPNO'], $row['EMPNAME'], ...
		// }
		//////////////////////////////////////
		$row = $query->fetch(PDO::FETCH_ASSOC);

		// echo '<br>GET'. empty($row);
		// if ($row) {
		// 	// ดำเนินการกับข้อมูลที่ได้ตามต้องการ
		// 	// $row['RECNO'], $row['EMPNO'], $row['EMPNAME'], ...
		// 	echo 'true';
		// } else {
		// 	echo 'ไม่พบข้อมูล';
		// }

		// $row = $query->fetch();
		// echo '<br>get' . $row;
		if (empty($row) == false)
		{
			if ($row["PASS"] == $password)
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

