<?php
error_reporting(E_ALL);
session_start();
if(!isset($_SESSION['time']))
$_SESSION['time']='';
if(time() > $_SESSION['time']+10)
{
    $_SESSION['time']=null;
    $_SESSION['ruser']=null;
}
include_once("pages/classes.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ДЗ</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body class="bg-secondary">
<div class="container">
    <div class="row">
        <header class="col-12">

        </header>
    </div>
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-light w-100">
            <?php include_once("pages/menu.php"); ?>
        </nav>
    </div>
    <div class="row">
        <section class="col-12">
            <?php
            if(isset($_GET['page'])) {
                $page = $_GET['page'];
                if($page == 1) {include_once('pages/addcategory.php');}
                if($page == 2) {include_once('pages/addproduct.php');}
                if($page == 3) {include_once('pages/registration.php');}
               }
            ?>
        </section>
    </div>
    <footer class="row bg-dark justify-content-center">
        <small class="text-light">Step academy &copy; 2020   </small>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="js/jquery_cookie.js"></script>

</body>
</html>