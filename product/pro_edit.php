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
<title>商品修正画面</title>
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
            
        $sql = "SELECT category, code, name, price, gazou, explanation FROM mst_product WHERE code=?";
        $stmt = $dbh -> prepare($sql);
        $data[] = $code;
        $stmt -> execute($data);
            
        $dbh = null;
            
        $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
        
        if(empty($rec["gazou"]) === true) {
            $disp_gazou = "";
        } else {
            $disp_gazou = "<img src='./gazou/".$rec['gazou']."'>";
        }
    }
        catch(Exception $e) {
            print "只今障害が発生しております。<br><br>";
            print "<a href='../staff_login/staff_login.html'>ログイン画面へ</a>";
        }
    ?>

    商品コード<br>
    <?php echo $rec["code"]; ?>
    の情報を修正します<br>
    <form action="pro_edit_check.php" method="post" enctype="multipart/form-data">
        カテゴリー<br>
        <select name='cate'>
         <option value='食品'>食品</option>
         <option value='家電'>家電</option>
         <option value='書籍'>書籍</option>
         <option value='日用品'>日用品</option>
         <option value='その他'>その他</option>
         </select>
         <br><br>
       商品名<br>
      <input type="text" name="name" value="<?php echo $rec['name'];?>">
      <br><br>
      価格<br>
      <input type="text" name="price" value="<?php echo $rec['price'];?>">
      <br><br>
      画像<br>
      <?php echo $disp_gazou;?>
      <br>
      <input type="file" name="gazou">
      <br><br>
      詳細<br>
      <textarea name="comments" ><?php echo $rec['explanation'];?></textarea>
      <br><br>
        <input type="hidden" name="code" value="<?php echo $rec['code'];?>">
        <input type="hidden" name="old_gazou" value="<?php echo $rec['gazou'];?>">
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>
</body>
</html>