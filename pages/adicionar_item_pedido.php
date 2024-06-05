<?php
session_start(); // Inicia a sessão

require_once('DBConnection.php');
$dbConnection = new DBConnection();
$conn = $dbConnection->getConnection();

// Inicializa o array de itens do pedido na sessão, se ainda não existir
if (!isset($_SESSION['itemPedido'])) {
    $_SESSION['itemPedido'] = [];
}

// Verificar se o formulário de adicionar item foi submetido
if (isset($_POST['submitAdicionarItem'])) {
    $idProduto = $_POST['idProduto'];
    $quantidadeVendida = $_POST['quantidadeVendida'];

    // Adicionar o item ao array de itens do pedido na sessão
    $_SESSION['itemPedido'][] = [
        'idProduto' => $idProduto,
        'quantidadeVendida' => $quantidadeVendida
    ];
}

// Calcular o total de produtos
$totalProdutos = 0;
foreach ($_SESSION['itemPedido'] as $item) {
    $stmt = $conn->prepare("SELECT Preco FROM produto WHERE idProduto = :idProduto");
    $stmt->bindParam(":idProduto", $item['idProduto']);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalProdutos += $produto['Preco'] * $item['quantidadeVendida'];
}

// Verificar se o formulário de finalização de venda foi submetido
if (isset($_POST['submitFinalizarVenda'])) {
    $idCliente = $_POST['idCliente'];
    $totalServicos = $_POST['totalServicos'];
    $metodoPagamento = $_POST['metodoPagamento'];
    $statusPagamento = $_POST['statusPagamento'];

    try {
        $conn->beginTransaction();

        // Inserir a venda no banco de dados
        $stmt = $conn->prepare("INSERT INTO venda (data_venda, idCliente, total_venda, total_produtos, total_servicos, metodo_pagamento, status_pagamento) VALUES (CURDATE(), :idCliente, :totalVenda, :totalProdutos, :totalServicos, :metodoPagamento, :statusPagamento)");
        $stmt->bindParam(":idCliente", $idCliente);
        $totalVenda = $totalProdutos + $totalServicos;
        $stmt->bindParam(":totalVenda", $totalVenda);
        $stmt->bindParam(":totalProdutos", $totalProdutos);
        $stmt->bindParam(":totalServicos", $totalServicos);
        $stmt->bindParam(":metodoPagamento", $metodoPagamento);
        $stmt->bindParam(":statusPagamento", $statusPagamento);
        $stmt->execute();
        $idVenda = $conn->lastInsertId();

        // Inserir os itens do pedido no banco de dados
        $stmt = $conn->prepare("INSERT INTO itempedido (idVenda, idProduto, quantidade_vendida) VALUES (:idVenda, :idProduto, :quantidadeVendida)");
        foreach ($_SESSION['itemPedido'] as $item) {
            $stmt->bindParam(":idVenda", $idVenda);
            $stmt->bindParam(":idProduto", $item['idProduto']);
            $stmt->bindParam(":quantidadeVendida", $item['quantidadeVendida']);
            $stmt->execute();
        }

        // Inserir o pagamento no banco de dados
        $stmt = $conn->prepare("INSERT INTO pagamento (idVenda, metodo_pagamento, data_pagamento, valor_pago) VALUES (:idVenda, :metodoPagamento, CURDATE(), :valorPago)");
        $stmt->bindParam(":idVenda", $idVenda);
        $stmt->bindParam(":metodoPagamento", $metodoPagamento);
        $stmt->bindParam(":valorPago", $totalVenda);
        $stmt->execute();
        $idPagamento = $conn->lastInsertId();

        $conn->commit();

        // Limpar os itens do pedido da sessão após finalizar a venda
        $_SESSION['itemPedido'] = [];

        // Redirecionar para a página de nota fiscal
        header("Location: nota_fiscal.php?idVenda=$idVenda&idPagamento=$idPagamento");
        exit;
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Erro ao finalizar a venda: " . $e->getMessage();
    }
}

// Obter a lista de produtos para o dropdown
$produtosStmt = $conn->query("SELECT idProduto, nome FROM produto");
$produtos = $produtosStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Item ao Pedido</title>
    <link rel="stylesheet" href="../css/style_item_pedido.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    
</head>
<body>

<nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="dashboard.php">
                <img src="../img/login.png" width="40px">
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                <?php echo 'Bem-vindo, ' . htmlspecialchars($_SESSION['username']) . '!';
?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="#">Sair</a></li>
                </ul>
        </div>

    </nav>
    <h1>Adicionar Item ao Pedido</h1>

    <!-- Formulário para adicionar item ao pedido -->
    <form method="post">
        <label for="idProduto">Produto:</label>
        <select id="idProduto" name="idProduto" required>
            <?php foreach ($produtos as $produto): ?>
                <option value="<?php echo $produto['idProduto']; ?>"><?php echo $produto['nome']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label for="quantidadeVendida">Quantidade Vendida:</label>
        <input type="number" id="quantidadeVendida" name="quantidadeVendida" required><br>
        <input type="submit" name="submitAdicionarItem" value="Adicionar Item">
    </form>

    <!-- Exibir itens do pedido -->
    <h2>Itens do Pedido</h2>
    <table>
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Quantidade Vendida</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($_SESSION['itemPedido']) > 0): ?>
                <?php foreach ($_SESSION['itemPedido'] as $item): ?>
                    <?php
                    // Obter o nome do produto para exibição
                    $stmt = $conn->prepare("SELECT nome FROM produto WHERE idProduto = :idProduto");
                    $stmt->bindParam(":idProduto", $item['idProduto']);
                    $stmt->execute();
                    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $item['quantidadeVendida']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Nenhum item adicionado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Exibir total de produtos -->
    <h2>Total de Produtos: R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></h2>

    <!-- Formulário para finalizar venda -->
    <h2>Finalizar Venda</h2>
    <form method="post">
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
        <label for="totalServicos">Total de Serviços:</label>
        <input type="number" id="totalServicos" name="totalServicos" step="0.01" required><br>
        <label for="metodoPagamento">Método de Pagamento:</label>
            <select for="metodoPagamento" id="metodoPagamento" name="metodoPagamento" required>
            <option value="Cartão de Crédito">Cartão de Crédito</option>
            <option value="Transferência Bancária">Transferência Bancária</option>
            <option value="Cartão de Débito">Cartão de Débito</option>
            <option value="Dinheiro">Dinheiro</option>
        </select><br>
        <label for="statusPagamento">Status de Pagamento:</label>
        <select id="statusPagamento" name="statusPagamento" required>
            <option value="Completo" selected>Completo</option>
            <option value="Pendente">Completo</option>
        </select><br>
        <input type="submit" name="submitFinalizarVenda" value="Finalizar Venda">
        <a href="Clientes.php"><input type="button" name="newCliente" value="Novo Cliente"></a>

    </form>
</body>
</html>
