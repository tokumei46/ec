<?php
session_start();
session_regenerate_id(true);
 
if(isset($_SESSION["menber_login"]) === true) {
    echo "ようこそ";
    echo $_SESSION["menber_name"];
    echo "様";
    echo "<a href='../menber_login/menber_logout.php'>ログアウト</a>";
    echo "<br><br>";
}
 
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>book</title>
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
    
$sql = "SELECT code,name,price,gazou,explanation FROM mst_product WHERE category=?";
$stmt = $dbh -> prepare($sql);
$data[] = "書籍";
$stmt -> execute($data);
    
$dbh = null;
    
echo "販売商品一覧";
echo "<a href='shop_cartlook.php'>カートを見る</a>";
echo "<br><br>";
    
while(true) {
    $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
    if($rec === false) {
        break;
    }
    $code = $rec["code"];
    echo "<a href='shop_product.php?code=".$code."'>";
    if(empty($rec["gazou"]) === true) {
        $gazou = "";
    } else {
        $gazou = "<img src='../product/gazou/".$rec['gazou']."'>";
    }
    echo $gazou;
    echo "商品名:".$rec["name"];
    echo "<br>";
    echo "価格:".$rec["price"]."円";
    echo "<br>";
    echo "詳細:".$rec["explanation"];
    echo "</a>";
    echo "<br>";
}
echo "<br>";
 
}
catch(Exception $e) {
    echo "只今障害が発生しております。<br><br>";
    echo "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
}
?>
<a href="shop_list.php">トップページへ戻る</a>
<br><br><br>
 
<h3>カテゴリー</h3>
    <ul>
        <li><a href="shop_list_eart.php">食品</a></li>
        <li><a href="shop_list_kaden.php">家電</a></li>
        <li><a href="shop_list_book.php">書籍</a></li>
        <li><a href="shop_list_niti.php">日用品</a></li>
        <li><a href="shop_list_sonota.php">その他</a></li>
    </ul>
    
</body>
</html>