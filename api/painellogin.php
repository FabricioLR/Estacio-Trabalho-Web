<?php
    include("db.php");

    session_start();

    
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $_SESSION["error"] = "";

        if (empty($_POST["username"] || empty($_POST["password"]))){
            $_SESSION["error"] = "Username and password is required!";
            header("location: painellogin.php");
            exit;
        }

        try {
            $conn = connect();

            $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->bindParam(":username", $_POST["username"]);
            $stmt->execute();

            $rows = $stmt->fetchAll();

            if (count($rows) <= 0){
                $_SESSION["error"] = "Incorrect username or password";
                header("location: painellogin.php");
                exit;
            }

            if (!password_verify($_POST["password"], $rows[0]["password"])){
                $_SESSION["error"] = "Incorrect username or password";
                header("location: painellogin.php");
                exit;
            }

            $_SESSION["id"] = $rows[0]["id"];
            header("location: painel.php");
            exit;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Login</title>
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }

        body{
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        p{
            margin-top: 30px;
            margin-bottom: 30px;
        }
        form{
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input{
            width: 300px;
            height: 30px;
            outline: none;
            font-size: 15px;
            padding: 5px;
            margin-bottom: 10px;
        }
        input:last-child{
            width: 200px;
            margin-top: 30px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <p><?php echo $_SESSION["error"]?></p>
    <form action="painellogin.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Acessar">
    </form>
</body>
</html>