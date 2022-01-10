<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>会員情報入力チェック</title>
<link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
    require_once("../common/common.php");
    $post = sanitize($_POST);
    $name = $post["name"];
    $address = $post["address"];
    $tel = $post["tel"];
    $email = $post["email"];
    $pass = $post["pass"];
    $pass2 = $post["pass2"];
    $okflag = true;
    
    if(empty($name) === true) {
        echo "お名前を入力して下さい<br>";
        $okflag = false;
    }

    if(empty($email) === true) {
        echo "emailを入力して下さい<br>";
        $okflag = false;
    }

    if(preg_match("/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/", $email) === 0) {
        echo "emailを正しく入力して下さい<br>";
        $okflag = false;
    }

    if(empty($address) === true) {
        echo "住所を入力して下さい<br>";
        $okflag = false;
    }
    
    if(empty($tel) === true) {
        echo "電話番号を入力して下さい<br>";
        $okflag = false;
    }

    if(preg_match("/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/", $tel) === 0) {
        echo "正しい電話番号を入力してください<br>";
        $okflag = false;
    }

    if(empty($pass) === true) {
        echo "パスワードを入力して下さい<br>";
        $okflag = false;
    }

    if(empty($pass2) === true) {
        echo "パスワードが異なります<br>";
        $okflag = false;
    }

    if($okflag === false) {
        echo "<form><br>";
        echo "<input type='button' onclick='history.back()' value='戻る' ";
    } else {
        echo "下記内容で登録しますか？<br>";
        echo $name. "<br>";
        echo $email. "<br>";
        echo $address. "<br>";
        echo $tel. "<br>";
        echo "<form action='menber_login_db_done.php' method='post'>";
        echo "<input type='hidden' name='name' value='".$name."'>";
        echo "<input type='hidden' name='email' value='".$email."'>";
        echo "<input type='hidden' name='address' value='".$address."'>";
        echo "<input type='hidden' name='tel' value='".$tel."'>";
        echo "<input type='hidden' name='pass' value='".$pass."'>";
        echo "<input type='button' onclick='history.back()' value='戻る'>";
        echo "<input type='submit' value='登録'>";
    }

    ?>
    <br><br>
</body>
</html>