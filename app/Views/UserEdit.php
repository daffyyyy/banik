<?= $this->extend('templates/layout') ?>
<?= $this->section('title') ?> <?= $this->data['title'] ?> <?= $this->endSection() ?>
<?= $this->section('content') ?>

<section class="content mb-5">
    <div class="container">
        <div class="row mb-5">
            <h3 class="display-7 text-white">
                <i class="fa fa-user" aria-hidden="true"></i> <?= $this->data['title'] ?>
            </h3>
        </div>
        <div class="card">
            <div class="card-body content-card">
                <div class="card-text">
                    <div class="row align-items-center justify-content-center">
                        <div class="alert alert-secondary mt-2" role="alert">
                        <i class="fas fa-info"></i>  <strong>Pamiętaj!</strong> Zmiana hasła działa na konto <strong>banik.pl</strong> / <strong>AMXBansa</strong> i <strong>SourceBansa</strong>
                        </div>
                        <div class="col-md-6">
                            <form action="<?= base_url() . '/user/save'; ?>" method="post">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
                                <span class="display-6"><i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;Twoje dane</span>
                                <div class="col-md-8 mb-1 mt-2">
                                    <label>Login</label>
                                    <input type="text" class="form-control" value="<?= session()->get('user_name'); ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>E-mail</label>
                                    <input type="text" class="form-control" value="<?= session()->get('user_email'); ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Hasło</label>
                                    <input type="password" name="new_password" class="form-control" />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Powtórz hasło</label>
                                    <input type="password" name="new_password_confirm" class="form-control" />
                                </div>
                                <button type="submit" class="btn btn-success">Zapisz</button>
                        </div>
                        </form>
                        <?php if (isset($validation)) : ?>
                            <div class="col-12 mt-3">
                                <div class="alert alert-danger" role="alert">
                                    <?= $validation->listErrors() ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>