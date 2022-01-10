<?php 
session_start();
session_regenerate_id(true);
if(isset($_SESSION["login"]) === false) {
    echo "ログインしていません<br>";
    echo "<a href='staff_login.html'>ログイン画面へ</a>";
    echo "<br>";
    exit();
} else {
    echo $_SESSION["name"]. "さんログイン中";
    echo "<br>";

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>スタッフ修正登録</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php

      require_once("../common/common.php");
    
        $post = sanitize($_POST);
        $code = $post["code"];
        $name = $post["name"];
        $pass = $post["pass"];

     try{
        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE mst_staff SET name=?, password=? WHERE code=?";
        $stmt = $dbh -> prepare($sql);
        $data[] = $name;
        $data[] = $pass;
        $data[] = $code;
        $stmt -> execute($data);

        $dbh = null;
       }
        catch(Exception $e) {
            echo "只今障害が発生しています<br>";
            echo "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
        }
    ?>

    修正完了しました<br>
    <a href="staff_list.php">スタッフ一覧</a>
</body>