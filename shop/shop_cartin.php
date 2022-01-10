<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION["menber_login"]) === false) {
    echo "ログインしてください<br>";
    echo "<a href='../menber_login/menber_login.php'>ログイン画面へ</a>";
    echo "<a href='shop_list.php'>TOP</a>";
    exit();
}
if(isset($_SESSION["menber_login"]) === true) {
    echo "ようこそ<br>";
    echo $_SESSION["menber_name"];
    echo "様";
    echo "<a href='../menber_login/menber_logout.php'>ログアウト</a>";
    echo "<br>";
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>カートに追加</title>
<link rel="stylesheet" href="../style.css">
</head>
    <body>
        <?php
        $code = $_GET["code"];

        if(isset($_SESSION["cart"]) === true) {
            $cart = $_SESSION["cart"];
            $kazu = $_SESSION["kazu"];
            if(in_array($code, $cart) === true) {
                echo 'すでにカートにあります<br>';
                echo "<a href='shop_list.php'>商品一覧へ</a>";
            }
        }
        if(empty($_SESSION["cart"]) === true or in_array($code, $cart) === false) {
            $cart[] = $code;
            $kazu[] = 1;
            $_SESSION["cart"] = $cart;
            $_SESSION["kazu"] = $kazu;

            echo "カートに追加しました<br>";
            echo "<a href='shop_list.php'>商品一覧へ</a>";
        }
        ?>
    </body>
    </html>