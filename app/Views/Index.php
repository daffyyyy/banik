<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Banik.pl :: Strona Główna</title>
  <base href="<?php echo base_url(); ?>" />
  <link rel="icon" type="image/svg+xml" href="assets/img/icon.svg">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-GLHP5N5P8X"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-GLHP5N5P8X');
  </script>

  <script src="https://www.google.com/recaptcha/api.js"></script>
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,700;0,800;1,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/style.min.css'); ?>" />
</head>

<body class="d-flex flex-column min-vh-100">

  <?= view('templates/menu'); ?>

  <header class="page-header gradient mt-5 mb-5">
    <div class="container pt-5">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-6">
          <h2 class="display-6">Lista banów dla twojego serwera!</h2>
          <p class="fw-light">
            <i>U nas stworzysz AMXbansa i SourceBansa!</i> <br />
            Nasz serwis umożliwia prowadzenie własnej listy banów bez własnego
            wkładu finansowego i czasowego. <br />
            Nie chcesz bawić się w instalowanie skryptów na włąsną rękę?
            Dobrze trafiłeś! Stwórz konto a my zajmiemy się resztą. <br /><br />

            Utworzonych amxbansów: <strong class="fw-bold"><?= $this->data['amxbans']; ?></strong> <br />
            Utworzonych sourcebansów: <strong class="fw-bold"><?= $this->data['sourcebans']; ?></strong><br />
          </p>
          <?php if (!session()->get('isLoggedIn')) { ?>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#register">
              Zarejestruj się
            </button>
          <?php } ?>
        </div>
        <div class="col-md-6 text-center">
          <img class="img-header img-fluid" src="assets/img/shield.svg" />
        </div>
      </div>
    </div>
  </header>

  <section class="partners">
    <div class="container pt-5 pb-5">
      <div class="row align-items-center justify-content-center">
        <h2 class="display-6 text-white">Nasi partnerzy</h2>
        <div class="col-md-2 text-center">
          <a href="https://utopiafps.pl"><img src="https://i.imgur.com/KRRYFUc.png" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-container="body" title="Sieć Counter-Strike" class="img-fluid" /></a>
        </div>
        <div class="col-md-2 text-center">
          <a href="https://ts3.style"><img src="https://ts3.style/img/icons/logo_ts3style.svg" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-container="body" title="Serwer TeamSpeak3" class="img-fluid" /></a>
        </div>
        <div class="col-md-2 text-center">
          <a href="https://nowa-gwardia.pl"><img src="https://i.imgur.com/Ax55eNA.png" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-container="body" title="Sieć Counter-Strike" class="img-fluid" /></a>
        </div>
        <div class="col-md-2 text-center">
          <a href="https://banik.pl"><img src="assets/img/partner.png" class="img-fluid" /></a>
        </div>
        <div class="col-md-2 text-center">
          <a href="https://banik.pl"><img src="assets/img/partner.png" class="img-fluid" /></a>
        </div>
        <div class="col-md-2 text-center">
          <a href="https://banik.pl"><img src="assets/img/partner.png" class="img-fluid" /></a>
        </div>
      </div>
    </div>
  </section>

  <section class="feature gradient mb-5">
    <div class="container pt-2">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-6 text-center">
          <img class="img-header img-fluid" src="assets/img/question.svg" />
        </div>
        <div class="col-md-6">
          <h2 class="display-6">Co możemy zaproponować?</h2>
          <ul class="fw-light">
            <li>Doświadczenie</li>
            <li>Szybka instalacja</li>
            <li>Bezpieczeństwo</li>
            <li>Pomoc</li>
            <li>Brak opłat</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <footer class="mt-5 mt-auto">
    <div class="container pt-5 pb-5">
      <div class="row align-items-center justify-content-center">
        <div class="text-center">
          Zakaz kopiowania elementów strony, wykonano z&nbsp;<i class="fa fa-heart heartbeat" aria-hidden="true"></i> dla
          <a href="https://banik.pl"><strong>banik.pl</strong></a>
        </div>
      </div>
    </div>
  </footer>

  <?php if (!session()->get('isLoggedIn')) : ?>
    <div class="modal fade" id="register" tabindex="-1" aria-labelledby="register" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="register">Rejestracja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
          </div>
          <div class="modal-body">
            <form action="<?= base_url() . '/register'; ?>" method="post">
              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="user_name">Login</label>
                    <input type="text" class="form-control" name="user_name" id="user_name">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="user_email">E-Mail</label>
                    <input type="text" class="form-control" name="user_email" id="user_email">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="user_password">Hasło</label>
                    <input type="password" class="form-control" name="user_password" id="user_password" value="">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="user_password_confirm">Powtórz hasło</label>
                    <input type="password" class="form-control" name="user_password_confirm" id="user_password_confirm" value="">
                  </div>
                </div>
                <div class="col-12 mt-4">
                  <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="6Lcp1jgaAAAAANbqzHa-YxZ8QhSwOHhLhqp4_k7t"></div>
                  </div>
                </div>
                <?php if (isset($validation)) : ?>
                  <div class="col-12 mt-3">
                    <div class="alert alert-danger" role="alert">
                      <?= $validation->listErrors() ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
            <button type="submit" class="btn btn-success">Zarejestruj</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="login" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="register">Logowanie</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
          </div>
          <div class="modal-body">
            <form action="<?= base_url() . '/login'; ?>" method="post">
              <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
              <div class="form-group">
                <label for="user_email">E-Mail</label>
                <input type="text" class="form-control" name="user_email" id="user_email">
              </div>
              <div class="form-group">
                <label for="user_password">Hasło</label>
                <input type="password" class="form-control" name="user_password" id="user_password">
              </div>
              <?php if (isset($validation)) : ?>
                <div class="col-12 mt-3">
                  <div class="alert alert-danger" role="alert">
                    <?= $validation->listErrors() ?>
                  </div>
                </div>
              <?php endif; ?>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
            <button type="submit" class="btn btn-success">Zaloguj</button>
          </div>
          </form>
        </div>
      </div>


    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/main.js'); ?>"></script>
    <script src="https://apps.elfsight.com/p/platform.js" defer></script>
    <div class="elfsight-app-40a249e3-7658-4259-beab-35d1808a84a2"></div>
</body>

</html>