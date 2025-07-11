<?php
$id = $_POST['id'] ?? '';

// Inclui o arquivo de configuração para a conexão
include_once('config.php');

// Verificar a conexão
if (!$conexao) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

// Prepara a consulta SQL para evitar SQL Injection
$sql = "SELECT id, nome, email FROM cadastro WHERE id = ?";
$stmt = $conexao->prepare($sql);

if ($stmt) {
    // Liga o parâmetro (s = string)
    $stmt->bind_param("s", $id);

    // Executa a consulta
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificando se a consulta retornou resultados
    if ($result && $result->num_rows > 0) {
        echo "<h1>Dados do Usuário</h1>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                    <td>" . htmlspecialchars($row["nome"]) . "</td>
                    <td>" . htmlspecialchars($row["email"]) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Nenhum resultado encontrado para o ID: " . htmlspecialchars($id);
    }

    $stmt->close();
} else {
    echo "Ocorreu um erro ao preparar a consulta.";
}

// Fechando a conexão com o banco de dados
mysqli_close($conexao);
?>