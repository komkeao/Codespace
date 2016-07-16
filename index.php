<!DOCTYPE html>
<?php include "template/pdo.php";
session_start();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" >
<link href="css/bootstrap-theme.min.css" type="text/css" rel="stylesheet" >
<link href="css/style.css" type="text/css"rel="stylesheet" >
<title>CodeSpace</title>
</head>
<body class="col-lg-12">	
<div align="center">
    <div class="container">
        <?php require "template/menu.php"; ?><!--I'm Menu Bar-->
        <div class="ct"><!--This is Container -->
        <BR><br><h2>New Sorce</h2><br>
        <table class="table-responsive table" border="1">
        <tr>
        <th style="max-width:20px;">#</th><th>Title</th><th>Owner</th><th>Date</th>
        <?php 
		if(isset($_SESSION["username"])){
			$username=$_SESSION["username"];
			$sql="select * from source where status ='public' or own ='$username' order by id DESC";
		}else{
			$sql="select * from source where status ='public' order by id DESC";
		}
		$temp=$pdo->query($sql);
		$i=0;
			while($data=$temp->fetch()){
				if($i==10){
					break;
					}
				$title=$data["name"];
				$owner=$data["own"];
				$date=$data["cur_date"];
				$id=$data["id"];
				$num=$i+1;
				echo"
				<tr>
				<td style='max-width:20px;'>$num</td>
				<td><a href='viewSource.php?id=$id'>$title</a></td>
				<td>$owner</td>
				<td>$date</td>
				
				</tr>
				";
				$i++;
				
			}
		
		?>
        </tr>
        
        </table>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>
<hr>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>