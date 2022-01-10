<?php
session_start();
session_regenerate_id(true);
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
 
<header>
<h1>test shop</h1>
<p id="target">menu</p>
</header>
<warapper>
<main>    
<?php
try{
if(isset($_SESSION["menber_login"]) === true) {
echo "ようこそ";
    echo $_SESSION["menber_name"];
    echo "様";
    echo "<a href='../menber_login/menber_logout.php'>ログアウト</a>";
    echo "<br><br>";
}
    
$dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
$user = "root";
$password = "root";
$dbh = new PDO($dsn, $user, $password);
$dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
$sql = "SELECT code,name,price,gazou,explanation FROM mst_product WHERE1";
$stmt = $dbh -> prepare($sql);
$stmt -> execute();
    
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
    echo "<div class='box'>";
    echo "<div class='list'>";
    echo "<div class='img'>";
    echo $gazou;
    echo "</div>";
    echo "<div class='npe'>";
    echo "商品名:".$rec["name"];
    echo "<br>";
    echo "価格:".$rec["price"]."円";
    echo "<br>";
    echo "詳細:".$rec["explanation"];
    echo "</div>";
    echo "</div>";
    echo "</div>";
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
<nav id="menu" class="close">
    <h3>カテゴリー</h3>
    <ul>
        <li><a href="shop_list_eart.php">食品</a></li>
        <li><a href="shop_list_kaden.php">家電</a></li>
        <li><a href="shop_list_book.php">書籍</a></li>
        <li><a href="shop_list_niti.php">日用品</a></li>
        <li><a href="shop_list_sonota.php">その他</a></li>
    </ul>
</nav>
    
    <div id="back" class="white"></div>
    <div id="scrolltop" class="st">⇧</div>
    <div id="scrollmenu" class="sm">MENU</div>
<br><br>
 
</main>
<aside>
<div class="box">
<h3>カテゴリー</h3>
<a href="shop_list_book.php">書籍</a><br>
</div>
<div class="box">
<h3>テスト</h3>    
<div class="img"><img src="/ec/product/gazou/gazou.jpg" width="300" height="300"></div>
<p>テストテストテストテスト</p>
</div>
<div class="box">
<h3>テスト・テスト</h3>
<div class="img"><a href="/ec/product/gazou/img.png"><img src="/ec/product/gazou/img.png" width="300" height="200"></a>
</div></div>

</div></div>
</aside>
</warapper>
<footer>
<h3>test shop</h3>    
</footer>
<script src="../main.js"></script>
<script src="../anime.min.js"></script>
</body>
</html>