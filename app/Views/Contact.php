<?= $this->extend('templates/layout') ?>
<?= $this->section('title') ?> <?= $this->data['title'] ?> <?= $this->endSection() ?>
<?= $this->section('content') ?>

<section class="content mb-5">
    <div class="container">
        <div class="row mb-5">
            <h3 class="display-7 text-white">
                <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;<?= $this->data['title'] ?>
            </h3>
        </div>
        <div class="card">
            <div class="card-body content-card">
                <div class="card-text">
                    <div class="row offset-md-1 align-items-center justify-content-center">
                        <div class="col-md-2">
                            <img class="align-items-center" src="https://status.gadu-gadu.pl/users/status.asp?id=419077&styl=5" /> &nbsp;GG
                        </div>
                        <div class="col-md-4">
                            <strong>419077</strong>
                        </div>
                    </div>
                    <div class="row offset-md-1 align-items-center justify-content-center mt-3">
                        <div class="col-md-2">
                            <img class="align-items-center" src="https://static.wikia.nocookie.net/tf2freakshow/images/d/d8/Steam-logo.png/revision/latest?cb=20160704160029" width="24" /> &nbsp;STEAM
                        </div>
                        <div class="col-md-4">
                            <strong><a href="https://steamcommunity.com/id/dafficzek">KLIK</a></strong>
                        </div>
                    </div>
                    <div class="row offset-md-1 align-items-center justify-content-center mt-3">
                        <div class="col-md-2">
                            <img class="align-items-center" src="https://files.softicons.com/download/social-media-icons/flat-gradient-social-icons-by-guilherme-lima/png/512x512/Facebook.png" width="24" /> &nbsp;FACEBOOK
                        </div>
                        <div class="col-md-4">
                            <strong><a href="https://www.facebook.com/Banikpl-Lista-banów-dla-twojego-serwera-107620181281895">KLIK</a></strong>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<?= $this->endSection() ?>