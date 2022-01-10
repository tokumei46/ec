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
<title>商品追加</title>
<link rel="stylesheet" href="../style.css">
</head>
    <body>
        <form action="pro_add_check.php" method="post" enctype="multipart/form-data">
             商品追加<br>
             カテゴリー<br>
             
          <select name='cate'>
          <option value="未選択">選択して下さい</option>
          <option value='食品'>食品</option>
          <option value='家電'>家電</option>
          <option value='書籍'>書籍</option>
          <option value='日用品'>日用品</option>
          <option value='その他'>その他</option>
          </select>

             <br>
             商品名<br>
             <input type="text" name="name">
             <br>
             価格<br>
             <input type="text" name="price">
             <br>
             画像<br>
             <input type="file" name="gazou">
             <br>
             詳細<br>
             <textarea name="comments" ></textarea>
             <br>
             <input type="button" onclick="history.back()" value="戻る">
             <input type="submit" value="OK">
        </form>
    </body>
</html>