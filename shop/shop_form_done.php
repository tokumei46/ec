<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION["menber_login"]) === false) {
    echo "ログインしていません<br>";
    echo "<a href='../menber_login/menber_login.php'>ログインページへ</a>";
    echo "<a href='shop_list.php'>TOPへ</a>";
    exit();
}

if(isset($_SESSION["menber_login"]) === true) {
    echo "ようこそ<br>";
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
<title>商品購入決定画面</title>
<link rel="stylesheet" href="../style.css">
</head>
    <body>
        <?php
        
        try{
            require_once("../common/common.php");
            
            $post = sanitize($_POST);
            $aname = $post["name"];
            $email = $post["email"];
            $address = $post["address"];
            $tel = $post["tel"];
            
            $cart = $_SESSION["cart"];
            $kazu = $_SESSION["kazu"];
            $max = count($cart);

            echo $aname. "様 <br>";
            echo "ご注文ありがとうございました!<br>";
            echo $email. "にメールを送信しましたご確認下さい";
            echo "商品は入金を確認次第、下記の住所に発送させていただきます<br>";
            echo $address. "<br>";
            echo $tel. "<br>";

            $honbun = "";
            $honbun .= $aname. "様\n\nこの度はご注文ありがとうございました\n";
            $honbun .= "\n";
            $honbun .= "ご注文商品\n";
            $honbun .= "-------------\n";

        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        for($i = 0; $i < $max; $i++) {

        $sql = "SELECT name, price FROM mst_product WHERE code=?";
        $stmt = $dbh -> prepare($sql);
        $data[0] = $cart[$i];
        $stmt -> execute($data);

        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        
        $name = $rec["name"];
        $price = $rec["price"];
        $kakaku[] = $price;
        $suryo = $kazu[$i];
        $shokei = $price * $suryo;

        $honbun .= $name."";
        $honbun .= $price."円";
        $honbun .= $suryo."個=";
        $honbun .= $shokei."円\n";
        }

        $sql = "LOCK TSBLES dat_sales_product WRITE";
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

        for($i = 0; $i < $max; $i++) {
            $sql = "INSERT INTO dat_sales_product(sales_menber_code, code_product, price, quantity, time) VALUES(?,?,?,?,now())";
            $stmt = $dbh -> prepare($sql);
            $data = array();
            $data[] = $_SESSION["menber_code"];
            $data[] = $cart[$i];
            $data[] = $kakaku[$i];
            $data[] = $kazu[$i];
            $stmt -> execute($data);
        }
        $sql = "UNLOCK TABLES";
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

        $dbh = null;

$honbun .= "送料は無料です。\n";
$honbun .= "-------------\n";
$honbun .= "\n";
$honbun .= "代金は以下の口座にお振込み下さい。\n";                                         
$honbun .= "A銀行B支店普通口座 1234567\n";
$honbun .= "入金が確認取れ次第、商品を発送させていただきます。\n";
$honbun .= "\n";
$honbun .= "◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆\n";
$honbun .= "test shop\n";
$honbun .= "\n";
$honbun .= "兵庫県神戸市\n";
$honbun .= "電話090-0000-0000\n";
$honbun .= "メールtest@test.com\n";
$honbun .= "◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆◆\n";

echo "<br>";
echo nl2br($honbun);

$title = "ご注文ありがとうございました<br>";
$header = "test@test.com";
$honbun = html_entity_decode($honbun, ENT_QUOTES, "UTF-8");
mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_send_mail($email, $title, $honbun, $header);

$title = "お客様よりご注文が入りました。";
$header = "From:".$email;
$honbun = html_entity_decode($honbun, ENT_QUOTES, "UTF-8");
mb_language("Japanese");
mb_internal_encoding("UTF-8");
mb_send_mail("test@test.com", $title, $honbun, $header);
    }

    catch(Exception $e) {
        echo "只今障害が発生しております。";
        exit();
    }
        ?>

        <br>
        <?php $_SESSION["cart"] = array(); ?>
        <?php $_SESSION["kazu"] = array(); ?>
        <a href="shop_list.php">商品画面へ</a>

        <br><br>
    </body>
    </html>