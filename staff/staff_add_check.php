<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>スタッフ追加チェック</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php 

    require_once("../common/common.php");

    $post = sanitize($_POST);
    $name = $post["name"];
    $pass = $post["pass"];
    $pass2 = $post["pass2"];

    //$name = htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8");
    //$pass = htmlspecialchars($_POST["pass"], ENT_QUOTES, "UTF-8");
    //$pass2 = htmlspecialchars($_POST["pass2"], ENT_QUOTES, "UTF-8");
    
    if(empty($name) === true) {
        echo "名前が入力されていません <br>";
    } else {
        echo $name;
        echo "<br>";
    }

    if(empty($pass) === true) {
        echo "パスワードが入力されていません <br>";
    }

    if($pass != $pass2) {
        echo "パスワードが異なります <br>";
    }

    if(empty($name) or empty($pass) or $pass != $pass2) {
        echo "<form>";
        echo "<input type='button' onclick='history.back()' value='戻る'>";
        echo "</form>";
    } else {
        $pass = md5($pass);
        echo "上記スタッフを追加しますか？ <br>";
        echo "<form action='staff_add_done.php' method='post'>";
        echo "<input type='hidden' name='name' value='".$name."'>";
        echo "<input type='hidden' name='pass' value='".$pass."'>";
        echo "<input type='button' onclick='history.back()' value='戻る'>";
        echo "<input type='submit' value='OK'>";
        echo "</form>";
    }
    ?>
</body>