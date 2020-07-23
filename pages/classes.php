<?php

class Tools {
    static function connect($host="localhost:3306", $user="root", $pass="123456", $dbname="shop2") {
        // PDO(PHP data object) - механизм взаимодействия с СУБД(система управления базами данных).
        // PDO - позволяет облегчить рутинные задачи при выполнении запросов и содержит защитные механизмы
        // при работе с СУБД

        // формировка строки для создания PDO
        // определим DSN (Data Source Name) — сведения для подключения к базе, представленные в виде строки.
        $cs = 'mysql:host='.$host.';dbname='.$dbname.';charset=utf8';

        // массив опций для создания PDO
        $options = array(
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES UTF8'
        );

        try {
            // пробуем создать PDO
            $pdo  = new PDO($cs, $user, $pass, $options);
            return $pdo;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    static function login($login, $pass ) {



        $name = trim(htmlspecialchars($login));
        $pass = trim(htmlspecialchars($pass));
        if($name=="" || $pass == "") {
            echo '<h3 style="color:#ff0000;">Fill all fields</h3>';
            return false;
        }
        if(strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
            echo "<h3 class='text-danger>От 3 до 30 символов</h3>";
            return false;
        }

        try {
            $pdo = Tools::connect();
            $ps=$pdo->prepare("SELECT * FROM users WHERE login=?");
            $ps->execute([$login]);
            $row = $ps->fetch();
            // $customer = new Customer($row['login'], $row['pass'],  $row['id']);
            if($name == $row['login'] and $pass==$row['pass']){
                $_SESSION['ruser']  = $name;
                return [true];
            }
            else {

                return false;
            }

        }catch(PDOException $e) {
            echo $e->getMessage();

            return false;
        }

    }



    static function register($login, $pass){

        if(strlen($login)<3 || strlen($login)>30 || strlen($pass)<3 || strlen($pass)>30){
        echo '<h3> inncorrect</h3>';
        return false;
        }

        Tools::connect();
        //создаем экз класса
        $customer = new User($login, $pass);

        $customer->intoDb();
        return true;

    }
}




class Cat {
    public $id;
    public $category;


    function __construct($category, $id=0) {
        $this->category = $category;
        $this->id = $id;
   }

    // ORM(Object-Relational Mapping) - объектно реляционное отображение. Это механизм работы сущности в связи с БД.

    // внести покупателя в таблицу
    function intoDb() {
        try {
            $pdo = Tools::connect();
           
            // выполнение запроса через PDO на внесение данных
            $ps = $pdo->prepare('INSERT INTO categories(category)
                                          VALUES (:category)');
            // разименовывание массива. Мы преобразуем объект класса $this в массив
            $ar = (array) $this;
            array_shift($ar); // удаляем первый элемент массива, т.е. id


            // выполним запрос без id
            $ps->execute($ar);
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // получаем данные о созданном пользователе из таблицы
    static function fromDb($id) {
        $customer = null;
        try {
            $pdo = Tools::connect();
            $ps=$pdo->prepare("SELECT * FROM categories WHERE id=?");
            // выполняем выбор всех данных о пользователе по $id получаемому в качестве параметра в ф-ю fromDb
            // и заносим его в массив, ибо метод execute этого требует. При выполнеии execute $id будет подставлен
            // вместо символа ? при подготовке(метод prepare)
            $res = $ps->execute(array($id));
            // перебираем данные о полученном пользователе и заносим его в ассоциативный массив $row
            $row = $res->fetch();
            $customer = new Cat($row['category'], $row['id']);
            return $customer;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


}

class Products {
public $id;
public $name;
public $catid;
public $price;
public $make;
public $model;
public $country;
public $description;



function __construct($name,  $price, $catid, $make, $model, $country, $description, $id=0){

$this->id=$id;
$this->name=$name;
$this->catid=$catid;
$this->price=$price;
$this->make=$make;
$this->model=$model;
$this->country=$country;
$this->description=$description;

}

function intoDb() {
        try {
            $pdo = Tools::connect();
            // выполнение запроса через PDO на внесение данных
         //   $ps = $pdo->prepare("INSERT INTO products(name)
           //                               VALUES (:name)");

        $ps = $pdo->prepare("INSERT INTO products(name, price, catid,  make, model, country, description)
                                      VALUES (:name, :price, :catid, :make, :model, :country, :description)");
            // разименовывание массива. Мы преобразуем объект класса $this в массив
            $ar = (array) $this;


            array_shift($ar); // удаляем первый элемент массива, т.е. id


            // выполним запрос без id
            $ps->execute($ar);
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}

class User {
    public $id;
    public $login;
    public $pass;


    function __construct($login, $pass, $id=0) {
        $this->login = $login;
        $this->pass = $pass;

        $this->id = $id;

    }

    // ORM(Object-Relational Mapping) - объектно реляционное отображение. Это механизм работы сущности в связи с БД.

    // внести покупателя в таблицу
    function intoDb() {
        try {
            $pdo = Tools::connect();

            // выполнение запроса через PDO на внесение данных
            $ps = $pdo->prepare('INSERT INTO users(login, pass)
                                          VALUES (:login, :pass)');
            // разименовывание массива. Мы преобразуем объект класса $this в массив
            $ar = (array) $this;


            array_shift($ar); // удаляем первый элемент массива, т.е. id


            // выполним запрос без id
            $ps->execute($ar);
        } catch(PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // получаем данные о созданном пользователе из таблицы
    static function fromDb($id) {
        $customer = null;
        try {
            $pdo = Tools::connect();
            $ps=$pdo->prepare("SELECT * FROM customers WHERE id=?");
            // выполняем выбор всех данных о пользователе по $id получаемому в качестве параметра в ф-ю fromDb
            // и заносим его в массив, ибо метод execute этого требует. При выполнеии execute $id будет подставлен
            // вместо символа ? при подготовке(метод prepare)
            $res = $ps->execute(array($id));
            // перебираем данные о полученном пользователе и заносим его в ассоциативный массив $row
            $row = $res->fetch();
            $customer = new Customer($row['login'], $row['pass'], $row['imagepath'], $row['id']);
            return $customer;
        }catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


}