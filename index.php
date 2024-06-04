<!DOCTYPE html>
<html lang="pt=br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Patinhas </title>

    <!--CSS-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">

</head>

<body>
    <div id="container">
        <div class="banner">
            <img src="img/login.png" alt="imagem-login">
        </div>

        <div class="box-login">
            <h1>
                Olá!<br>
                Seja bem vindo de volta.
            </h1>

            <form action="PHP/authenticate.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br><br>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>

</html>