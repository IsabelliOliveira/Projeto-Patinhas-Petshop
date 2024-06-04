<?php
require_once('DBConnection.php');
$dbConnection = new DBConnection();
$conn = $dbConnection->getConnection();

// Função para adicionar um novo cliente
if(isset($_POST['submitCliente'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $numeroTelefone = $_POST['numeroTelefone'];

    addCliente($nome, $cpf, $numeroTelefone);
}

// Função para adicionar um novo cliente ao banco de dados
function addCliente($nome, $cpf, $numeroTelefone) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("INSERT INTO cliente (Nome, CPF, Numero_Telefone) VALUES (:nome, :cpf, :numeroTelefone)");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":numeroTelefone", $numeroTelefone);
        $stmt->execute();
        echo "Cliente adicionado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao adicionar cliente: " . $e->getMessage();
    }
}

// Função para deletar um cliente
if(isset($_GET['action']) && $_GET['action'] == 'deleteCliente' && isset($_GET['id'])) {
    $idCliente = $_GET['id'];
    if(deleteCliente($idCliente)) {
        echo "Cliente excluído com sucesso.";
    } else {
        echo "Erro ao excluir cliente.";
    }
}

// Função para deletar um cliente do banco de dados
function deleteCliente($idCliente) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("DELETE FROM cliente WHERE idCliente = :idCliente");
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        echo "Erro ao excluir cliente: " . $e->getMessage();
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="../css/styles_produtos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    
</head>
<body>

    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="../pages/dashboard.PHP">
                <img src="../img/login.png" width="40px">
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                  Bem-vindo novamente, fulano!
                </button>
        </div>

    </nav>



    <h1>Gerenciamento de Clientes</h1>


    <!-- Formulário para adicionar cliente -->
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required><br>
        <label for="numeroTelefone">Número de Telefone:</label>
        <input type="text" id="numeroTelefone" name="numeroTelefone" required><br>
        <input type="submit" name="submitCliente" value="Adicionar Cliente">
    </form>

    <!-- Tabela para exibir os clientes -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Número de Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aqui você pode usar PHP para iterar sobre os clientes e exibi-los na tabela -->
            <!-- Exemplo: -->
            <?php
            // Consulta para obter todos os clientes
            $query = "SELECT * FROM cliente";
            $stmt = $conn->query($query);

            // Verifica se há clientes
            if($stmt->rowCount() > 0) {
                // Loop através dos resultados
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['idCliente'] ."</td>";
                    echo "<td>" . $row['Nome'] . "</td>";
                    echo "<td>" . $row['CPF'] . "</td>";
                    echo "<td>" . $row['Numero_Telefone'] . "</td>";
                    echo "<td>";
                    echo "<a href='editar_cliente.php?id=" . $row['idCliente'] . "'>Editar</a>";
                    echo " | ";
                    echo "<a href='../pages/Clientes.PHP?action=deleteCliente&id=" . $row['idCliente'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este cliente?\")'>Deletar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nenhum cliente encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <br> <br> <br>
</body>
</html>
