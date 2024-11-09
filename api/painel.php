<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <script src="https://kit.fontawesome.com/e7eab8a619.js" crossorigin="anonymous"></script>
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
            overflow-x: hidden;
        }

        table{
            margin-top: 100px;
            table-layout: fixed;
            border-collapse: collapse;
        }

        td, th{
            border: 1px solid black;
        }

        td, th{
            padding: 5px;
            font-size: 18px;
            word-wrap: break-word
        }

        .a{
            max-width: 50px;
        }

        .b{
            max-width: 150px;
        }
        .c{
            max-width: 350px;
        }
        .d{
            max-width: 250px;
        }
        .e{
            max-width: 350px;
        }

        .f{
            border: none;
        }

        .f i{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
        include("db.php");

        session_start();

        if (empty($_SESSION["id"])){
            header("location: painellogin.php");
            exit;
        }

        try {
            $conn = connect();

            $stmt = $conn->prepare("SELECT * FROM mensagens");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            if (count($rows) > 0){
                echo "<table><tr><th class='f'></th><th class='a'>id</th><th class='b'>nome</th><th class='c'>email</th><th class='d'>telefone</th><th class='e'>mensagem</th></tr>";
                foreach($rows as $row){
                    echo "<tr><td class='f' onclick='excluir(" . $row["id"] . ")'><i class='fa-solid fa-trash'></i></td><td class='a'>" . $row["id"] . "</td><td class='b'>" . $row["nome"] . "</td><td class='c'>" . $row["email"] . "</td><td class='d'>" . $row["telefone"] . "</td><td class='e'>" . $row["mensagem"] . "</td></tr>";
                }
                echo "</table>";
            } else {
                echo "Sem mensagens";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    ?>
    <script>
        function excluir(id){
            const table = document.getElementsByTagName("table")[0].children[0].childNodes.forEach(node => {
                if (node.childNodes[1].innerText == id){
                    node.remove()

                    fetch("excluirmensagem.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded"
                        },
                        body: new URLSearchParams({ id })
                    })
                }
            })
        }   
    </script>
</body>
</html>
