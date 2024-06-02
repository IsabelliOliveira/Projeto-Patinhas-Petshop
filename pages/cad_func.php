<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_cad.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css"
    integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="../pages/dashboard.html"><img src="../img/login.png" width="50px"></a>
    </nav>

    <div class="container">

        <h2>Controle de usuarios</h2>
        <?php include '../PHP/employees.php'; ?>
        
    </div>


    
</body>
    <footer class="d-flex justify-content-between align-items-center py-2 border-top ">
        <p class="col-md-4 mb-0 text-body-secondary ">&copy; Todos os direitos reservados a</p>
        
        <ul class="nav col-md-4 justify-content-end">
          <a href="../pages/dashboard.html" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <img src="../img/login.png" width="50px">
          </a>
        </ul>
    </footer>

</html>
