<?php
session_start();
session_regenerate_id(true);
if($_SESSION["login"] === false) {
    echo "ログインしていません<br>";
    echo "<a href='staff_login.html'>ログイン画面へ</a>";
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
<title>管理画面TOP</title>
<link rel="stylesheet" href="../style.css">
</head>
    
<body>
    
管理画面TOP<br><br>
    <a href="../staff/staff_list.php">スタッフ管理</a>
    <br><br>
    <a href="../product/pro_list.php">商品管理</a>
    <br><br>
    <a href="staff_logout.php">ログアウト</a>
</body>
</html>