
<?php
// Incluir o arquivo DBConnection.php
require_once('DBConnection.php');

// Função para adicionar um novo funcionário
function addFuncionario($nome, $username, $cargo, $senha) {
    try {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $stmt = $conn->prepare("INSERT INTO funcionario (nome, cargo, username, senha) VALUES (:nome, :cargo, :username, :senha)");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":cargo", $cargo);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();

        return true;
    } catch(PDOException $e) {
        echo "Erro ao adicionar funcionário: " . $e->getMessage();
        return false;
    }
}

// Função para editar os dados de um funcionário
function editFuncionario($idFuncionario, $nome, $username, $cargo, $senha) {
    try {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $stmt = $conn->prepare("UPDATE funcionario SET nome = :nome, cargo = :cargo, username = :username, senha = :senha WHERE idFuncionario = :id");
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":cargo", $cargo);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":id", $idFuncionario);
        $stmt->execute();

        return true;
    } catch(PDOException $e) {
        echo "Erro ao editar funcionário: " . $e->getMessage();
        return false;
    }
}

// Função para deletar um funcionário
function deleteFuncionario($idFuncionario) {
    try {
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $stmt = $conn->prepare("DELETE FROM funcionario WHERE idFuncionario = :id");
        $stmt->bindParam(":id", $idFuncionario);
        $stmt->execute();

        return true;
    } catch(PDOException $e) {
        echo "Erro ao deletar funcionário: " . $e->getMessage();
        return false;
    }
}

// Verificar se o formulário de adição de funcionário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitFuncionario'])) {
    // Extrair os dados do formulário
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $cargo = $_POST['cargo'];
    $senha = $_POST['senha'];

    // Chamar a função para adicionar o funcionário
    addFuncionario($nome, $username, $cargo, $senha);
}

// Verificar se o formulário de edição de funcionário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitEditFuncionario'])) {
    // Extrair os dados do formulário
    $idFuncionario = $_POST['idFuncionario'];
    $nome = $_POST['nome'];
    $username = $_POST['username'];
    $cargo = $_POST['cargo'];
    $senha = $_POST['senha'];

    // Chamar a função para editar o funcionário
    editFuncionario($idFuncionario, $nome, $username, $cargo, $senha);
}

// Verificar se o parâmetro de delete foi passado
if(isset($_GET['delete'])) {
    $idFuncionarioToDelete = $_GET['delete'];
    deleteFuncionario($idFuncionarioToDelete);
    // Redirecionar de volta para o dashboard após a exclusão
    header("Location:../pages/funcionarios.php ");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script>
        function confirmDelete() {
            return confirm("Tem certeza de que deseja excluir este funcionário?");
        }
    </script>
    <link rel="stylesheet" href="../css/styles_funcionarios.css">
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


    

    <h1>Gerenciamento de Funcionarios</h1>
    <br> <br>

    <!-- Formulário para adicionar funcionário -->
    <h2>Lista de Funcionários</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Username</th>
            <th>Cargo</th>
            <th>Ações</th>
        </tr>
        <?php
        // Consulta para obter a lista de funcionários
        $dbConnection = new DBConnection();
        $conn = $dbConnection->getConnection();

        $stmt = $conn->query("SELECT * FROM funcionario");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".$row['idFuncionario']."</td>";
            echo "<td>".$row['nome']."</td>";
            echo "<td>".$row['username']."</td>";
            echo "<td>".$row['cargo']."</td>";
            echo "<td>
                    <a href='editFuncionario.php?id=".$row['idFuncionario']."'>Editar</a> 
                    <a href='funcionarios.php?delete=".$row['idFuncionario']."' onclick='return confirmDelete()'>Deletar</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <br> <br>

    <!-- Lista de Funcionários -->
    <h2>Adicionar Funcionário</h2>
    <form method="post" class="form">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>
        <br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <br>
        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" required><br>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br>
        <br>
        <input type="submit" name="submitFuncionario" value="Adicionar Funcionário">
    </form>


</body>
</html>