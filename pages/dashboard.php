<?php
// dashboard.php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso ADM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    
    <link rel="stylesheet" href="../css/stylesDash.css">

</head>

<body>
    <nav class="navbar navbar-light bg-light p-3">
        <div class="d-flex col-12 col-md-3 col-lg-2 mb-2 mb-lg-0 flex-wrap flex-md-nowrap justify-content-between">
            <a class="navbar-brand" href="../pages/dashboard.html">
                <img src="../img/login.png" width="40px">
            </a>
            <button class="navbar-toggler d-md-none collapsed mb-3" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="dropdown">
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <li><a class="dropdown-item" href="index.php">Sair</a></li>
                </ul>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                <?php echo 'Bem-vindo, ' . htmlspecialchars($_SESSION['username']) . '!';
?>
                </button>
                
        </div>

    </nav>



    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="../pages/dashboard.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <span class="ml-2">Dashboard</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="../pages/agendar_servico.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg>
                            <span class="ml-2">Agendamentos</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="../pages/adicionar_item_pedido.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            <span class="ml-2">Realizar Venda</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="../pages/Clientes.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            <span class="ml-2">Gerenciar Clientes</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="../pages/relatorio.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            <span class="ml-2">Relatorios</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="../pages/produto_estoque.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            <span class="ml-2">Estoque</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="../pages/funcionarios.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            <span class="ml-2">Funcionarios</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="../pages/Pets.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dog">
                              <path d="M12 2C13.1 2 14 2.9 14 4H10C10 2.9 10.9 2 12 2ZM15.5 4C15.78 4 16 4.22 16 4.5V6H17.5C18.33 6 19 6.67 19 7.5V9.2L18.4 13H20.5C21.33 13 22 13.67 22 14.5V16.5C22 17.33 21.33 18 20.5 18H19V19.5C19 20.33 18.33 21 17.5 21H15.5C15.22 21 15 21.22 15 21.5V22C15 22.28 14.78 22.5 14.5 22.5H9.5C9.22 22.5 9 22.28 9 22V21.5C9 21.22 8.78 21 8.5 21H6.5C5.67 21 5 20.33 5 19.5V18H3.5C2.67 18 2 17.33 2 16.5V14.5C2 13.67 2.67 13 3.5 13H5.6L5 9.2V7.5C5 6.67 5.67 6 6.5 6H8V4.5C8 4.22 8.22 4 8.5 4H10V3H14V4H15.5Z"></path>
                            </svg>
                            <span class="ml-2">Pets</span>
                          </a>
                        </li>
                      </ul>
                </div>
            </nav>

 
<!--INICIO de painél geral-->            
            <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4 py-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </nav>
                <h1 class="h2">Funcionario do mês </h1>
                <p>Esta é a página inicial de uma interface administrativa </p>

                <div class="row my-4">
                    <div class="col-12 col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">Abril</h5>
                            <div class="card-body">
                              <img src="../img/vitor.jpeg" width="100%">
                            </div>
                          </div>
                    </div>
                    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
                        <div class="card">
                            <h5 class="card-header">Maio</h5>
                            <div class="card-body">
                            <img src="../img/lucas.jpeg" width="100%">
                            </div>
                          </div>
                    </div>
                    <div class="col-12 col-md-6 mb-4 mb-lg-0 col-lg-3">
                        <div class="card">
                            <h5 class="card-header">Junho?</h5>
                            <div class="card-body">
                            <img src="../img/login.png" width="100%">
                            </div>
                          </div>
                    </div>
                </div>
                <div class="row my-4"></div>
                    <div class="row my-4">
                      <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">Clientes do Mês</h5>
                            <div class="card-body" id="card-body-pet">
                            <img src="../img/pet.jpeg" width="45%">
                            <img src="../img/pet1.jpeg" width="45%">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="row my-4"></div>
                    <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                        <div class="card">
                            <h5 class="card-header">Comunicado</h5><br>
                            <h6>Lembrete para a Equipe Petshop Patinhas</h6><br>
                            <p>Este é um lembrete do nosso compromisso e amizade no Petshop Patinhas. Juntos, dedicamos nosso tempo e esforço para garantir que cada pet que entra por nossas portas receba o melhor cuidado possível. Nossa paixão por esses animais nos une e nos motiva a oferecer serviços de qualidade com amor e carinho. Lembrem-se de que nosso trabalho não é apenas um serviço, mas uma extensão do nosso compromisso com o bem-estar e a felicidade dos nossos amigos de quatro patas. Continuemos a cultivar essa amizade entre nós e com os pets, mantendo sempre nosso compromisso com a excelência.</p>
                            <div class="card-body" id="card-body-pet">
                            <img src="../img/equipe.jpeg" width="45%">
                            </div>
                        </div>
                        
                    </div>
                </div>
                </div>
<!--fim de painél geral-->                




                <footer class="pt-5 d-flex justify-content-between">
                    <span>Todos os direitos reservados a Patinhas Pet shop © 2024 </span>
                </footer>
            </main>
        
    </div>


</body>
</html>
