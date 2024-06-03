<!DOCTYPE html>
<html lang="pt=br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendas</title>


  <link rel="stylesheet" href="../CSS/style_vendas.CSS">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">



</head>

<body>

  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="../pages/dashboard.php"><img src="../img/login.png" width="50px"></a>
  </nav>
 

    <!-- Main Content -->
    <div class="container mt-4">
      <div class="row">
        
        <!-- Área de Vendas -->
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              <h5>Adicionar Produtos</h5>
            </div>
            <div class="card-body">
              <form id="product-form">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="search">Buscar Codigo do Produto</label>
                    <input type="text" class="form-control" id="search" >
                  </div>
                  <div class="form-group col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                  </div>
                </div>
              </form>
              <ul class="list-group mt-3" id="product-list">
              </ul>
            </div>
          </div>
        </div>

        <!-- Resumo do Carrinho -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h5>Carrinho de Compras</h5>
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: auto;">
              <ul class="list-group" id="cart">
                <!-- Lista de produtos adicionados -->
              </ul>
            </div>
            <div class="card-footer">
              <div class="d-flex justify-content-between">
                <strong>Total:</strong>
                <span id="total-price">$0.00</span>
              </div>
              <button class="btn btn-danger btn-block mt-2" onclick="clearCart()">Limpar Carrinho</button>
              <button class="btn btn-success btn-block mt-2">Finalizar Venda</button>
            </div>
          </div>
        </div>

      </div>
    </div>


</body>

</html>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  document.getElementById('product-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const product = document.getElementById('search').value;
    if (product) {
      addProductToCart(product, 1);
      document.getElementById('product-form').reset();
    }
  });

  function addProductToCart(product, quantity) {
    const cart = document.getElementById('cart');
    const li = document.createElement('li');
    li.className = 'list-group-item d-flex justify-content-between align-items-center';
    li.innerHTML = `
            ${product} - 
            <span class="quantity">${quantity}</span> unidade(s)
            <div>
                <button class="btn btn-sm btn-secondary mr-2" onclick="changeQuantity(this, -1)">-</button>
                <button class="btn btn-sm btn-secondary mr-2" onclick="changeQuantity(this, 1)">+</button>
                <button class="btn btn-sm btn-danger" onclick="removeProduct(this)">Excluir</button>
            </div>
        `;
    cart.appendChild(li);
    updateTotal();
  }

  function changeQuantity(button, change) {
    const li = button.closest('li');
    const quantityElem = li.querySelector('.quantity');
    let quantity = parseInt(quantityElem.textContent);
    quantity += change;
    if (quantity > 0) {
      quantityElem.textContent = quantity;
    } else {
      removeProduct(button);
    }
    updateTotal();
  }

  function changeProductQuantity(button, change) {
    const li = button.closest('li');
    const quantityElem = li.querySelector('.quantity');
    let quantity = parseInt(quantityElem.textContent);
    quantity += change;
    if (quantity > 0) {
      quantityElem.textContent = quantity;
    } else {
      removeProductFromList(button);
    }
  }

  function removeProduct(button) {
    const li = button.closest('li');
    li.remove();
    updateTotal();
  }

  function removeProductFromList(button) {
    const li = button.closest('li');
    li.remove();
  }

  function clearCart() {
    document.getElementById('cart').innerHTML = '';
    updateTotal();
  }

  function updateTotal() {
    let total = 0;
    document.querySelectorAll('#cart .list-group-item').forEach(item => {
      const quantity = parseInt(item.querySelector('.quantity').textContent);
      total += 10 * quantity;
    });
    document.getElementById('total-price').textContent = `$${total.toFixed(2)}`;
  }
</script>