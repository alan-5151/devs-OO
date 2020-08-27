<?php
require 'config.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
        <link rel="stylesheet" href="<?= $base; ?>/assets/css/login.css" />
            </head>
    <body>
        <header>
            <div class="container">
                <a href="<?= $base; ?>"><img src="<?= $base; ?>/assets/images/devsbook_logo.png" /></a>
            </div>
        </header>
        <section class="container main">
            <form method="POST" action="<?= $base; ?>/signup_action.php">
               
                <?php if (!empty($_SESSION['flash'])): ?>
                    <div class="flash">    <?= $_SESSION['flash']; ?> </div>
                    <?php endif; ?>
               
                    <input placeholder="Digite seu nome completo" class="input" type="text" name="name" required minlength="3"  />
                    
                <input placeholder="Digite seu e-mail" class="input" type="email" name="email" required />
                
                <input id="birthdate" placeholder="Digite sua data de nascimento" class="input" type="text" name="birthdate" required minlength="10" />

                <input placeholder="Digite sua senha" class="input" type="password" name="password" required minlength="4" />

                <input class="button" type="submit" value="Cadastrar-se" />

                <a href="<?= $base; ?>/login.php">Já tem conta? Faça o login.</a>
            </form>
        </section>
        
         <script src="https://unpkg.com/imask"></script>
        <script>
            IMask(
                    document.getElementById('birthdate'),
                    {
                        mask: '00/00/0000'
                    }
            );
        </script>
        
         <?= $_SESSION['flash'] = ''; ?>
    </body>
</html>
