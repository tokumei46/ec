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
<title>商品一覧</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
     try{
    
        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        $sql = "SELECT code,name,price FROM mst_product WHERE1";
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();
            
        $dbh = null;
        
        echo "商品一覧<br>";
        echo "<form action='pro_branch.php' method='post'>";

        while(true) {
            $rec = $stmt-> fetch(PDO::FETCH_ASSOC);
            if($rec === false) {
                break;
            }
            echo "<input type='radio' name='code' value='".$rec['code']."'>";
            echo $rec["name"];
            echo "---";
            echo $rec["price"]."円";
            echo "<br>";
        }
        echo "<br>";
        echo "<input type='submit' name='disp' value='詳細'>";
        echo "<input type='submit' name='add' value='追加'>";
        echo "<input type='submit' name='edit' value='修正'>";
        echo "<input type='submit' name='delete' value='削除'>";
     }
     catch(Exception $e) {
        echo "只今障害が発生しております。<br><br>";
        echo "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
     }
    ?>
    <br>
    <a href="../staff_login/staff_login_top.php">管理画面TOPへ</a>
</body>
</html>