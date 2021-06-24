<?= $this->extend('templates/layout') ?>
<?= $this->section('title') ?> <?= $this->data['title'] ?> <?= $this->endSection() ?>
<?= $this->section('content') ?>

<section class="content mb-5">
    <div class="container">
        <div class="row mb-5">
            <h3 class="display-7 text-white">
                <i class="fa fa-info-circle" aria-hidden="true"></i> <?= $this->data['title'] ?>
            </h3>
        </div>
        <div class="card">
            <div class="card-body content-card">
                <div class="card-text">
                    <div class="row align-items-center justify-content-center">
                        <p>Dane logowania do amxbansa sa takie same jak tutaj: Login (<i><?= session()->get('user_name'); ?></i>) + Hasło</p>
                        <div class="alert alert-secondary mt-2" role="alert">
                            Własna subdomena jako adres listy banów? Nic prostszego! Utwórz rekord <strong>A</strong> i skieruj go na IP <strong>51.38.129.105</strong> i daj znać na <a href="https://www.facebook.com/Banikpl-Lista-banów-dla-twojego-serwera-107620181281895">FACEBOOK</a> lub <a href="https://steamcommunity.com/id/dafficzek/">STEAM</a>
                        </div>
                        <div class="text-center mb-3">
                            <img class="img-content img-fluid" src="assets/img/database.svg" />
                        </div>
                        <?php if (!empty($this->data['bans'])) : ?>
                            <div class="col-md-5 offset-md-1">
                                <span class="display-6"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;Dane bazy danych AMXBANS</span>
                                <div class="col-md-8 mb-1 mt-2">
                                    <label>Host</label>
                                    <input type="text" class="form-control" value="<?= $this->data['bans']['bans_host']; ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Użytkownik</label>
                                    <input type="text" class="form-control" value="<?= $this->data['bans']['bans_user']; ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Hasło</label>
                                    <input type="text" class="form-control" value="<?= $this->data['bans']['bans_password']; ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Baza danych</label>
                                    <input type="text" class="form-control" value="<?= $this->data['bans']['bans_database']; ?>" readonly />
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="col">
                                <a href="<?= base_url() . '/user/createAMXB'; ?>" class="btn btn-secondary mb-1 mt-2"><i class="fa fa-plus" aria-hidden="true"></i> Utwórz amxbansa</a>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($this->data['sbans'])) : ?>
                            <div class="col-md-5 offset-md-1">
                                <span class="display-6"><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;Dane bazy danych SOURCEBANS</span>
                                <div class="col-md-8 mb-1 mt-2">
                                    <label>Host</label>
                                    <input type="text" class="form-control" value="<?= $this->data['sbans']['bans_host']; ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Użytkownik</label>
                                    <input type="text" class="form-control" value="<?= $this->data['sbans']['bans_user']; ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Hasło</label>
                                    <input type="text" class="form-control" value="<?= $this->data['sbans']['bans_password']; ?>" readonly />
                                </div>
                                <div class="col-md-8 mb-1">
                                    <label>Baza danych</label>
                                    <input type="text" class="form-control" value="<?= $this->data['sbans']['bans_database']; ?>" readonly />
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="col">
                                <a href="<?= base_url() . '/user/createSB'; ?>" class="btn btn-secondary mb-1 mt-2"><i class="fa fa-plus" aria-hidden="true"></i> Utwórz sourcebansa</a>
                            </div>
                        <?php endif; ?>
                        <div class="text-center mb-3">
                            <img class="img-content img-fluid" src="assets/img/cpu-tower.svg" />
                        </div>
                        <div class="col-md-6">
                            <span class="display-6"><i class="fa fa-server" aria-hidden="true"></i>&nbsp;&nbsp;Gotowa paczka do wgrania na serwer</span>
                        </div>
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-3">
                                <a href="<?= base_url() . '/user/download16'; ?>" class="btn btn-secondary mb-1 mt-2"><i class="fa fa-download" aria-hidden="true"></i> Pobierz
                                    paczke 1.6</a>
                            </div>
                            <div class="col-md-3">
                                <a href="<?= base_url() . '/user/downloadgo'; ?>" class="btn btn-secondary mb-1 mt-2"><i class="fa fa-download" aria-hidden="true"></i> Pobierz
                                    paczke GO</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>