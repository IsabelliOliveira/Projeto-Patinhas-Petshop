<?php
require_once('DBConnection.php');
$dbConnection = new DBConnection(); // Instanciando a classe DBConnection
$conn = $dbConnection->getConnection(); // Obtendo a conexão

// Função para adicionar um novo produto
if(isset($_POST['submitProduto'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidadeEstoque = $_POST['quantidadeEstoque'];
    $quantidadeMinima = $_POST['quantidadeMinima'];

    addProduto($nome, $descricao, $preco, $quantidadeEstoque, $quantidadeMinima);
}

// Função para adicionar um novo produto ao banco de dados
function addProduto($nome, $descricao, $preco, $quantidadeEstoque, $quantidadeMinima) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("INSERT INTO produto (Nome, Descricao, Preco, Quantidade_Estoque, Quantidade_Minima) VALUES (:nome, :descricao, :preco, :quantidadeEstoque, :quantidadeMinima)");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":preco", $preco);
        $stmt->bindParam(":quantidadeEstoque", $quantidadeEstoque);
        $stmt->bindParam(":quantidadeMinima", $quantidadeMinima);
        $stmt->execute();
        echo "Produto adicionado com sucesso.";
    } catch(PDOException $e) {
        echo "Erro ao adicionar produto: " . $e->getMessage();
    }
}

// Função para deletar um produto
if(isset($_GET['action']) && $_GET['action'] == 'deleteProduto' && isset($_GET['id'])) {
    $idProduto = $_GET['id'];
    if(deleteProduto($idProduto)) {
        echo "Produto excluído com sucesso.";
    } else {
        echo "Erro ao excluir produto.";
    }
}

// Função para deletar um produto do banco de dados
function deleteProduto($idProduto) {
    $dbConnection = new DBConnection();
    $conn = $dbConnection->getConnection();

    try {
        $stmt = $conn->prepare("DELETE FROM produto WHERE idProduto = :idProduto");
        $stmt->bindParam(":idProduto", $idProduto);
        $stmt->execute();
        return true;
    } catch(PDOException $e) {
        echo "Erro ao excluir produto: " . $e->getMessage();
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
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


    <h1>Gerenciamento de Produtos</h1>

    <!-- Formulário para adicionar produto -->
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea><br>
        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" required><br>
        <label for="quantidadeEstoque">Quantidade em Estoque:</label>
        <input type="number" id="quantidadeEstoque" name="quantidadeEstoque" required><br>
        <label for="quantidadeMinima">Quantidade Mínima:</label>
        <input type="number" id="quantidadeMinima" name="quantidadeMinima" required><br>
        <input type="submit" name="submitProduto" value="Adicionar Produto">
    </form>

    <!-- Tabela para exibir os produtos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade em Estoque</th>
                <th>Quantidade Mínima</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aqui você pode usar PHP para iterar sobre os produtos e exibi-los na tabela -->
            <!-- Exemplo: -->
            <?php
            // Consulta para obter todos os produtos
            $query = "SELECT * FROM produto";
            $stmt = $conn->query($query);

            // Verifica se há produtos
            if($stmt->rowCount() > 0) {
                // Loop através dos resultados
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row['idProduto'] ."</td>";
                    echo "<td>" . $row['Nome'] . "</td>"; // Alterado de 'nome' para 'Nome'
                    echo "<td>" . $row['Descricao'] . "</td>"; // Alterado de 'descricao' para 'Descricao'
                    echo "<td>" . $row['Preco'] . "</td>"; // Alterado de 'preco' para 'Preco'
                    echo "<td>" . $row['Quantidade_Estoque'] . "</td>"; // Alterado de 'quantidade_estoque' para 'Quantidade_Estoque'
                    echo "<td>" . $row['Quantidade_Minima'] . "</td>"; // Alterado de 'quantidade_minima' para 'Quantidade_Minima'
                    echo "<td>";
                    echo "<a href='editar.php?id=" . $row['idProduto'] . "'>Editar</a>";
                    echo " | ";
                    echo "<a href='dashboard.php?action=deleteProduto&id=" . $row['idProduto'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>Deletar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nenhum produto encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
