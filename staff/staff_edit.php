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
 <title>スタッフ修正画面</title>
 <link rel="stylesheet" href="style.css">
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

スタッフコード<br>
<?php echo $rec["code"];?>
の情報を修正します<br>
<form action="staff_edit_check.php" method="post">
    スタッフ名<br>
    <input type="text" name="name" value="<?php echo $rec["name"]; ?>">
    <br>
    パスワード<br>
    <input type="passsword" name="pass">
    パスワード再入力<br>
    <input type="password" name="pass2">
    <br>
    <input type="hidden" name="code" value="<?php echo $rec["code"] ?> ">
    <input type="button" onclick="history.back()" value="戻る">
<input type="submit" value="OK">
</form>
</body>
</html>