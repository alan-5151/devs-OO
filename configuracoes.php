<?php
require_once 'config.php';
require_once 'models/Auth.php';
require_once 'dao/UserDaoMysql.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();
$firstName = current(explode(' ', $userInfo->name));
$activeMenu = 'config';

$usertDao = new UserDaoMysql($pdo);

require 'partials/header.php';
require 'partials/menu.php';
?>
<section class="feed mt-10">

    <h1>Configurações</h1>

    <form method="POST" class="config-form" enctype="multipart/form-data" action="configuracoes_action.php">
        <?php if (!empty($_SESSION['flash'])): ?>
            <div class="flash">    <?= $_SESSION['flash']; ?> </div>
        <?php endif; ?>
            <?= $_SESSION['flash']=''; ?>

        <label>
            Novo avatar:<br />
            <input type="file" name="avatar" />
        </label>

        <label>
            Nova capa:<br />
            <input type="file" name="cover" />
        </label>

        <hr />

        <label>
            Nome:<br />
            <input type="text" name="name" value="<?= $userInfo->name ?>" />
        </label>

        <label>
            E-mail:<br />
            <input type="email" name="email" value="<?= $userInfo->email ?>" />
        </label>

        <label>
            Data de nascimento:<br />
            <input id="birthdate" type="text" name="birthdate" value="<?= date('d/m/Y', strtotime($userInfo->birthdate)); ?>" />
        </label>

        <label>
            Cidade:<br />
            <input type="text" name="city" value="<?= $userInfo->city ?>" />
        </label>

        <label>
            Trabalho:<br />
            <input type="text" name="work" value="<?= $userInfo->work ?>" />
        </label>

        <hr />

        <label>
            Nova senha:<br />
            <input type="password" name="password" />
        </label>

        <label>
            Confirmar nova senha:<br />
            <input type="password" name="password_confirmation" />
        </label>

        <button class=".button">Salvar</button>



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
<?php
require 'partials/footer.php';
?>
