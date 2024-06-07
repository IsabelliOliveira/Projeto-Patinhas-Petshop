<?php
require_once('DBConnection.php');
session_start();
$dbConnection = new DBConnection();
$conn = $dbConnection->getConnection();

// Verificar se os IDs de venda e pagamento foram passados na URL
if (isset($_GET['idVenda']) && isset($_GET['idPagamento'])) {
    $idVenda = $_GET['idVenda'];
    $idPagamento = $_GET['idPagamento'];

    // Obter os detalhes da venda
    $stmt = $conn->prepare("
        SELECT venda.idVenda, venda.data_venda, venda.total_venda, pagamento.idPagamento, cliente.nome AS nomeCliente
        FROM venda
        JOIN pagamento ON venda.idVenda = pagamento.idVenda
        JOIN cliente ON venda.idCliente = cliente.idCliente
        WHERE venda.idVenda = :idVenda AND pagamento.idPagamento = :idPagamento
    ");
    $stmt->bindParam(":idVenda", $idVenda);
    $stmt->bindParam(":idPagamento", $idPagamento);
    $stmt->execute();
    $notaFiscal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$notaFiscal) {
        echo "Erro: Venda ou Pagamento não encontrados.";
        exit;
    }

    // Obter os itens do pedido
    $stmt = $conn->prepare("
        SELECT produto.nome, itempedido.quantidade_vendida, produto.preco, (itempedido.quantidade_vendida * produto.preco) AS total
        FROM itempedido
        JOIN produto ON itempedido.idProduto = produto.idProduto
        WHERE itempedido.idVenda = :idVenda
    ");
    $stmt->bindParam(":idVenda", $idVenda);
    $stmt->execute();
    $itensPedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Erro: IDs de Venda e Pagamento não fornecidos.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Fiscal</title>
    <link rel="stylesheet" href="../css/style_nt.css">
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1>Nota Fiscal</h1>
    <p><strong>ID da Venda:</strong> <?php echo htmlspecialchars($notaFiscal['idVenda']); ?></p>
    <p><strong>Data da Venda:</strong> <?php echo htmlspecialchars($notaFiscal['data_venda']); ?></p>
    <p><strong>Valor Total da Venda:</strong> R$ <?php echo htmlspecialchars(number_format($notaFiscal['total_venda'], 2, ',', '.')); ?></p>
    <p><strong>ID do Pagamento:</strong> <?php echo htmlspecialchars($notaFiscal['idPagamento']); ?></p>
    <p><strong>Nome do Cliente:</strong> <?php echo htmlspecialchars($notaFiscal['nomeCliente']); ?></p>

    <h2>Itens Comprados</h2>
    <table>
        <thead>
            <tr>
                <th>Nome do Produto</th>
                <th>Quantidade</th>
                <th>Preço Unitário</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itensPedido as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                    <td><?php echo htmlspecialchars($item['quantidade_vendida']); ?></td>
                    <td>R$ <?php echo htmlspecialchars(number_format($item['preco'], 2, ',', '.')); ?></td>
                    <td>R$ <?php echo htmlspecialchars(number_format($item['total'], 2, ',', '.')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="../pages/dashboard.php" class="no-print"><input type="button" name="voltar" value="Voltar"></a>
    <button onclick="window.print()" class="no-print">Imprimir</button>

</body>
</html>
