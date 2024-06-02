<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Adicionar funcionário
    if (isset($_POST['addEmployee'])) {
        $employeesFile = fopen("employees.txt", "a") or die("Não foi possível abrir o arquivo!");
        $employee = json_encode([
            'name' => $_POST['employeeName'],
            'role' => $_POST['employeeRole'],
            'salary' => $_POST['employeeSalary']
        ]);
        fwrite($employeesFile, $employee . "\n");
        fclose($employeesFile);
    }

    // Excluir funcionário
    if (isset($_POST['deleteEmployee'])) {
        // Confirmar a exclusão
        if (isset($_POST['confirmDelete'])) {
            $index = $_POST['employeeIndex'];
            $employees = file("employees.txt");
            unset($employees[$index]);
            file_put_contents("employees.txt", implode("", $employees));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>


<h4>Funcionários Cadastrados</h4>
<table id="employeesTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cargo</th>
            <th>username</th>
            <th><a href="#">reset de senha</a></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (file_exists("employees.txt")) {
            $employees = file("employees.txt");
            $id = 1;
            foreach ($employees as $index => $employee) {
                $employeeData = json_decode($employee, true);
                echo "<tr>
                        <td><input type='checkbox' value='$index'></td>
                        <td>$id</td>
                        <td>{$employeeData['name']}</td>
                        <td>{$employeeData['role']}</td>
                        <td>{$employeeData['salary']}</td>
                        <td class='actions'>
                            <form method='post' style='display:inline;' onsubmit='return confirm(\"Tem certeza que deseja excluir este funcionário?\");'>
                                <input type='hidden' name='employeeIndex' value='$index'>
                                <button type='submit' name='deleteEmployee'>Excluir</button>
                                <input type='hidden' name='confirmDelete' value='true'>
                            </form>
                        </td>
                    </tr>";
                $id++;
            }
        }
        ?>
    </tbody>
</table>

<!-- Formulário para adicionar funcionários -->
<br>
<h4>Cadastro de Funcionários</h4>
<form id="employeeForm" method="post">
    <label for="employeeName">Nome do Funcionário:</label>
    <input type="text" id="employeeName" name="employeeName" required>

    <label for="employeeRole">Cargo:</label>
    <select id="employeeRole" name="employeeRole" required>
        <option value="">Selecione o cargo</option>
        <option value="Atendente">Atendente</option>
        <option value="Caixa">Caixa</option>
        <option value="Repositor">Repositor</option>
    </select>

    <br>
    <label for="employeeName">Username:</label>
    <input type="text" id="employeeName" name="employeeName" required>

    <br>

    <label for="employeeName">Senha:</label>
    <input type="text" id="employeeName" name="employeeName" required>

    <button type="submit" name="addEmployee">Cadastrar</button>
</form>

</body>
</html>
