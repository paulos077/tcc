<?php
session_start();

// Dados do banco
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site";

// Conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe dados do formulário
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Consulta segura
$sql = "SELECT id, nome FROM cadastro WHERE email = ? AND senha = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    $_SESSION['usuario'] = $usuario['nome'];
    echo "
    <body style='background-color:#000;'>
        <div style='display:flex;flex-direction:column;align-items:center;justify-content:center;height:100vh;'>
            <h2 style='color:#8b0000;text-align:center;font-family:Creepster,cursive;margin-top:50px;'>Bem-vindo, " . htmlspecialchars($usuario['nome']) . "...</h2>
            <p style='color:#fff;text-align:center;font-size:1.5em;'>Você teve coragem de entrar!</p>
            <div style='margin-top:40px;'>
                <video autoplay loop muted id='dragon' style='width:320px;'>
                    <source src='camisas/dragão_animation.mp4' type='video/mp4'>
                    Seu navegador não suporta vídeo.
                </video>
            </div>
            <p style='color:#fff;margin-top:20px;'>Carregando... <span id='contador'>3</span></p>
        </div>
        <script>
            var segundos = 3;
            var intervalo = setInterval(function() {
                segundos--;
                document.getElementById('contador').textContent = segundos;
                if(segundos <= 0){
                    clearInterval(intervalo);
                    window.location.href = '../index/index.html';
                }
            }, 1000);
        </script>
    </body>
    ";
} else {
    echo "<h2 style='color:#ff0000;text-align:center;font-family:Creepster,cursive;margin-top:50px;'>Credenciais incorretas... ou você não deveria estar aqui!</h2>";
    echo "<p style='color:#fff;text-align:center;'><a href='login.html' style='color:#ff0000;text-decoration:underline;'>Tentar novamente</a></p>";
}

$stmt->close();
$conn->close();
?>