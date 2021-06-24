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
                        <table class="table table-light table-striped text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Akcja</th>
                                    <th scope="col">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($logs as $log) : ?>
                                    <tr>
                                        <td><?= $log['action']; ?></td>
                                        <td><?= $log['timestamp']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>