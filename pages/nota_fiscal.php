<?php
require_once('DBConnection.php');
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
</head>
<body>
    <h1>Nota Fiscal</h1>
    <p><strong>ID da Venda:</strong> <?php echo $notaFiscal['idVenda']; ?></p>
    <p><strong>Data da Venda:</strong> <?php echo $notaFiscal['data_venda']; ?></p>
    <p><strong>Valor Total da Venda:</strong> R$ <?php echo number_format($notaFiscal['total_venda'], 2, ',', '.'); ?></p>
    <p><strong>ID do Pagamento:</strong> <?php echo $notaFiscal['idPagamento']; ?></p>
    <p><strong>Nome do Cliente:</strong> <?php echo $notaFiscal['nomeCliente']; ?></p>

    <a href="../pages/dashboard.php"><input type="button" name="voltar" value="Voltar"></a>

</body>
</html>
