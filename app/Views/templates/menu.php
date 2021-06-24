<nav class="navbar navbar-expand-lg navbar-dark bg-darken">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img class="img-fluid icon-header" src="<?= base_url('assets/img/icon.svg'); ?>" />
            banik.pl</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/"><i class="fa fa-home" aria-hidden="true"></i> Strona główna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact"><i class="fa fa-envelope" aria-hidden="true"></i>
                        Kontakt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://uptime.banik.pl"><i class="fa fa-info-circle" aria-hidden="true"></i>
                        Status</a>
                </li>
            </ul>
            <?php if (session()->get('isLoggedIn')) { ?>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user-circle" aria-hidden="true"></i> Witaj <strong><?= session()->get('user_name'); ?></strong>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?= base_url() . '/user/info'; ?>"><i class="fa fa-info-circle" aria-hidden="true"></i> Informacje</a></li>
                            <li><a class="dropdown-item" href="https://<?= strtolower(session()->get('user_name')); ?>.banik.pl"><i class="fa fa-bomb" aria-hidden="true"></i> Twój amxbans</a></li>
                            <li><a class="dropdown-item" href="https://sb<?= strtolower(session()->get('user_name')); ?>.banik.pl"><i class="fa fa-bomb" aria-hidden="true"></i> Twój sourcebans</a></li>

                            <li><a class="dropdown-item" href="<?= base_url() . '/user/edit'; ?>"><i class="fa fa-user" aria-hidden="true"></i> Twoje dane</a></li>
                            <li><a class="dropdown-item" href="<?= base_url() . '/user/logs'; ?>"><i class="fas fa-eye"></i> Logi konta</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= base_url() . '/logout'; ?>"><i class="fa fa-sign-out-alt" aria-hidden="true"></i> Wyloguj się</a></li>
                        </ul>
                    </li>
                <?php } ?>
                <?php if (!session()->get('isLoggedIn')) { ?>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#login">Zaloguj się</button>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#register">
                        Zarejestruj się
                    </button>
                <?php } ?>
        </div>
    </div>
</nav>