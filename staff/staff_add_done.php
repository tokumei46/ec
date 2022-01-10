<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>スタッフ追加実効</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<?php
 try{
    require_once("../common/common.php");

        
$post = sanitize($_POST);
$name = $post["name"];
$pass = $post["pass"];

$dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
$user = "root";
$password = "root";
$dbh = new PDO($dsn, $user, $password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
$sql = "INSERT INTO mst_staff(name, password) VALUES(?,?)";
$stmt = $dbh -> prepare($sql);
$data[] = $name;
$data[] = $pass;
$stmt -> execute($data);

    $dbh = null;
 }
 catch(Exception $e) {
     echo "只今障害が発生しています <br>";
     echo "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
 }
?>
スタッフを追加しました<br>
<a href="staff_list.php">スタッフ一覧</a>
</body>
</html>