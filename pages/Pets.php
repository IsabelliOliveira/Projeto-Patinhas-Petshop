<?php
require_once('DBConnection.php');
$dbConnection = new DBConnection();
$conn = $dbConnection->getConnection();

// Função para adicionar um novo pet
if(isset($_POST['submitPet'])) {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $genero = $_POST['genero'];
    $idCliente = $_POST['idCliente'];

    addPet($nome, $especie, $raca, $genero, $idCliente);
}

// Função para adicionar um novo pet ao banco de dados
function addPet($nome, $especie, $raca, $genero, $idCliente) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("INSERT INTO pet (Nome, Especie, Raca, Genero, idCliente) VALUES (:nome, :especie, :raca, :genero, :idCliente)");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":especie", $especie);
        $stmt->bindParam(":raca", $raca);
        $stmt->bindParam(":genero", $genero);
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        echo "Pet adicionado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao adicionar pet: " . $e->getMessage();
    }
}

// Função para deletar um pet
if(isset($_GET['action']) && $_GET['action'] == 'deletePet' && isset($_GET['id'])) {
    $idPet = $_GET['id'];
    if(deletePet($idPet)) {
        echo "Pet excluído com sucesso.";
    } else {
        echo "Erro ao excluir pet.";
    }
}

// Função para deletar um pet do banco de dados
function deletePet($idPet) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("DELETE FROM pet WHERE idPet = :idPet");
        $stmt->bindParam(":idPet", $idPet);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        echo "Erro ao excluir pet: " . $e->getMessage();
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pets</title>
    <link rel="stylesheet" href="../css/styles_pets.css">
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

    <h1>Gerenciamento de Pets</h1>

    <!-- Tabela para exibir os pets -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Espécie</th>
                <th>Raça</th>
                <th>Gênero</th>
                <th>Cliente</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta para obter todos os pets e os nomes dos clientes associados
            $query = "
                SELECT pet.*, cliente.Nome as NomeCliente
                FROM pet
                JOIN cliente ON pet.idCliente = cliente.idCliente
                Order by idPet
            ";
            $stmt = $conn->query($query);

            // Verifica se há pets
            if($stmt->rowCount() > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['idPet'] . "</td>";
                    echo "<td>" . $row['Nome'] . "</td>";
                    echo "<td>" . $row['Especie'] . "</td>";
                    echo "<td>" . $row['Raca'] . "</td>";
                    echo "<td>" . $row['Genero'] . "</td>";
                    echo "<td>" . $row['NomeCliente'] . "</td>";
                    echo "<td>";
                    echo "<a href='editar_pet.php?id=" . $row['idPet'] . "'>Editar</a>";
                    echo " | ";
                    echo "<a href='dashboard.php?action=deletePet&id=" . $row['idPet'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este pet?\")'>Deletar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum pet encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br><br>

        <!-- Formulário para adicionar pet -->
        <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        
        <label for="especie">Espécie:</label>
        <select id="especie" name="especie" required>
            <option value="Gato">Gato</option>
            <option value="Cachorro">Cachorro</option>
        </select><br>
        
        <label for="raca">Raça:</label>
        <input type="text" id="raca" name="raca" required><br>
        
        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required>
            <option value="Fêmea">Fêmea</option>
            <option value="Macho">Macho</option>
        </select><br>
        
        <label for="idCliente">Cliente:</label>
        <select id="idCliente" name="idCliente" required>
            <?php
            // Recuperar todos os clientes para preencher o dropdown
            $clienteQuery = "SELECT idCliente, Nome FROM cliente";
            $clienteStmt = $conn->query($clienteQuery);
            while($cliente = $clienteStmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $cliente['idCliente'] . "'>" . $cliente['Nome'] . "</option>";
            }
            ?>
        </select><br><br>
        
        <input type="submit" name="submitPet" value="Adicionar Pet">

        <input type="button" name="newCliente" value="Novo Cliente">

    </form>

    <br><br>
                        
</body>
</html>
