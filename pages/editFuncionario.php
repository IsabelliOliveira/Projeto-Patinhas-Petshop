<?php
require_once('DBConnection.php');
session_start();

// Verificar se o ID do funcionário foi passado na URL
if(isset($_GET['id'])) {
    $idFuncionario = $_GET['id'];

    // Obter os dados do funcionário pelo ID
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    $stmt = $conn->prepare("SELECT * FROM funcionario WHERE idFuncionario = :idFuncionario");
    $stmt->bindParam(":idFuncionario", $idFuncionario);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "ID do funcionário não fornecido.";
    exit;
}

// Verificar se o formulário de edição foi submetido
if(isset($_POST['submitEditFuncionario'])) {
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $cargo = $_POST['cargo'];
    $senha = $_POST['senha'];

    // Chamar a função para editar o funcionário
    editFuncionario($idFuncionario, $nome, $username, $cargo, $senha);
}

// Função para editar um funcionário no banco de dados
function editFuncionario($idFuncionario, $nome, $username, $cargo, $senha) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("UPDATE funcionario SET nome = :nome, username = :username, cargo = :cargo, senha = :senha WHERE idFuncionario = :idFuncionario");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":cargo", $cargo);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":idFuncionario", $idFuncionario);
        $stmt->execute();
        echo "Funcionário editado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao editar funcionário: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="../css/styles_funcionarios.css">
</head>
<body>
    <h1>Editar Funcionário</h1>

    <!-- Formulário para editar funcionário -->
    <form method="post">
        <input type="hidden" name="idFuncionario" value="<?php echo $funcionario['idFuncionario']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $funcionario['nome']; ?>" required><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $funcionario['username']; ?>" required><br>
        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" value="<?php echo $funcionario['cargo']; ?>" required><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" value="<?php echo $funcionario['senha']; ?>" required><br>
        <input type="submit" name="submitEditFuncionario" value="Salvar Alterações">
         <a href="funcionarios.php"><input type="button" name="voltar" value="Voltar"></a>
    </form>
</body>
</html>
