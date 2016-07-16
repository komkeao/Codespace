<!DOCTYPE html>
<?php include "template/pdo.php";
session_start();
if(isset($_POST["username"])){
	$username=$_POST["username"];
	$email=$_POST["email"];
	$password=$_POST["password"];
	$temp=$pdo->query("select * from member where username ='$username'");
	if($temp->fetch()){
		header("location:register.php?err=1");
		}else{
			$pdo->exec("insert into member values('','$username','$email','$password')");
			$_SESSION["username"]=$username;
				header("location:index.php");
			}
	}
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
			<h1>Register</h1><br><br>
			<form action="register.php" method="post" class="form-group">
            <fieldset>
            <div class='form-horizontal col-lg-5 col-md-6 col-sm-8 col-xs-12' align="left">
            <?php 
			if(isset($_GET["err"])){
			?>
            <font color="#FF0000">Username Not Available</font>
            <?php } ?>
            <br>
            <label for="username">Username:</label>
            <input class="form-control" type="text" name="username" autofocus required>
            <label for="email">Email:</label>
            <input class="form-control" type="email" name="email" required>
            <label for="password">Password:</label>
			<input class="form-control" type="password" name="password" required><br>
			<input class="form-control" type="submit" value="Send">
            </div>
            <div class='form-horizontal col-lg-6 col-md-6 col-sm-8 col-xs-12' align="left">
            <h3>ข้อตกลงในการสมัครสมาชิก</h3>
            <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เว็บไซต์นี้ได้จัดทำขึ้นเพื่อให้บริการฝาก SourceCode ออนไลน์เพื่อป้องกันการสูญหายของ SourceCode
            โดยท่านสารมาถที่จะเผยแพร่แบบสาธารณะ (Public) หรือซ่อน (Private) SourceCode ของท่านได้<br>
            <font color="#FF0000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ทางเราไม่ขอรับประกันความเสียหายไม่มีส่วนรู้เห็น SourceCode ที่อาจเกิดจาเหตุขัดข้องใดๆทั้งสิ้น </font>
            </div></fieldset>
            </form>
       </div>
    </div>
</div>
<hr>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>