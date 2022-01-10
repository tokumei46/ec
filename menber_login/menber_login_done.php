<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>ログイン実行</title>
<link rel="stylesheet" href="../style.css">
</head>
    
    <body>
        <?php
        try{
            require_once("../common/common.php");

            $post = sanitize($_POST);

            $email = $post["email"];
            $pass = $post["pass"];

            $pass = md5($pass);

            $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
            $user = "root";
            $password = "root";
            $dbh = new PDO($dsn, $user, $password);
            $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $sql = "SELECT code, name FROM menber WHERE email=? AND password=?";
            $stmt = $dbh -> prepare($sql);
            $data[] = $email;
            $data[] = $pass;
            $stmt -> execute($data);

            $dbh = null;

            $rec = $stmt -> fetch(PDO::FETCH_ASSOC);

            if(empty($rec["name"]) === true) {
                echo "ログイン情報が間違っています<br>";
                echo "<a href='menber_login.php'>戻る</a>";
                exit();
            }
            session_start();
            $_SESSION["menber_login"] = 1;
            $_SESSION["menber_name"] = $rec["name"];
            $_SESSION["menber_code"] = $rec["code"];
            echo "ログイン成功<br>";
            echo "<a href='../shop/shop_list.php'>トップに戻る</a>";
        }
        catch(Exception $e) {
            echo "只今障害が発生しております。";
            echo "<a href='menber_login.php'>ログインページへ戻る</a>";
            exit();
        }
        ?>
        <br>
    </body>
</html>