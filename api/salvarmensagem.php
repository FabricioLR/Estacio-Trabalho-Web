<?php
    include("db.php");

    if ($_SERVER["REQUEST_METHOD"] !== "POST"){
        exit;
    }

    if (empty($_POST["nome"]) || empty($_POST["email"]) || empty($_POST["telefone"]) || empty($_POST["mensagem"])){
        http_response_code(400);
        echo json_encode(["error" => "Alguns campos não foram preenchidos"]);
        exit;
    }
    
    try {
        $conn = connect();

        $stmt = $conn->prepare("INSERT INTO mensagens (nome, email, telefone, mensagem) VALUES (:nome, :email, :telefone, :mensagem)");
        $stmt->bindParam(":nome", $_POST["nome"]);
        $stmt->bindParam(":email", $_POST["email"]);
        $stmt->bindParam("telefone", $_POST["telefone"]);
        $stmt->bindParam(":mensagem", $_POST["mensagem"]);
        $result = $stmt->execute();

        if ($result){
            http_response_code(200);
            echo json_encode(["success" => "Sua mensagem foi enviada com sucesso"]);
            exit;
        } else {
            http_response_code(400);
            echo json_encode(["error" => "A mensagem não pôde ser enviar, tente mais tarde"]);
            exit;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>