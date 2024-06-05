<?php
require_once('../pages/DBConnection.php');

// Verificar se o ID do produto foi passado na URL
if(isset($_GET['id'])) {
    $idProduto = $_GET['id'];

    // Obter os dados do produto pelo ID
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    $stmt = $conn->prepare("SELECT * FROM produto WHERE idProduto = :idProduto");
    $stmt->bindParam(":idProduto", $idProduto);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "ID do produto não fornecido.";
    exit;
}

// Verificar se o formulário de edição foi submetido
if(isset($_POST['submitEditProduto'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidadeEstoque = $_POST['quantidadeEstoque'];
    $quantidadeMinima = $_POST['quantidadeMinima'];
    $idFornecedor = $_POST['idFornecedor'];

    // Chamar a função para editar o produto
    editProduto($idProduto, $nome, $descricao, $preco, $quantidadeEstoque, $quantidadeMinima, $idFornecedor);
}

// Função para editar um produto no banco de dados
function editProduto($idProduto, $nome, $descricao, $preco, $quantidadeEstoque, $quantidadeMinima, $idFornecedor) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("UPDATE produto SET nome = :nome, descricao = :descricao, preco = :preco, quantidade_estoque = :quantidadeEstoque, quantidade_minima = :quantidadeMinima, idFornecedor = :idFornecedor WHERE idProduto = :idProduto");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":quantidadeEstoque", $quantidadeEstoque);
        $stmt->bindParam(":quantidadeMinima", $quantidadeMinima);
        $stmt->bindParam(":idFornecedor", $idFornecedor);
        $stmt->bindParam(":idProduto", $idProduto);
        $stmt->execute();
        echo "Produto editado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao editar produto: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/styles_funcionarios.css">
</head>
<body>
    <h1>Editar Produto</h1>

    <!-- Formulário para editar produto -->
    <form method="post">
        <input type="hidden" name="idProduto" value="<?php echo $produto['idProduto']; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $produto['Nome']; ?>" required><br>
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required><?php echo $produto['Descricao']; ?></textarea><br>
        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" value="<?php echo $produto['Preco']; ?>" required><br>
        <label for="quantidadeEstoque">Quantidade em Estoque:</label>
        <input type="number" id="quantidadeEstoque" name="quantidadeEstoque" value="<?php echo $produto['Quantidade_Estoque']; ?>" required><br>
        <label for="quantidadeMinima">Quantidade Mínima:</label>
        <input type="number" id="quantidadeMinima" name="quantidadeMinima" value="<?php echo $produto['Quantidade_Minima']; ?>" required><br>
        <label for="idFornecedor">ID Fornecedor:</label>
        <input type="number" id="idFornecedor" name="idFornecedor" value="<?php echo $produto['idFornecedor']; ?>" required><br>
        <input type="submit" name="submitEditProduto" value="Salvar Alterações">
        <a href="produto.php"><input type="button" name="voltar" value="Voltar"></a>
    </form>
</body>
</html>
