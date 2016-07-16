<?php 
require "template/pdo.php";
if(isset($_POST["name"])){
	$id=$_POST["id"];
	$name=$_POST["name"];
	$data=$_POST["data"];
	$status=$_POST["status"];
	$cur_date = date("Y-m-d");
	$files=$_POST["fn"];
	if(isset($_FILES["files"]["tmp_name"])){//เชคว่ามาการส่งไฟล์หรือไม่
		$f=1;	
		unlink("source/".$id.".zip");
		$zip = new ZipArchive();
		$zip->open('source/'.$id.'.zip', ZipArchive::CREATE);
		$zip->addFile($_FILES["files"]["tmp_name"],$_FILES["files"]["name"]);
		$zip->close();
	}
	$data=htmlentities($data);
	$sql = "update source set name=:name,data= :data,status= :status,cur_date= :cur_date,files= :files where id='$id'";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(
	  ':name' => $name,
	  ':data'=> $data,
	  ':status' => $status,
	  ':cur_date' => $cur_date,
	  ':files' => $files
	));
	header("location:viewSource.php?id=$id");
	
	}


?>

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
<div>
    <div class="container"> <?php require "template/menu.php";
		$id=$_GET["id"];
		$temp=$pdo->query("select * from source where id ='$id'");
		$data=$temp->fetch();
		?><!--I'm Menu Bar-->
        <div class="ct"><!--This is Container --> 
        <br><br>
    <form enctype="multipart/form-data" action="viewSource.php" method="post">
    <fieldset>
     		<label for="name">Name:</label>
    		<input class="form-control" type="text" name="name" value="<?php echo $data["name"]; ?>" autofocus required>
            <label for="data">Code:</label>
            <textarea name="data" class="form-control" rows="20"><?php echo $data["data"]; ?></textarea>
              <div><!--ไฟล์ -->
    <?php 
	if($data["files"]==1){
		$zip = new ZipArchive;
		$location="source/".$id.".zip";
		if ($zip->open($location) === TRUE) {
			echo "Files:";
			for ($i = 0; $i < $zip->numFiles; $i++) {
				echo $zip->getNameIndex($i) . "<br />";
			}
			echo "<a href='$location'>Download Now!</a>";
		}
	}if(isset($_SESSION["username"])){//check session
	if($_SESSION["username"]=="Administrator"||$_SESSION["username"]==$data["own"]){//check Own
	?>
    <br>
    <input type="file" name="files">
    <input type="text" name="fn" value="<?php echo $data["files"]; ?> " hidden="on">
    <label for="status">Status:</label>
			<select name="status" class="form-control">
            <?php if($data["status"]=="public"){ ?>
            	<option value="public" selected>Public</option>
                <option value="private">Private</option>
            <?php }else{ ?>
           		<option value="public">Public</option>
                <option value="private" selected>Private</option>
            <?php } ?>
            </select>
            <input name="id" type="text" value="<?php echo $id;?>" hidden="on">
            <input type="submit" value="Edit" class="form-control">
       <?php }
			}// end if 
			?>
    </fieldset>
    </form>
   
    </div>
        </div>
    </div>
</div>
<hr>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>