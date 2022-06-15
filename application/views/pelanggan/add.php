<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-white">
                <div class="row">
                    <div class="col d-flex">
                        <h3 class="h5 mb-0 card-title align-self-center">
                            Tambah <?= $title; ?>
                        </h3>
                    </div>
                    <div class="col text-right">
                        <a href="<?= base_url('pelanggan') ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-chevron-left"></i> Batal
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= form_open(); ?>
                <div class="form-group">
                    <label for="namaPelanggan">Nama Pelanggan</label>
                    <input value="<?= set_value('namaPelanggan'); ?>" type="text" id="namaPelanggan"
                        name="namaPelanggan" class="form-control" placeholder="Nama Pelanggan...">
                    <?= form_error('namaPelanggan'); ?>
                </div>
                <div class="form-group">
                    <label for="alamatPelanggan">Alamat</label>
                    <input value="<?= set_value('alamatPelanggan'); ?>" type="text" id="alamatPelanggan"
                        name="alamatPelanggan" class="form-control" placeholder="Alamat Pelanggan...">
                    <?= form_error('alamatPelanggan'); ?>
                </div>
                <div class="form-group">
                    <label for="noTelp">No Telepon</label>
                    <input value="<?= set_value('noTelp'); ?>" type="text" id="noTelp" name="noTelp"
                        class="form-control" placeholder="No Telp...">
                    <?= form_error('noTelp'); ?>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>