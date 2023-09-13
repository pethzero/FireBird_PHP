<?php
	session_start();

	if (true)
	{
		include("connect_sql.php"); 
		echo 'ZZZ';
		$username = 'superadmin';
		$password = '1234';
		 $sql = "SELECT RECNO, EMPNO, EMPNAME, PASS, WEBMAN, WEBPD, WEBST, WEBHR,USERIMG FROM EMPL WHERE UPPER(LOGIN)=:LOGIN";
		echo $sql;
		echo $username;
		echo $password;
	    $query = $pdo->prepare($sql);
		$query->bindParam(':LOGIN', $username, PDO::PARAM_STR);
		$query->execute();
		//////////////////////////////////////
		$row = $query->fetch(PDO::FETCH_ASSOC);
		echo 'end';
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
					// header("Location: main.php");
					echo 'PASS';
				}
				else
				{
					echo 'cc';
				}					
			}
			else
			{
			    echo 'password aa';
			}
		}
		
		echo 'suck';
	}
?>

