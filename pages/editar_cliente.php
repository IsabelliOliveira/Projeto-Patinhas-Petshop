<?php
require_once('DBConnection.php');

// Verificar se o ID do cliente foi passado na URL
if(isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Obter os dados do cliente pelo ID
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    $stmt = $conn->prepare("SELECT * FROM cliente WHERE idCliente = :idCliente");
    $stmt->bindParam(":idCliente", $idCliente);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "ID do cliente não fornecido.";
    exit;
}

// Verificar se o formulário de edição foi submetido
if(isset($_POST['submitEditCliente'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $numeroTelefone = $_POST['numeroTelefone'];

    // Chamar a função para editar o cliente
    editCliente($idCliente, $nome, $cpf, $numeroTelefone);
}

// Função para editar um cliente no banco de dados
function editCliente($idCliente, $nome, $cpf, $numeroTelefone) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("UPDATE cliente SET Nome = :nome, CPF = :cpf, Numero_Telefone = :numeroTelefone WHERE idCliente = :idCliente");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":numeroTelefone", $numeroTelefone);
        $stmt->bindParam(":idCliente", $idCliente);
        $stmt->execute();
        echo "Cliente editado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao editar cliente: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../css/styles_funcionarios.css">
</head>
<body>
    <h1>Editar Cliente</h1>

    <!-- Formulário para editar cliente -->
    <form method="post">
        <input type="hidden" name="idCliente" value="<?php echo $cliente['idCliente']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $cliente['Nome']; ?>" required><br>
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="<?php echo $cliente['CPF']; ?>" required><br>
        <label for="numeroTelefone">Número de Telefone:</label>
        <input type="text" id="numeroTelefone" name="numeroTelefone" value="<?php echo $cliente['Numero_Telefone']; ?>" required><br>
        <input type="submit" name="submitEditCliente" value="Salvar Alterações">
        <a href="Clientes.php"><input type="button" name="voltar" value="Voltar"></a>
    </form>
</body>
</html>
