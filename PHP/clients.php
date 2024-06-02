<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Adicionar cliente e pet
    if (isset($_POST['addClient'])) {
        $clientsFile = fopen("clients.txt", "a") or die("Não foi possível abrir o arquivo!");
        $client = json_encode([
            'clientName' => $_POST['clientName'],
            'cpf' => $_POST['clientCPF'],
            'petName' => $_POST['petName'],
            'breed' => $_POST['petBreed'],
            'appointmentTime' => $_POST['appointmentTime'],
            'paymentStatus' => $_POST['paymentStatus']
        ]);
        fwrite($clientsFile, $client . "\n");
        fclose($clientsFile);
    }

}
?>

<form id="clientForm" method="post">
    <label for="clientName">Nome do Cliente:</label>
    <input type="text" id="clientName" name="clientName" required>

    <label for="clientCPF">CPF:</label>
    <input type="text" id="clientCPF" name="clientCPF" required>

    <label for="petName">Nome do Pet:</label>
    <input type="text" id="petName" name="petName" required>

    <label for="petBreed">Raça do Pet:</label>
    <input type="text" id="petBreed" name="petBreed" required>

    <label for="appointmentTime">Horário Agendado:</label>
    <input type="datetime-local" id="appointmentTime" name="appointmentTime" required>


    <label for="paymentStatus">Tipo de Serviço</label>
    <select id="paymentStatus" name="paymentStatus" required>
        <option value="Banho">Banho</option>
        <option value="Banho e tosa higienica">Banho e tosa higienica</option>
        <option value="Banho e tosa bebê">Banho e tosa bebê</option>
        <option value="Banho e tosa de raça">Banho e tosa de raça</option>
        <option value="Banho e tosa geral com máquina">Banho e tosa geral (com máquina)</option>
    </select>

    <br>   <br>

    <button type="submit" name="addClient">Cadastrar Agendamento</button>
</form>

