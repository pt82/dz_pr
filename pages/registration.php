<?php
echo '<h3>Registration Form</h3>';

if (!isset($_POST['regbtn'])) {

?>
<form action="index.php?page=3" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="login">Login:
            <input type="text" class="form-control" name="login">
        </label>
    </div>

<div class="form-group">
<label for="pass1">
<input type="password" class="form-control" name="pass1">
</label>
</div>
<div class="form-group">
<label for="pass2">
<input type="password" class="form-control" name="pass2">
</label>
</div>


<button type="submit" class="btn btn-primary" name="regbtn">Register</button>

</form>
<?php
} else {

    if(Tools::register($_POST['login'], $_POST['pass1'])){
        echo '<h3 class="text-success">New user</h3>';
    }
}
?>

