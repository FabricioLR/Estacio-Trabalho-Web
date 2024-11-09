<?php
    include("db.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        exit;
    }

    if (empty($_POST["id"])){
        exit;
    }

    try {
        $conn = connect();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $_SESSION["id"]);
        $stmt->execute();

        $rows = $stmt->fetchAll();

        if (count($rows) <= 0){
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM mensagens WHERE id = :id");
        $stmt->bindParam(":id", $_POST["id"]);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
?>