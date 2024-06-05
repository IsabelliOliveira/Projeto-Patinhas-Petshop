<?php
session_start(); // Inicia a sessão
include 'DBConnection.php';
$dbConnection = new DBConnection();
$conn = $dbConnection->getConnection();

$startDate = '2024-01-01';
$endDate = '2024-06-01';

$sqlSales = "
SELECT 
    p.idProduto,
    p.Nome,
    SUM(ip.Quantidade_Vendida) AS Total_Vendido,
    p.Quantidade_Estoque
FROM 
    itempedido ip
    JOIN produto p ON ip.idProduto = p.idProduto
    JOIN venda v ON ip.idVenda = v.idVenda
WHERE 
    v.Data_Venda BETWEEN :startDate AND :endDate
GROUP BY 
    p.idProduto, p.Nome, p.Quantidade_Estoque
";

$stmt = $conn->prepare($sqlSales);
$stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
$resultSales = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Vendas e Estoque</title>
    <link rel="stylesheet" href="../css/styles_relatorio.css">
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

    <h1>Relatório de Vendas e Estoque</h1>
    <p>Período: <?php echo htmlspecialchars($startDate); ?> a <?php echo htmlspecialchars($endDate); ?></p>
    <table>
        <thead>
            <tr>
                <th>ID do Produto</th>
                <th>Nome do Produto</th>
                <th>Total Vendido</th>
                <th>Quantidade em Estoque</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($resultSales) > 0) {
                foreach ($resultSales as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["idProduto"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Nome"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Total_Vendido"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["Quantidade_Estoque"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum dado encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn = null;
?>
