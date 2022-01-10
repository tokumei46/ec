<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION["menber_login"]) === false) {
    echo "ログインしていません<br>";
    echo "<a href='../menber_login/menber_login.php'>ログインページへ</a>";
    echo "<a href='shop_list.php'>TOPへ</a>";
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
<title>商品購入チェック</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php 
    try{
        $menber_code = $_SESSION["menber_code"];
        $cart = $_SESSION["cart"];
        $kazu = $_SESSION["kazu"];
        $max = count($kazu);

        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT name, email, address, tel FROM menber WHERE code=?";
        $stmt = $dbh -> prepare($sql);
        $data[] = $menber_code;
        $stmt -> execute($data);

        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

        echo "下記内容でよろしいでしょうか？<br>";
        echo "【宛先】<br>";
        echo "お名前<br>". $rec["name"]. "様<br>";
        echo "mail". $rec["email"]. "<br>";
        echo "ご住所". $rec["address"]. "<br>";
        echo "ご連絡先". $rec["tel"]. "<br><br>";

        $name = $rec["name"];
        $email = $rec["email"];
        $address = $rec["address"];
        $tel = $rec["tel"];

        echo "【ご注文内容】<br>";
        for($i = 0; $i < $max; $i++) {
            $sql = "SELECT name, price, gazou FROM mst_product WHERE code=?";
            $stmt = $dbh -> prepare($sql);
            $data = array();
            $data[] = $cart[$i];
            $stmt -> execute($data);

            $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

            if(empty($rec["gazou"]) === true) {
                $disp_gazou = "";
            } else {
                $disp_gazou = "<img src='../product/gazou/".$rec['gazou']."'>";
            }
            echo "<div class='box'>";
            echo "<div class='list'>";
            echo "<div class='img'>";
            echo $disp_gazou;
            echo "</div>";
            
            echo "<div class='npe'>";
            echo "商品名:". $rec["name"]. "<br>";
            echo "価格:". $rec["price"]. "円<br>";
            echo "数量:", $kazu[$i]. "<br>";
            echo "合計金額". $rec["price"] * $kazu[$i]. "円<br>";
            $goukei[] = $rec["price"] * $kazu[$i];
            echo "</div></div></div><br>";
        }
        $dbh = null;
        echo "【ご請求金額】---".array_sum($goukei)."円<br><br>";
        echo "<form action='shop_form_done.php' method='post'>";
        echo "<input type='hidden' name='name' value='".$name."'>";
        echo "<input type='hidden' name='email' value='".$email."'>";
        echo "<input type='hidden' name='address' value='".$address."'>";
        echo "<input type='hidden' name='tel' value='".$tel."'>";
        echo "<input type='button' onclick='history.back()' value='戻る'>";
        echo "<input type='submit' value='OK'>";
        echo "</form>";
    }
    catch(Exception $e) {
        echo "只今障害が発生しております。";
        echo "<a href='menber_login.php'>ログインページへ戻る</a>";
        exit();
    }
    ?>
</body>
</html>