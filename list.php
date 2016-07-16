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
        <form  method="get" action="list.php" class="form-inline">
        <div class="form-group">
        <label for="keyword">Search Now</label>
        <input class="form-control" type="text" value="<?php 
			if(isset($_GET["keyword"])){
				echo $_GET["keyword"];
			}else{
				echo "";
				}
			
		 ?>" name="keyword">
        <input class="form-control" type="submit" value="Search">
        </div>
        </form>
        <br><h2>Result:</h2><br>
        <table class="table-responsive table" border="1">
        <tr>
        <th style="max-width:20px;">#</th><th>Title</th><th>Owner</th><th>Date</th>
        <?php 
		$temp=$pdo->query("select * from source where status ='public' order by id DESC");
		$Num_Rows=0;
		if(isset($_GET["keyword"])){//มีการส่ง KEyword มา
			$key=$_GET["keyword"];
				if(isset($_SESSION["username"])){
					$username=$_SESSION["username"];
					$sql="select * from source where name like '%$key%' and (status='public' or own='$username') order by id DESC";
				}else{
					$sql="select * from source where status='public' and name like '%$key%' order by id DESC";
				}
			$s=$pdo->query($sql);
				while($s->fetch()){
					$Num_Rows++;
				}
		}else if(isset($_GET["tag"])){//มีการส่งสินtagค้ามา
			$tag=$_GET["tag"];
				if(isset($_SESSION["username"])){
					$username=$_SESSION["username"];
					$sql="select * from source where type like '%$tag%' and (status='public' or own='$username') order by id DESC";
				}else{
					$sql="select * from source where status='public' and type like '%$tag%' order by id DESC";
				}
			$s=$pdo->query($sql);
				while($s->fetch()){
					$Num_Rows++;
				}
			}else{//ถ้าไม่มีการส่ง Keyword มาค้นหา ให้แสดงสินค้าทั้งหมด
				if(isset($_SESSION["username"])){
					$username=$_SESSION["username"];
					$sql="select * from source where status='public' or own='$username' order by id DESC";
				}else{
					$sql="select * from source where status='public' order by id DESC";
				}
				$s=$pdo->query($sql);		
				while($s->fetch()){
					$Num_Rows++;
				}
			}//////////////////////ระบบแบ่งหน้าสินค้า///////////////////
			$Per_Page = 5; 
			if(isset($_GET["Page"])){
			$Page = $_GET["Page"];
			}else{
				$Page=1;
			}
			$Prev_Page = $Page-1;
			$Next_Page = $Page+1;
			$Page_Start = (($Per_Page*$Page)-$Per_Page);
			if($Num_Rows<=$Per_Page){
				$Num_Pages =1;
			}
			else if(($Num_Rows % $Per_Page)==0){
				$Num_Pages =($Num_Rows/$Per_Page) ;
			}
			else{
				$Num_Pages =($Num_Rows/$Per_Page)+1;
				$Num_Pages = (int)$Num_Pages;
			}
					$text="";
					if(isset($_GET["keyword"])){//ส่งคีย์เวิร์ด
						if(isset($_SESSION["username"])){
						$key=$_GET["keyword"];
							$username=$_SESSION["username"];
							$obj="select * from source where name like '%$key%' and (status='public' or own='$username') order by id DESC LIMIT ".$Page_Start." , ".$Per_Page."";
						}else{
							$obj="select * from source where status='public' and name like '%$key%' order by id DESC LIMIT ".$Page_Start." , ".$Per_Page."";
						}
						$index="&keyword=$key";
					}else if(isset($_GET["tag"])){//มีการส่งสินtagค้ามา
						if(isset($_SESSION["username"])){
							$username=$_SESSION["username"];
							$obj="select * from source where type like '%$tag%' and (status='public' or own='$username') order by id DESC LIMIT ".$Page_Start." , ".$Per_Page."";
						}else{
							$obj="select * from source where status='public' and type like '%$tag%' order by id DESC LIMIT ".$Page_Start." , ".$Per_Page."";
						}
						$index="&tag=$tag";
						
					}else{//ถ้าไม่มีการส่ง Keyword มาค้นหา ให้แสดงสินค้าทั้งหมด
						if(isset($_SESSION["username"])){
							$username=$_SESSION["username"];
							$obj="select * from source where status='public' or own='$username' order by id DESC LIMIT ".$Page_Start." , ".$Per_Page."";
						}else{
							$obj="select * from source where status='public' order by id DESC LIMIT ".$Page_Start." , ".$Per_Page."";
						}
						$index="";
					}					
			$objQuery  = $pdo->query($obj);
			$num=0;
					while($objResult=$objQuery->fetch()){
						$num++;
				$title=$objResult["name"];
				$owner=$objResult["own"];
				$date=$objResult["cur_date"];
				$id=$objResult["id"];
				echo"
				<tr>
				<td style='max-width:20px;'>$num</td>
				<td><a href='viewSource.php?id=$id'>$title</a></td>
				<td>$owner</td>
				<td>$date</td>
				
				</tr>
				";
			}
			
		
		?>
        </tr>
        </table>
		<?php		
			echo "<div align='center' style='font-size:130%'>Found! ". $Num_Rows." Source: ".$Num_Pages." Pages <br>";
			if($Prev_Page)			{	
				echo " <a href='$_SERVER[SCRIPT_NAME]?Page=".$Prev_Page.$index."'>Back</a> ";
			}
			for($i=1; $i<=$Num_Pages; $i++){
				if($i != $Page){
					echo " <a href='$_SERVER[SCRIPT_NAME]?Page=".$i.$index."'>[$i]</a> ";
				}
				else{
					echo "<b> $i </b>";
				}
			}
			if($Page!=$Num_Pages){
				echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page".$index."'>Next</a> ";
			}
echo "</div>"; ?>
			
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</div>
<hr>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>