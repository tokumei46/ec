<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>会員登録完了</title>
<link rel="stylesheet" href="../style.css">
</head>

</html>

<body>
    <?php
    
    try{
        require_once("../common/common.php");
        
        $post = sanitize($_POST);
        $name = $post["name"];
        $address = $post["address"];
        $tel = $post["tel"];
        $email = $post["email"];
        $pass = $post["pass"];
        
        $pass = md5($pass);
        
        $dsn = "mysql:host=localhost;dbname=shop;charset=utf8";
        $user = "root";
        $password = "root";
        $dbh = new PDO($dsn, $user, $password);
        $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT email FROM menber WHERE1";
        $stmt = $dbh -> prepare($sql);
        $stmt -> execute();

        while(true) {
            $rec = $stmt -> fetch(PDO::FETCH_ASSOC);
            if(empty($rec) === true) {
                break;
            }
            $mail[] = $rec["email"];
        }
        if(empty($mail) === true) {
            $mail[] = "";
        }
        if(in_array($email, $mail) === true) {
            echo "すでに使われているメールアドレスです<br>";
            echo "<a href='menber_login_db.php'>トッフへ</a> ";
            $dbh = null;
        } else {
        $sql = "INSERT INTO menber(name, email, address, tel, password) VALUES(?,?,?,?,?)";
        $stmt = $dbh -> prepare($sql);
        $data[] = $name;
        $data[] = $email;
        $data[] = $address;
        $data[] = $tel;
        $data[] = $pass;
        $stmt -> execute($data);
        
        $dbh = null;

        echo "登録完了しました<br>";
        echo "<a href='menber_login.php'>ログインページへ戻る</a>";
        
        }
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