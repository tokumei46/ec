<?php 
session_start();
session_regenerate_id(true);

if(isset($_SESSION["menber_name"]) === true) {
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
<title>商品選択画面</title>
<link rel="stylesheet" href="../style.css">
</head>
    <body>
        <?php
         try{
 
            $code = $_GET["code"];
                
            $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
            $user = "root";
            $password = "root";
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            $sql = "SELECT code, name, price, gazou, explanation FROM mst_product WHERE code=?";
            $stmt = $dbh -> prepare($sql);
            $data[] = $code;
            $stmt -> execute($data);
                
            $dbh = null;
            $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

            if(empty($rec["gazou"]) === true) {
                $disp_gazou = "";
            } else {
                $disp_gazou = "<img src='../product/gazou/".$rec['gazou']."'>";
            }
        }
            catch(Exception $e) {
                print "只今障害が発生しております。<br><br>";
                print "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
            }
        ?>
        <a href="shop_cartin.php?code=<?php echo $code; ?>">カートに入れる</a>
        <br>
        <?php echo $disp_gazou; ?>
        <br>
        商品名<br>
        <?php echo $rec["name"]; ?>
        価格<br>
        <?php echo $rec["price"]; ?>
        詳細<br>
        <?php echo $rec["explanation"]; ?>
        <br>

        <form>
            <input type="button" onclick="history.back()" value="戻る">
        </form>
        <h3>カテゴリー</h3>
        <a href="shop_list_eart.php">食品</a><br>
        <a href="shop_list_kaden.php">家電</a><br>
        <a href="shop_list_book.php">書籍</a><br>
        <a href="shop_list_niti.php">日用品</a><br>
        <a href="shop_list_sonota.php">その他</a><br> 
    </body>
    </html>