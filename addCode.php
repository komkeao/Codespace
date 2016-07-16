<!DOCTYPE html>
<?php include "template/pdo.php";
session_start();
if(isset($_POST["name"])){//เมื่อมีการส่งข้อมูลจาก Form ให้ดำเนินการ Insert
	$id='';
	$name=$_POST["name"];
	$data=$_POST["data"];
	$own=$_POST["own"];
	$type=$_POST["type"];
	$status=$_POST["status"];
	$cur_date = date("Y-m-d");
	$files=0;
	if(isset($_FILES["file"]["tmp_name"])){//เชคว่ามาการส่งไฟล์หรือไม่
		$files=1;	
	}
	$data=htmlentities($data);
	$sql = 'INSERT INTO source VALUES ( :id, :name, :data , :own, :type, :status, :cur_date, :files)';
	$sth = $pdo->prepare($sql);
	$sth->execute(array(
	  ':id' => $id,
	  ':name' => $name,
	  ':data'=> $data,
	  ':own' => $own,
	  ':type' => $type,
	  ':status' => $status,
	  ':cur_date' => $cur_date,
	  ':files' => $files
	));
	$temp=$pdo->query("select * from source order by id DESC");
	$id=$temp->fetch();
	if($files==1){//if file is found-> Archive file to zip
		$s=$id["id"];
		$zip = new ZipArchive();
		$zip->open('source/'.$s.'.zip', ZipArchive::CREATE);
		$zip->addFile($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);
		$zip->close();
	}
	header("location:viewSource.php?id=$s");
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
        <?php require "template/menu.php";
		ini_set("upload_max_filesize", "30M"); ?><!--I'm Menu Bar-->
        <div class="ct"><!--This is Container -->
			<h1>AddCode</h1><br><br>
			<form action="addCode.php" method="post" class="form-group" enctype="multipart/form-data">
            <fieldset>
            <div class='form-horizontal col-lg-11 col-md-12 col-sm-12 col-xs-12' align="left">
           <br>
            <label for="name">Name:</label>
            <input class="form-control" type="text" name="name" autofocus required>
            <label for="data">Code:</label>
            <textarea name="data" class="form-control" rows="20"></textarea>
            <label for="type">Type:</label>
			<select name="type" class="form-control">
            	<option value="cpp">C++</option>
                <option value="cs">C#</option>
                <option value="c">C</option>
                <option value="java">Java</option>
                <option value="html">HTML</option>
                <option value="php">PHP</option>
            </select>
            <label for="status">Status:</label>
			<select name="status" class="form-control">
            	<option value="public">Public</option>
                <option value="private">Private</option>
            </select>
            <br>
            <input type="text" name="own" hidden="on" value="<?php echo $_SESSION["username"];?>">
            <input type="file" name="file" class="form-control-static"><br>
			<input class="form-control" type="submit" value="Send">
            </div>
            </fieldset>
            </form>
       </div>
    </div>
</div>
<hr>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>