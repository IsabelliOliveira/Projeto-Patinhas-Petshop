<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Adicionar produto
    if (isset($_POST['addProduct'])) {
        $productsFile = fopen("products.txt", "a") or die("Não foi possível abrir o arquivo!");
        $product = json_encode([
            'name' => $_POST['productName'],
            'stock' => $_POST['productStock'],
            'weight' => $_POST['productWeight'],
            'brand' => $_POST['productBrand']
        ]);
        fwrite($productsFile, $product . "\n");
        fclose($productsFile);
    }

    // Excluir produtos selecionados
    if (isset($_POST['deleteSelectedProducts'])) {
        // Confirmar a exclusão
        if (isset($_POST['confirmDelete'])) {
            // Verifica se há produtos selecionados para exclusão
            if (isset($_POST['selectedProducts'])) {
                $selectedProducts = $_POST['selectedProducts'];
                $products = file("products.txt");

                // Remove os produtos selecionados do array de produtos
                foreach ($selectedProducts as $index) {
                    unset($products[$index]);
                }

                // Reescreve o arquivo de produtos
                file_put_contents("products.txt", implode("", $products));
            }
        }
    }

    // Atualizar quantidade de produtos
    if (isset($_POST['updateStock'])) {
        $products = file("products.txt");
        $productId = $_POST['productId'];
        $newStock = $_POST['newStock'];

        if (isset($products[$productId])) {
            $productData = json_decode($products[$productId], true);
            $productData['stock'] = $newStock;
            $products[$productId] = json_encode($productData) . "\n";
            file_put_contents("products.txt", implode("", $products));
        }
    }
}
?>

<form id="productForm" method="post">
    <label for="productName">Nome do Produto:</label>
    <input type="text" id="productName" name="productName" required>

    <label for="productStock">Quantidade em Estoque:</label>
    <input type="number" id="productStock" name="productStock" required>

    <label for="productWeight">Peso:</label>
    <input type="text" id="productWeight" name="productWeight" required>

    <label for="productBrand">Marca:</label>
    <input type="text" id="productBrand" name="productBrand" required>

    <button type="submit" name="addProduct">Cadastrar Produto</button>
</form>

<h2>Produtos Cadastrados</h2>
<form id="deleteProductsForm" method="post" onsubmit="return confirm('Tem certeza que deseja excluir os produtos selecionados?');">
    <!-- Adicione um botão para excluir produtos selecionados -->
    <button type="submit" name="deleteSelectedProducts">Excluir Produtos Selecionados</button>
    <input type="hidden" name="confirmDelete" value="true">
    <table id="productsTable">
        <thead>
            <tr>
                <th>Selecione</th>
                <th>ID</th>
                <th>Nome</th>
                <th>Estoque</th>
                <th>Peso</th>
                <th>Marca</th>
                <th>Editar Estoque</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (file_exists("products.txt")) {
                $products = file("products.txt");
                $id = 1;
                foreach ($products as $index => $product) {
                    $productData = json_decode($product, true);
                    echo "<tr>
                            <td><input type='checkbox' name='selectedProducts[]' value='$index'></td>
                            <td>$id</td>
                            <td>{$productData['name']}</td>
                            <td>{$productData['stock']}</td>
                            <td>{$productData['weight']}</td>
                            <td>{$productData['brand']}</td>
                            <td>
                                <form method='post' style='display:inline;'>
                                    <input type='hidden' name='productId' value='$index'>
                                    <input type='number' name='newStock' value='{$productData['stock']}' required>
                                    <button type='submit' name='updateStock'>Atualizar</button>
                                </form>
                            </td>
                        </tr>";
                    $id++;
                }
            }
            ?>
        </tbody>
    </table>
</form>

