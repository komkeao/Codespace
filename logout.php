<!DOCTYPE html>
<?php include "template/pdo.php";
session_start();
session_destroy();
header("location:index.php");
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
       </div>
    </div>
</div>
<hr>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>