<aside class="mt-10">
    
    <a href="#" class="user-area">
        <div class="user-area-icon">
            <img src="<?= $base; ?>/media/avatars/<?= $userInfo->avatar; ?>" />
        </div>
        <div class="profile-info-name" style="text-decoration: none; color: #999; font-size: 14px;"><?= $firstName; ?></div>
    </a>
    <div class="menu-splitter"></div>
    
    
    <nav>
        <a href="<?= $base; ?>">
            <div class="menu-item <?= $activeMenu == 'home' ? 'active' : ''; ?>">
                <div class="menu-item-icon">
                    <img src="<?= $base; ?>/assets/images/home-run.png" width="16" height="16" />
                </div>
                <div class="menu-item-text">
                    Home
                </div>
            </div>
        </a>
        <a href="<?= $base; ?>/perfil.php">
            <div class="menu-item <?= $activeMenu == 'profile' ? 'active' : ''; ?>">
                <div class="menu-item-icon">
                    <img src="<?= $base; ?>/assets/images/user.png" width="16" height="16" />
                </div>
                <div class="menu-item-text">
                    Meu Perfil
                </div>
            </div>
        </a>
        <a href="<?= $base; ?>/amigos.php">
            <div class="menu-item <?= $activeMenu == 'friends' ? 'active' : ''; ?>">
                <div class="menu-item-icon">
                    <img src="<?= $base; ?>/assets/images/friends.png" width="16" height="16" />
                </div>
                <div class="menu-item-text">
                    Amigos
                </div>
                <div class="menu-item-badge">
                    33
                </div>
            </div>
        </a>
        <a href="<?= $base; ?>/fotos.php">
            <div class="menu-item <?= $activeMenu == 'photos' ? 'active' : ''; ?>">
                <div class="menu-item-icon">
                    <img src="<?= $base; ?>/assets/images/photo.png" width="16" height="16" />
                </div>
                <div class="menu-item-text">
                    Fotos
                </div>
            </div>
        </a>
        <div class="menu-splitter"></div>
        <a href="<?= $base; ?>/configuracoes.php">
            <div class="menu-item <?= $activeMenu == 'config' ? 'active' : ''; ?>">
                <div class="menu-item-icon">
                    <img src="<?= $base; ?>/assets/images/settings.png" width="16" height="16" />
                </div>
                <div class="menu-item-text">
                    Configurações
                </div>
            </div>
        </a>
        <a href="<?= $base; ?>/login.php" title="Sair">
            <div class="menu-item">
                <div class="menu-item-icon">
                    <img src="<?= $base; ?>/assets/images/power.png" width="16" height="16" />
                </div>
                <div class="menu-item-text">
                    Sair
                </div>
            </div>
        </a>
    </nav>
</aside>