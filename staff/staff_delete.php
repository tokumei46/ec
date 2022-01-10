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
<title>スタッフ削除確認画面</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    try{
        $code = $_GET["code"];
    
        $dsn =  "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "SELECT code,name FROM mst_staff WHERE code=?";
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
    スタッフ詳細<br>
    スタッフコード<br>
    <?php echo $rec["code"]; ?>
    <br>
    スタッフネーム<br>
    <?php echo $rec["name"]; ?>
    <br>
    上記を削除しますか？<br>
    <form action="staff_delete_done.php" method="post">
        <input type="hidden" name="code" value="<?php echo $rec["code"]; ?>">
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>
</body>
</html>