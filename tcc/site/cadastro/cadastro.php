<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Gerar ID aleatório de 3 dígitos
        $id = rand(1, 999);

        // Receber dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Conectar ao banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "site";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar a conexão
        echo '<body style="background-color: #000; color: #e0e0e0; font-family: Arial, sans-serif;">';
        if ($conn->connect_error) {
            echo "<span style='color:red;'>Erro na conexão com o banco de dados: " . $conn->connect_error . "</span>";
        } else {
            // Inserir os dados na tabela de usuários
            $sql = "INSERT INTO cadastro (id, nome, email, senha) VALUES ('$id', '$nome', '$email', '$senha')";
            if ($conn->query($sql) === TRUE) {
                echo "<span style='color:limegreen;'>Usuário cadastrado com sucesso!</span>";
                echo "<br><span style='color:#fff;'>Você será redirecionado para o login em <span id='contador'>5</span> segundos...</span>";
                // Caveira e animação
                echo '
                <div id="skull" style="position:fixed;left:50%;top:60%;transform:translate(-50%,-50%);z-index:999;">
                    <img src="https://img.icons8.com/ios-filled/100/ffffff/skull.png" width="80" id="skull-img" style="transition: transform 1s cubic-bezier(.68,-0.55,.27,1.55);animation: spin 1s linear infinite;">
                </div>
                <style>
                    @keyframes spin {
                        0% { transform: rotate(0deg);}
                        100% { transform: rotate(360deg);}
                    }
                </style>
                <script>
                    var segundos = 5;
                    var intervalo = setInterval(function() {
                        segundos--;
                        document.getElementById("contador").textContent = segundos;
                        if(segundos === 1){
                            // anima a caveira para cima e some
                            var skull = document.getElementById("skull-img");
                            skull.style.transition = "transform 1s cubic-bezier(.68,-0.55,.27,1.55), opacity 1s";
                            skull.style.transform = "translateY(-300px) scale(1.5) rotate(-20deg)";
                            skull.style.opacity = "0";
                        }
                        if(segundos <= 0){
                            clearInterval(intervalo);
                            window.location.href = "login.html";
                        }
                    }, 1000);
                </script>
                ';
            } else {
                echo "<span style='color:red;'>Erro ao cadastrar o usuário: " . $conn->error . "</span>";
            }
            // Fechar a conexão com o banco de dados
            $conn->close();
        }
        echo '</body>';
    } else {
        // Se acessar direto, redireciona para o formulário
        header("Location: cadastro.html");
        exit;
    }
?>