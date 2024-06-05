<?php
require_once('../pages/DBConnection.php');

// Verificar se o ID do pet foi passado na URL
if (isset($_GET['id'])) {
    $idPet = $_GET['id'];

    // Obter os dados do pet pelo ID
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    $stmt = $conn->prepare("SELECT * FROM pet WHERE idPet = :idPet");
    $stmt->bindParam(":idPet", $idPet);
    $stmt->execute();
    $pet = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "ID do pet não fornecido.";
    exit;
}

// Verificar se o formulário de edição foi submetido
if (isset($_POST['submitEditPet'])) {
    $nome = $_POST['nome'];
    $especie = $_POST['especie'];
    $raca = $_POST['raca'];
    $genero = $_POST['genero'];
    $idCliente = $_POST['idCliente'];

    // Chamar a função para editar o pet
    editPet($idPet, $nome, $especie, $raca, $genero, $idCliente);
}

// Função para editar um pet no banco de dados
function editPet($idPet, $nome, $especie, $raca, $genero, $idCliente) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("UPDATE pet SET nome = :nome, especie = :especie, raca = :raca, genero = :genero, idCliente = :idCliente WHERE idPet = :idPet");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":especie", $especie);
        $stmt->bindParam(":raca", $raca);
        $stmt->bindParam(":genero", $genero);
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->bindParam(":idPet", $idPet);
        $stmt->execute();
        echo "Pet editado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao editar pet: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pet</title>
    <link rel="stylesheet" href="../css/styles_funcionarios.css">
</head>
<body>
    <h1>Editar Pet</h1>

    <!-- Formulário para editar pet -->
    <form method="post">
        <input type="hidden" name="idPet" value="<?php echo htmlspecialchars($pet['idPet']); ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($pet['nome'] ?? ''); ?>" required><br>
        <label for="especie">Espécie:</label>
        <input type="text" id="especie" name="especie" value="<?php echo htmlspecialchars($pet['especie'] ?? ''); ?>"><br>
        <label for="raca">Raça:</label>
        <input type="text" id="raca" name="raca" value="<?php echo htmlspecialchars($pet['raca'] ?? ''); ?>"><br>
        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" value="<?php echo htmlspecialchars($pet['genero'] ?? ''); ?>"><br>
        <label for="idCliente">ID Cliente:</label>
        <input type="number" id="idCliente" name="idCliente" value="<?php echo htmlspecialchars($pet['idCliente'] ?? ''); ?>" required><br>
        <input type="submit" name="submitEditPet" value="Salvar Alterações">
        <a href="Pets.php"><input type="button" name="voltar" value="Voltar"></a>
    </form>
</body>
</html>
