<?php
// authenticate.php

session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM funcionario WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && $password == $user['senha']) { // Comparação simples, use hashing em produção
        $_SESSION['user_id'] = $user['idFuncionario'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../pages/dashboard.php');
        exit();
    } else {
        echo 'Credenciais inválidas.';
    }
}
?>