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
<title>商品削除実効</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
    try{
        require_once("../common/common.php");

        $post = sanitize($_POST);
        $code = $post["code"];
        

        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        $sql = "DELETE FROM mst_product WHERE code=?";
        $stmt = $dbh -> prepare($sql);
        $data[] = $code;
        $stmt -> execute($data);
            
        $dbh = null;
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e) {
        echo "只今障害が発生しております。<br><br>";
        echo "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
     } 
    ?>
    商品削除しました<br>
    <a href="pro_list.php">商品一覧へ</a>
    </body>
    </html>
</body>