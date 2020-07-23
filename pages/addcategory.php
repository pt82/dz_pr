
<?php
echo '<h3>Добавление категории</h3>';

if (!isset($_POST['addcat'])) {

    ?>
    <form action="index.php?page=1" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="category">Категория:
                <input type="text" class="form-control" name="category">
            </label>
        </div>

        <button type="submit" class="btn btn-primary" name="addcat">Добавить</button>

    </form>
    <?php
} else {

   $cat= new Cat($_POST['category']);
   $cat->intoDb();


}
?>



