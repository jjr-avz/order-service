<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordens de Serviço - LOGIN</title>

    <link rel="shortcut icon" type="imagex/png" href="./src/imgs/icon_barra.ico">

    <!-- LINKs CSS -->
     <link rel="stylesheet" href="./src/styles/login.css">
</head>
<body>
    <div class="area-login">
        <div class="head-login">
            <span>
                Area Restrita - Login
            </span>
        </div>
        <form action="./src/methods/signIn.php" method="POST" id="login-form">
            <div class="body-login">
                <div class="div-input">
                    <span>E-mail</span>
                    <input type="text" name="email" class="input-text" placeholder="Insira seu e-mail de login">
                </div>
                <div class="div-input">
                    <span>Senha</span>
                    <input type="password" name="password" class="input-text" placeholder="Insira sua senha...">
                </div>

                <input type="submit" value="Entrar" class="button-entry" id="handleSignIn">
            </div>
        </form>
    </div>
</body>
</html>
