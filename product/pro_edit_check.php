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
<title>商品内容変更チェック</title>
<link rel="stylesheet" href="../style.css">
</head>
    
<body>
    
<?php
require_once("../common/common.php");
    $post = sanitize($_POST);
    $code = $post["code"];
    $name = $post["name"];
    $price = $post["price"];
    $gazou = $_FILES["gazou"];
    $old_gazou = $post["old_gazou"];
    $comments = $post["comments"];
    $cate = $post["cate"];
    
    if(empty($name) === true) {
        echo "商品名が入力されていません<bf>";
    } else {
        echo $name;
        echo "<br>";
    }
    
    if(preg_match("/\A[0-9]+\z/", $price) === true) {
        echo "正しい値を入力して下さい<br>";
    } else {
       echo $price. "円";
       echo '<br>';
    }
    if($gazou["size"] > 0) {
        if($gazou["size"] > 1000000) {
            echo "ファイルのサイズが大きすぎます<br>";
        } else {
            move_uploaded_file($gazou["tmp_name"],"./gazou/".$gazou["name"]);
             echo "<img src='./gazou/".$gazou['name']."'>";
             echo "<br><br>";
        }
    }
    if($gazou["name"] === "") {
        if($old_gazou != "") {
            print "<img src='./gazou/".$old_gazou."'>";}
        }

        if(empty($comments) === true) {
            echo "詳細が入力されていません<br>";
            echo "<br>";
        } 
        if(mb_strlen($comments) >100) {
            echo "文字数は100文字が上限です";
            echo "<br>";
        } else {
            echo $comments;
            echo "<br>";
        }

        if(empty($name) or preg_match("/\A[0-9]+\z/", $price) === 0 or $gazou["size"] > 1000000 or empty($comments) === true or mb_strlen($comments) > 100) {
            echo "<form>";
            echo "<input type='button' onclick='history.back()' value='戻る'>";
            echo "</form>";
        } else {
            echo "上記商品を修正しますか<br>";
            echo"<form action='pro_edit_done.php' method='post'>";
            echo "<input type='hidden' name='cate' value='".$cate."'>";
            echo "<input type='hidden' name='code' value='".$code."'>";
            echo "<input type='hidden' name='name' value='".$name."'>";
            echo "<input type='hidden' name='price' value='".$price."'>";
            echo "<input type='hidden' name='gazou' value='".$gazou['name']."'>";
            echo "<input type='hidden' name='old_gazou' value='".$old_gazou."'>";
            echo "<input type='hidden' name='explanation' value='".$comments."'>";
            echo "<input type='button' onclick='history.back()' value='戻る'>";
            echo "<input type='submit' value='OK'>";
            echo "</form>";
        }
?>
</body>
</html>