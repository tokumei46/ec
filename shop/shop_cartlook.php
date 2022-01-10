<<?php
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
<title>カート情報</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php
    if(empty($_SESSION["cart"]) === true) {
        echo "カートに商品がありません<br>";
        echo "<a href='shop_list.php'>商品一覧</a>";
        exit();
    }

    try{
        $cart = $_SESSION["cart"];
        $kazu = $_SESSION["kazu"];
        $max = count($cart);

        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        foreach($cart as $key => $val) {
            $sql = "SELECT code, name, price, gazou FROM mst_product WHERE code=?";
            $stmt = $dbh -> prepare($sql);
            $data[0] = $val;
            $stmt -> execute($data);

            $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
            $name[] = $rec["name"];
            $price[] = $rec["price"];
            $gazou[] = $rec["gazou"];
        }
        $dbh = null;
    }
    catch(Exception $e) {
        echo "只今障害が発生しております。";
        echo "<a href='menber_login.php'>ログインページへ戻る</a>";
        exit();
    }
    ?>
    <form action="shop_kazu.php" method="POST">
        カート一覧<br>
        <?php for($i = 0; $i < $max; $i++) {;?>
            <?php if(empty($gazou[$i]) === true) {;?>
            <?php $disp_gazou = "";?>
            <?php } else { ;?>
            <?php $disp_gazou = "<img src='../product/gazou/".$gazou[$i]."'>";?>
            <?php };?><br>
            <?php echo $disp_gazou;?><br>
            商品名:<?php echo $name[$i];?><br>
            価格:<?php echo $price[$i], "円";?><br>
            数量:<input type="text" name="kazu<?php echo $i;?>" value="<?php $kazu[$i];?>"><br>
            合計価格:<?php echo $price[$i] * $kazu[$i]. "円";?><br>
            削除:<input type="checkbox" name="delete<?php echo $i;?>"><br><br>

            <?php }; ?>
            <br>
            <input type="hidden" name="max" value="<?php echo $max;?>">
            <input type="submit" value="数量削除/削除">
            <br>
            <input type="button" onclick="history.back" value="戻る">
    </form>
    <br>
    <a href="shop_form_check.php">ご購入手続きへ進む</a><br>
    <br>
</body>
</html>