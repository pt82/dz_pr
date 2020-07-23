
<?php
echo '<h3>Добавить продукт</h3>';

if (!isset($_POST['addproduct'])) {

?>
    <form action="index.php?page=2" method="post" enctype="multipart/form-data">

    <div class="form-group">
            <label for="name">Наименование:
                <input type="text" class="form-control" name="name">
            </label>
        </div>

    <div class="form-group">
        <label for="price">Цена:
            <input type="number" class="form-control" name="price">
        </label>
    </div>

    <div class="form-group" >
        <label for="catid">Выберите категорию
        <select name="catid" class="form-control" onchange="getItemsCat(this.value)>
            <option value="0">Выберите категорию</option>
            <?php
            $pdo=Tools::connect();
            $ps=$pdo->prepare("SELECT * FROM categories");
            $ps->execute();
            while($row=$ps->fetch()) {
                echo "<option value=".$row['id'].">".$row['category']."</option>";
            }
            ?>
        </select>
            </label>
    </div>



    <div class="form-group">
        <label for="make">Производитель:
            <input type="text" class="form-control" name="make">
        </label>
    </div>

    <div class="form-group">
        <label for="model">Модель:
            <input type="text" class="form-control" name="model">
        </label>
    </div>

    <div class="form-group">
        <label for="country">Страна:
            <input type="text" class="form-control" name="country">
        </label>
    </div>

    <div class="form-group">
        <label for="description">
            Описание товара:
            <textarea class="form-control" name="description"></textarea>
        </label>
    </div>



    <button type="submit" class="btn btn-primary" name="addproduct">Добавить</button>

</form>
<?php
} else {

    $name = ($_POST['name']);
    $price= ($_POST['price']);
    $catid = ($_POST['catid']);
    $make = ($_POST['make']);
    $model =($_POST['model']);
    $country =($_POST['country']);
    $description = ($_POST['description']);



   $product = new Products($_POST['name'],  $_POST['price'], $_POST['catid'], $_POST['make'], $_POST['model'], $_POST['country'], $_POST['description']);
    $product->intoDb();
}
?>
