<?php
require_once('DBConnection.php');
session_start();
// Inicializa a conexão com o banco de dados
$dbConnection = new DBConnection();
$conn = $dbConnection->getConnection();

// Busca lista de clientes para preencher o dropdown
try {
    $clientesStmt = $conn->query("SELECT idCliente, nome FROM cliente");
    $clientes = $clientesStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar clientes: " . $e->getMessage();
    $clientes = [];
}

// Verifica se o método do formulário é POST para processar o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $nomeCliente = $_POST['nomeCliente'];
    $idServico = $_POST['idServico'];
    $Data_Agendamento = $_POST['Data_Agendamento'];
    $Horario_Agendamento = $_POST['Horario_Agendamento'];
    $Observacoes_Adicionais = $_POST['Observacoes_Adicionais'] ?? '';
    $Status_Agendamento = $_POST['Status_Agendamento'];

    // Busca o ID do cliente com base no nome
    $clienteStmt = $conn->prepare("SELECT idCliente FROM cliente WHERE nome = ?");
    $clienteStmt->execute([$nomeCliente]);
    $cliente = $clienteStmt->fetch(PDO::FETCH_ASSOC);

    if ($cliente) {
        $idCliente = $cliente['idCliente'];

        // Prepara a query SQL
        $stmt = $conn->prepare("INSERT INTO agendamento_servico (idServico, idCliente, Data_Agendamento, Horario_Agendamento, Observacoes_Adicionais, Status_Agendamento) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $idServico);
        $stmt->bindParam(2, $idCliente);
        $stmt->bindParam(3, $Data_Agendamento);
        $stmt->bindParam(4, $Horario_Agendamento);
        $stmt->bindParam(5, $Observacoes_Adicionais);
        $stmt->bindParam(6, $Status_Agendamento);

        // Executa a query
        try {
            $stmt->execute();
            echo "<p>Agendamento adicionado com sucesso!</p>";
        } catch (PDOException $e) {
            echo "<p>Erro ao adicionar agendamento: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p>Cliente não encontrado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Agendamento</title> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    
    
    <link rel="stylesheet" href="../css/styles_funcionarios.css">
</head>
<body>


    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="../pages/dashboard.html">
                <img src="../img/login.png" width="40px">
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="dropdown">
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="index.php">Sair</a></li>
                </ul>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                <?php echo 'Bem-vindo, ' . htmlspecialchars($_SESSION['username']) . '!';
?>
                </button>
                
        </div>

    </nav>

    <h1>Adicionar Novo Agendamento</h1>

    <form method="POST">
        <label for="nomeCliente">Nome do Cliente:</label>
        <select id="nomeCliente" name="nomeCliente" required>
            <?php foreach ($clientes as $cliente) {
                echo "<option value=\"" . htmlspecialchars($cliente['nome']) . "\">" . htmlspecialchars($cliente['nome']) . "</option>";
            } ?>
        </select><br>

        <label for="idServico">ID do Serviço:</label>
        <input type="number" id="idServico" name="idServico" required><br>

        <label for="Data_Agendamento">Data do Agendamento:</label>
        <input type="date" id="Data_Agendamento" name="Data_Agendamento" required><br>

        <label for="Horario_Agendamento">Horário do Agendamento:</label>
        <input type="time" id="Horario_Agendamento" name="Horario_Agendamento" required><br>

        <label for="Observacoes_Adicionais">Observações Adicionais:</label>
        <textarea id="Observacoes_Adicionais" name="Observacoes_Adicionais"></textarea><br>

        <label for="Status_Agendamento">Status do Agendamento:</label>
        <select id="Status_Agendamento" name="Status_Agendamento" required>
            <option value="Agendado">Agendado</option>
            <option value="Cancelado">Cancelado</option>
            <option value="Concluído">Concluído</option>
        </select><br>

        <input type="submit" value="Adicionar Agendamento">
    </form>

    
</body>
</html>
